<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Warehouse;
use App\Services\CartService;
use App\Services\OrderCheckoutEngine;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderCheckoutEngine $checkoutEngine;

    public function __construct(
        CartService $cartService,
        OrderCheckoutEngine $checkoutEngine
    ) {
        $this->cartService = $cartService;
        $this->checkoutEngine = $checkoutEngine;
    }

    /**
     * Trang Giỏ hàng chính thức của Khách hàng
     */
    public function cart(): View
    {
        $summary = $this->cartService->getSummary();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('cart.index', compact('summary', 'warehouses'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng (AJAX)
     */
    public function ajaxAdd(Request $request): JsonResponse
    {
        $request->validate([
            'variant_id' => 'required|integer|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $variantId = (int)$request->input('variant_id');
        $quantity = max(1, (int)$request->input('quantity', 1));

        $summary = $this->cartService->add($variantId, $quantity);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!',
            'cart' => $summary,
        ]);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng (AJAX)
     */
    public function ajaxUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'variant_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $summary = $this->cartService->update(
            (int)$request->input('variant_id'),
            (int)$request->input('quantity')
        );

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng!',
            'cart' => $summary,
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng (AJAX)
     */
    public function ajaxRemove(Request $request): JsonResponse
    {
        $request->validate([
            'variant_id' => 'required|integer',
        ]);

        $summary = $this->cartService->remove((int)$request->input('variant_id'));

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cart' => $summary,
        ]);
    }

    /**
     * Trả về thông tin tóm tắt giỏ hàng (cho Drawer hoặc Header)
     */
    public function ajaxSummary(Request $request): JsonResponse
    {
        $warehouseId = $request->has('warehouse_id') ? (int)$request->input('warehouse_id') : null;
        $summary = $this->cartService->getSummary($warehouseId);

        return response()->json([
            'success' => true,
            'cart' => $summary,
        ]);
    }

    /**
     * Trang Đặt hàng & Thanh toán (Checkout)
     */
    public function checkout(): View|RedirectResponse
    {
        $summary = $this->cartService->getSummary();

        if (empty($summary['items'])) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng chọn sản phẩm trước khi thanh toán!');
        }

        $warehouses = Warehouse::where('is_active', true)->get();

        return view('checkout.index', compact('summary', 'warehouses'));
    }

    /**
     * Xử lý xác nhận đặt hàng và tạo giao dịch thanh toán
     */
    public function processCheckout(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'shipping_recipient_name' => 'required|string|max:150',
            'shipping_phone' => 'required|string|min:9|max:20',
            'shipping_province' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_ward' => 'nullable|string|max:100',
            'shipping_address_line' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cash,bank_transfer,vnpay,momo,qr_code',
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',
            'notes' => 'nullable|string|max:500',
        ], [
            'shipping_recipient_name.required' => 'Vui lòng nhập họ và tên người nhận hàng.',
            'shipping_phone.required' => 'Vui lòng cung cấp số điện thoại liên hệ nhận hàng.',
            'shipping_province.required' => 'Vui lòng nhập Tỉnh/Thành phố nhận hàng.',
            'shipping_district.required' => 'Vui lòng nhập Quận/Huyện.',
            'shipping_address_line.required' => 'Vui lòng nhập địa chỉ cụ thể (số nhà, tên đường, thôn/xã).',
            'payment_method.required' => 'Vui lòng lựa chọn hình thức thanh toán.',
        ]);

        $rawCart = $this->cartService->getRawCart();
        if (empty($rawCart)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng trống. Vui lòng thêm sản phẩm.',
                ], 422);
            }
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $items = [];
        foreach ($rawCart as $variantId => $quantity) {
            $items[] = [
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ];
        }

        $warehouseId = $request->filled('warehouse_id')
            ? (int)$request->input('warehouse_id')
            : (Warehouse::where('is_active', true)->first()?->id ?? 1);

        $subtotal = $this->cartService->getSubtotal();
        $shippingFee = $this->cartService->getShippingFee($subtotal);

        $payload = [
            'channel' => 'customer_web',
            'warehouse_id' => $warehouseId,
            'items' => $items,
            'shipping_recipient_name' => trim($request->input('shipping_recipient_name')),
            'shipping_phone' => trim($request->input('shipping_phone')),
            'shipping_province' => trim($request->input('shipping_province')),
            'shipping_district' => trim($request->input('shipping_district')),
            'shipping_ward' => trim($request->input('shipping_ward') ?? ''),
            'shipping_address_line' => trim($request->input('shipping_address_line')),
            'discount_amount' => 0,
            'shipping_fee' => $shippingFee,
            'payment_method' => $request->input('payment_method', 'cash'),
            'notes' => $request->input('notes'),
            'idempotency_key' => $request->input('idempotency_key'),
        ];

        try {
            $order = $this->checkoutEngine->processCheckout($payload);

            // Xóa sạch giỏ hàng sau khi đơn hàng được ghi nhận và trừ tồn kho
            $this->cartService->clear();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Đặt hàng thành công! Mã đơn: {$order->code}",
                    'order_code' => $order->code,
                    'redirect_url' => route('don-hang.thanh-cong', $order->code),
                ]);
            }

            return redirect()->route('don-hang.thanh-cong', $order->code)
                ->with('success', "Đặt hàng thành công! Mã đơn hàng: {$order->code}");

        } catch (Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Trang Hoàn tất đặt hàng & Hóa đơn điện tử (Order Confirmation & Tracking)
     */
    public function orderSuccess(string $code): View
    {
        $order = Order::with(['items.variant.pesticide', 'payments.transactions', 'warehouse'])
            ->where('code', $code)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
