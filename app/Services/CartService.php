<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;

class CartService
{
    protected const SESSION_KEY = 'customer_cart';
    protected MixingCompatibilityService $mixingService;

    public function __construct(MixingCompatibilityService $mixingService)
    {
        $this->mixingService = $mixingService;
    }

    /**
     * Lấy mảng raw trong session: [variant_id => quantity]
     */
    public function getRawCart(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(int $variantId, int $quantity = 1): array
    {
        $cart = $this->getRawCart();
        $quantity = max(1, $quantity);

        if (isset($cart[$variantId])) {
            $cart[$variantId] += $quantity;
        } else {
            $cart[$variantId] = $quantity;
        }

        session()->put(self::SESSION_KEY, $cart);
        return $this->getSummary();
    }

    /**
     * Cập nhật số lượng của một biến thể
     */
    public function update(int $variantId, int $quantity): array
    {
        $cart = $this->getRawCart();

        if ($quantity <= 0) {
            unset($cart[$variantId]);
        } else {
            $cart[$variantId] = $quantity;
        }

        session()->put(self::SESSION_KEY, $cart);
        return $this->getSummary();
    }

    /**
     * Xóa biến thể khỏi giỏ hàng
     */
    public function remove(int $variantId): array
    {
        $cart = $this->getRawCart();
        unset($cart[$variantId]);
        session()->put(self::SESSION_KEY, $cart);
        return $this->getSummary();
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Đếm tổng số lượng món trong giỏ
     */
    public function getCount(): int
    {
        $cart = $this->getRawCart();
        return array_sum($cart);
    }

    /**
     * Lấy danh sách chi tiết các mặt hàng trong giỏ kèm giá, ảnh và tồn kho
     */
    public function getItems(?int $warehouseId = null): Collection
    {
        $cart = $this->getRawCart();
        if (empty($cart)) {
            return collect();
        }

        $variantIds = array_keys($cart);
        $variants = ProductVariant::with(['pesticide.category', 'inventories.warehouse'])
            ->whereIn('id', $variantIds)
            ->get()
            ->keyBy('id');

        $items = collect();

        foreach ($cart as $variantId => $quantity) {
            $variant = $variants->get($variantId);
            if (!$variant) {
                continue;
            }

            $unitPrice = $variant->effective_price;
            $lineTotal = $unitPrice * $quantity;

            // Tính tồn kho khả dụng
            $stockAvailable = 0;
            if ($warehouseId) {
                $inv = $variant->inventories->firstWhere('warehouse_id', $warehouseId);
                $stockAvailable = $inv ? (int)$inv->quantity_available : 0;
            } else {
                $stockAvailable = (int)$variant->inventories->sum('quantity_available');
            }

            $items->push([
                'variant_id' => $variant->id,
                'variant' => $variant,
                'pesticide' => $variant->pesticide,
                'name' => $variant->pesticide ? $variant->pesticide->name : 'Sản phẩm',
                'specification' => $variant->specification,
                'sku' => $variant->sku,
                'unit' => $variant->unit ?? 'chai/gói',
                'unit_price' => $unitPrice,
                'formatted_price' => number_format($unitPrice, 0, ',', '.') . ' ₫',
                'quantity' => $quantity,
                'line_total' => $lineTotal,
                'formatted_line_total' => number_format($lineTotal, 0, ',', '.') . ' ₫',
                'image_url' => $variant->image ?: ($variant->pesticide ? $variant->pesticide->image_url : null),
                'stock_available' => $stockAvailable,
                'is_in_stock' => $stockAvailable >= $quantity,
            ]);
        }

        return $items;
    }

    /**
     * Tổng tiền hàng trước chiết khấu và phí ship
     */
    public function getSubtotal(): int
    {
        $items = $this->getItems();
        return (int)$items->sum('line_total');
    }

    /**
     * Tính phí giao hàng (Ví dụ: Miễn phí cho đơn >= 500k, dưới 500k là 30.000đ)
     */
    public function getShippingFee(?int $subtotal = null): int
    {
        $subtotal = $subtotal ?? $this->getSubtotal();
        if ($subtotal === 0) {
            return 0;
        }
        return $subtotal >= 500000 ? 0 : 30000;
    }

    /**
     * Tổng tiền cần thanh toán
     */
    public function getTotal(?int $warehouseId = null): int
    {
        $subtotal = $this->getSubtotal();
        return $subtotal + $this->getShippingFee($subtotal);
    }

    /**
     * Kiểm tra tương kỵ các sản phẩm trong giỏ hàng (Tank-Mix Pre-check)
     */
    public function checkMixingAlerts(): array
    {
        $items = $this->getItems();
        $pesticides = $items->map(fn($item) => $item['pesticide'])->filter()->unique('id')->values();

        $alerts = [];

        if ($pesticides->count() >= 2) {
            for ($i = 0; $i < $pesticides->count(); $i++) {
                for ($j = $i + 1; $j < $pesticides->count(); $j++) {
                    $p1 = $pesticides[$i];
                    $p2 = $pesticides[$j];

                    $res = $this->mixingService->checkPair($p1, $p2);
                    if (in_array($res['status'], ['danger', 'FORBIDDEN', 'AVOID'], true)) {
                        $alerts[] = [
                            'product_1' => $p1->name,
                            'product_2' => $p2->name,
                            'status' => $res['status'],
                            'title' => $res['title'] ?? ($res['status'] === 'FORBIDDEN' ? 'Cấm kỵ phối trộn' : 'Thận trọng khi trộn'),
                            'reason' => $res['conflicts'][0]['reason'] ?? 'Có tương kỵ hóa học hoặc vật lý khi pha chung',
                            'advice' => $res['conflicts'][0]['advice'] ?? 'Nên phun riêng rẽ từng loại để đảm bảo an toàn cho cây trồng',
                            'source_reference' => $res['conflicts'][0]['source_reference'] ?? null,
                        ];
                    }
                }
            }
        }

        return $alerts;
    }

    /**
     * Trả về tóm tắt giỏ hàng hoàn chỉnh
     */
    public function getSummary(?int $warehouseId = null): array
    {
        $items = $this->getItems($warehouseId);
        $subtotal = (int)$items->sum('line_total');
        $shippingFee = $this->getShippingFee($subtotal);
        $total = $subtotal + $shippingFee;
        $count = (int)$items->sum('quantity');
        $alerts = $this->checkMixingAlerts();

        return [
            'count' => $count,
            'items' => $items->values()->toArray(),
            'subtotal' => $subtotal,
            'formatted_subtotal' => number_format($subtotal, 0, ',', '.') . ' ₫',
            'shipping_fee' => $shippingFee,
            'formatted_shipping_fee' => $shippingFee === 0 ? 'Miễn phí' : number_format($shippingFee, 0, ',', '.') . ' ₫',
            'total' => $total,
            'formatted_total' => number_format($total, 0, ',', '.') . ' ₫',
            'mixing_alerts' => $alerts,
            'has_mixing_warning' => !empty($alerts),
        ];
    }
}
