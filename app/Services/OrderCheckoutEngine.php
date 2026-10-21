<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderCheckoutEngine
{
    protected InventoryLedgerService $inventoryService;
    protected MixingCompatibilityService $mixingService;

    public function __construct(
        InventoryLedgerService $inventoryService,
        MixingCompatibilityService $mixingService
    ) {
        $this->inventoryService = $inventoryService;
        $this->mixingService = $mixingService;
    }

    /**
     * Thực thi thanh toán đơn hàng (POS hoặc Web) với quy chuẩn bảo mật:
     * - Server-side price authority (hoàn toàn không tin giá client).
     * - Row-level locking kiểm tra tồn kho (chống âm kho).
     * - Idempotency key (chống double-checkout).
     * - Ghi nhận Sổ Cái Biến Động Kho tức thời.
     */
    public function processCheckout(array $payload, ?int $cashierOrUserId = null): Order
    {
        $cashierOrUserId = $cashierOrUserId ?? auth()->id() ?? \App\Models\User::first()?->id ?? 1;
        $idempotencyKey = $payload['idempotency_key'] ?? (string)Str::uuid();

        // 1. Kiểm tra Idempotency chống double-checkout
        $existingTrans = PaymentTransaction::where('idempotency_key', $idempotencyKey)->first();
        if ($existingTrans) {
            return $existingTrans->payment->order;
        }

        return DB::transaction(function () use ($payload, $cashierOrUserId, $idempotencyKey) {
            $warehouseId = (int)($payload['warehouse_id'] ?? 1);
            $channel = $payload['channel'] ?? 'pos';
            $itemsPayload = $payload['items'] ?? [];

            if (empty($itemsPayload)) {
                throw new Exception("Đơn hàng phải chứa ít nhất 1 sản phẩm.");
            }

            $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $subtotal = 0;
            $orderItemsToCreate = [];
            $pesticidesInOrder = [];

            // 2. Thẩm định từng sản phẩm và lấy giá chuẩn từ Server
            foreach ($itemsPayload as $item) {
                $variantId = (int)$item['variant_id'];
                $quantity = max(1, (int)$item['quantity']);

                $variant = ProductVariant::with('pesticide')->findOrFail($variantId);

                if ($variant->status !== 'active') {
                    throw new Exception("Biến thể [{$variant->sku}] hiện đã ngừng kinh doanh.");
                }

                // Kiểm tra tồn kho khả dụng tại kho xuất (Pessimistic row-level lock)
                $inv = Inventory::where('warehouse_id', $warehouseId)
                    ->where('variant_id', $variantId)
                    ->lockForUpdate()
                    ->first();

                $available = $inv ? (int)$inv->quantity_available : 0;
                if ($available < $quantity) {
                    throw new Exception("Không đủ tồn kho khả dụng cho sản phẩm [{$variant->sku}]. Yêu cầu: {$quantity}, tồn: {$available}");
                }

                // SERVER-SIDE PRICE AUTHORITY: Lấy giá niêm yết từ DB, tuyệt đối không dùng giá Client gửi lên
                $unitPrice = $variant->effective_price;
                $lineTotal = $unitPrice * $quantity;
                $subtotal += $lineTotal;

                $orderItemsToCreate[] = [
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'unit_cost' => $variant->cost_price,
                    'line_total' => $lineTotal,
                ];

                if ($variant->pesticide) {
                    $pesticidesInOrder[] = $variant->pesticide;
                }
            }

            // 3. Tính toán chiết khấu hợp lệ (Server-Side)
            $discountAmount = min($subtotal, max(0, (int)($payload['discount_amount'] ?? 0)));
            $shippingFee = max(0, (int)($payload['shipping_fee'] ?? 0));
            $totalAmount = max(0, $subtotal - $discountAmount + $shippingFee);

            // 4. Kiểm tra tương kỵ thuốc tự động trong giỏ (Tank-Mix Pre-check)
            $mixingWarningNote = null;
            if (count($pesticidesInOrder) >= 2) {
                for ($i = 0; $i < count($pesticidesInOrder); $i++) {
                    for ($j = $i + 1; $j < count($pesticidesInOrder); $j++) {
                        $check = $this->mixingService->checkPair($pesticidesInOrder[$i], $pesticidesInOrder[$j]);
                        if (in_array($check['status'], ['danger', 'FORBIDDEN', 'AVOID'], true)) {
                            $mixingWarningNote = "⚠️ LƯU Ý KỸ THUẬT: Đơn có cặp thuốc [{$pesticidesInOrder[$i]->name}] và [{$pesticidesInOrder[$j]->name}] có tương kỵ. Dặn khách không pha chung cùng bình!";
                            break 2;
                        }
                    }
                }
            }

            // 5. Tạo đơn hàng (Kèm snapshot địa chỉ và thông tin khách hàng)
            $order = Order::create([
                'code' => $orderCode,
                'channel' => $channel,
                'warehouse_id' => $warehouseId,
                'cashier_id' => $channel === 'pos' ? $cashierOrUserId : null,
                'customer_profile_id' => $payload['customer_profile_id'] ?? null,
                'shipping_recipient_name' => $payload['shipping_recipient_name'] ?? 'Khách mua tại quầy POS',
                'shipping_phone' => $payload['shipping_phone'] ?? '0988888888',
                'shipping_address_line' => $payload['shipping_address_line'] ?? 'Bán trực tiếp tại quầy',
                'shipping_ward' => $payload['shipping_ward'] ?? null,
                'shipping_district' => $payload['shipping_district'] ?? null,
                'shipping_province' => $payload['shipping_province'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_reason' => $payload['discount_reason'] ?? null,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'payment_status' => 'paid',
                'fulfillment_status' => 'fulfilled',
                'mixing_warning_acknowledged' => !empty($mixingWarningNote),
                'notes' => trim(($payload['notes'] ?? '') . "\n" . ($mixingWarningNote ?? '')),
            ]);

            // 6. Tạo Order Items và ghi nhận trừ kho qua Sổ Cái Bất Biến
            foreach ($orderItemsToCreate as $itemData) {
                $variant = $itemData['variant'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'product_name' => $variant->pesticide->name,
                    'variant_sku' => $variant->sku,
                    'specification' => $variant->specification,
                    'unit_cost_price' => $itemData['unit_cost'],
                    'unit_price' => $itemData['unit_price'],
                    'quantity' => $itemData['quantity'],
                    'line_total' => $itemData['line_total'],
                ]);

                // Xuất kho và ghi sổ cái (Row-level lock & chống âm kho tự động trong InventoryService)
                $this->inventoryService->recordMovement(
                    warehouseId: $warehouseId,
                    variantId: $variant->id,
                    type: $channel === 'pos' ? 'pos_sale' : 'online_sale',
                    quantityChange: -((int)$itemData['quantity']),
                    unitCost: $itemData['unit_cost'],
                    referenceType: 'Order',
                    referenceId: $order->id,
                    userId: $cashierOrUserId,
                    notes: "Xuất bán theo đơn {$order->code}"
                );
            }

            // 7. Tạo bản ghi Thanh toán và Giao dịch Cổng (Payment & PaymentTransaction)
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_code' => 'PAY-' . strtoupper(Str::random(8)),
                'amount' => $totalAmount,
                'status' => 'completed',
            ]);

            $method = $payload['payment_method'] ?? 'cash';
            if (!in_array($method, ['cash', 'bank_transfer', 'vnpay', 'momo', 'qr_code'], true)) {
                $method = 'cash';
            }

            PaymentTransaction::create([
                'payment_id' => $payment->id,
                'transaction_reference' => 'TXN-' . strtoupper(Str::random(10)),
                'method' => $method,
                'amount' => $totalAmount,
                'status' => 'success',
                'provider_response_payload' => [
                    'received_amount' => $payload['received_amount'] ?? $totalAmount,
                    'change_amount' => max(0, ((int)($payload['received_amount'] ?? $totalAmount)) - $totalAmount),
                    'terminal' => 'POS-WEB-01',
                ],
                'idempotency_key' => $idempotencyKey,
            ]);

            return $order->load(['items.variant', 'payments.transactions']);
        });
    }
}
