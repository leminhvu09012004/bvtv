<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use App\Services\OrderCheckoutEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PosController extends Controller
{
    protected OrderCheckoutEngine $checkoutEngine;

    public function __construct(OrderCheckoutEngine $checkoutEngine)
    {
        $this->checkoutEngine = $checkoutEngine;
    }

    /**
     * Giao diện Staff Quick POS toàn màn hình với bố cục:
     * - Trái (62%): Lưới sản phẩm & variant, tìm kiếm tức thì, quét barcode.
     * - Phải (38%): Giỏ hàng thanh toán, phím tắt F2/F4/F6/F12, in bill 80mm.
     */
    public function index(Request $request): View
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $selectedWarehouseId = (int) $request->query('warehouse_id', $warehouses->first()?->id ?? 1);
        $selectedWarehouse = $warehouses->firstWhere('id', $selectedWarehouseId) ?? $warehouses->first();

        // Tải các variant và tồn kho tương ứng
        $variants = ProductVariant::with(['pesticide.category'])
            ->where('status', 'active')
            ->get()
            ->map(function ($variant) use ($selectedWarehouseId) {
                $inv = Inventory::where('warehouse_id', $selectedWarehouseId)
                    ->where('variant_id', $variant->id)
                    ->first();

                return [
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'barcode' => $variant->barcode,
                    'name' => $variant->pesticide->name . ' (' . ($variant->specification ?? 'Tiêu chuẩn') . ')',
                    'pesticide_name' => $variant->pesticide->name,
                    'variant_name' => $variant->specification ?? 'Tiêu chuẩn',
                    'price' => (int) $variant->effective_price,
                    'stock' => $inv ? max(0, (int) $inv->quantity_available) : 0,
                    'category' => $variant->pesticide->category?->name ?? 'Thuốc BVTV',
                    'category_emoji' => $variant->pesticide->category?->emoji ?? '🌿',
                    'active_ingredient' => $variant->pesticide->active_ingredient,
                    'image' => $variant->pesticide->image_url,
                    'frac_code' => $variant->pesticide->frac_code,
                    'irac_code' => $variant->pesticide->irac_code,
                ];
            });

        return view('pos.index', compact('warehouses', 'selectedWarehouse', 'variants'));
    }

    /**
     * Tìm kiếm nhanh sản phẩm theo barcode / SKU / Tên / Hoạt chất
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        $warehouseId = (int) $request->input('warehouse_id', 1);

        $query = ProductVariant::with(['pesticide.category'])
            ->where('status', 'active');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('barcode', $q)
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('specification', 'like', "%{$q}%")
                    ->orWhereHas('pesticide', function ($p) use ($q) {
                        $p->where('name', 'like', "%{$q}%")
                          ->orWhere('active_ingredient', 'like', "%{$q}%");
                    });
            });
        }

        $results = $query->take(30)->get()->map(function ($variant) use ($warehouseId) {
            $inv = Inventory::where('warehouse_id', $warehouseId)
                ->where('variant_id', $variant->id)
                ->first();

            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'barcode' => $variant->barcode,
                'name' => $variant->pesticide->name . ' (' . ($variant->specification ?? 'Tiêu chuẩn') . ')',
                'pesticide_name' => $variant->pesticide->name,
                'variant_name' => $variant->specification ?? 'Tiêu chuẩn',
                'price' => (int) $variant->effective_price,
                'stock' => $inv ? max(0, (int) $inv->quantity_available) : 0,
                'category' => $variant->pesticide->category?->name ?? 'Thuốc BVTV',
                'category_emoji' => $variant->pesticide->category?->emoji ?? '🌿',
                'active_ingredient' => $variant->pesticide->active_ingredient,
                'image' => $variant->pesticide->image_url,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    /**
     * Xử lý thanh toán đơn hàng tại quầy POS với cơ chế Server Authority:
     * - Khóa dòng tồn kho (lockForUpdate)
     * - Kiểm tra SKU, giá, tồn kho thực tế
     * - Trừ kho ghi nhận StockMovement
     * - Tạo giao dịch thanh toán
     */
    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'discount_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:CASH,BANK_TRANSFER,QR,VNPAY,MOMO',
            'cash_tendered' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'idempotency_key' => 'nullable|string|max:64',
        ]);

        try {
            $order = $this->checkoutEngine->processCheckout([
                'channel' => 'pos',
                'warehouse_id' => (int) $validated['warehouse_id'],
                'items' => $validated['items'],
                'customer_name' => $validated['customer_name'] ?? 'Khách lẻ tại quầy',
                'customer_phone' => $validated['customer_phone'] ?? '0900000000',
                'shipping_address' => 'Mua trực tiếp tại quầy',
                'shipping_province' => 'Đắk Lắk',
                'payment_method' => $validated['payment_method'],
                'discount_amount' => (float) ($validated['discount_amount'] ?? 0),
                'notes' => $validated['notes'] ?? 'Đơn hàng POS',
                'idempotency_key' => $validated['idempotency_key'] ?? ('POS-' . uniqid()),
            ]);

            $order->load(['items.variant.pesticide', 'payments.transactions', 'warehouse']);

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán đơn hàng thành công!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->code,
                    'total_amount' => (int) $order->total_amount,
                    'subtotal_amount' => (int) $order->subtotal,
                    'discount_amount' => (int) $order->discount_amount,
                    'customer_name' => $order->shipping_recipient_name,
                    'created_at' => $order->created_at->format('d/m/Y H:i'),
                    'warehouse_name' => $order->warehouse?->name,
                    'items' => $order->items->map(fn($item) => [
                        'name' => $item->product_name . ' (' . ($item->specification ?? '') . ')',
                        'sku' => $item->variant_sku,
                        'unit_price' => (int) $item->unit_price,
                        'quantity' => (int) $item->quantity,
                        'total_price' => (int) $item->line_total,
                    ]),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xử lý thanh toán: ' . $e->getMessage(),
            ], 500);
        }
    }
}
