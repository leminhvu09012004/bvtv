<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\InventoryCount;
use App\Models\PurchaseReceipt;
use App\Models\StockIssue;
use App\Models\StockMovement;
use App\Models\StockTransfer;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryLedgerService
{
    /**
     * Ghi nhận một biến động kho bất biến vào Sổ Cái (Stock Movement) và cập nhật số dư tồn kho.
     * Bắt buộc thực hiện trong Database Transaction với Row-Level Lock.
     */
    public function recordMovement(
        int $warehouseId,
        int $variantId,
        string $type,
        int $quantityChange,
        int $unitCost,
        string $referenceType,
        int $referenceId,
        ?int $userId = null,
        ?int $destinationWarehouseId = null,
        ?string $notes = null
    ): StockMovement {
        // 1. Khóa bản ghi tồn kho tương ứng của chi nhánh (SELECT ... FOR UPDATE)
        $inventory = Inventory::where('warehouse_id', $warehouseId)
            ->where('variant_id', $variantId)
            ->lockForUpdate()
            ->first();

        if (!$inventory) {
            $inventory = Inventory::create([
                'warehouse_id' => $warehouseId,
                'variant_id' => $variantId,
                'quantity_on_hand' => 0,
                'quantity_reserved' => 0,
                'reorder_point' => 10,
            ]);
        }

        $balanceBefore = $inventory->quantity_on_hand;
        $balanceAfter = $balanceBefore + $quantityChange;

        // Chống âm kho đối với các tác vụ xuất
        if ($quantityChange < 0 && $balanceAfter < 0) {
            throw new Exception("Kho không đủ số lượng tồn khả dụng cho SKU biến thể ID {$variantId}. Tồn hiện tại: {$balanceBefore}, Cần xuất: " . abs($quantityChange));
        }

        // Cập nhật số dư kho
        $inventory->quantity_on_hand = $balanceAfter;
        $inventory->save();

        // 2. Ghi một dòng nhật ký bất biến vào Sổ Cái
        $movementCode = 'MV-' . strtoupper(Str::random(10));

        return StockMovement::create([
            'movement_code' => $movementCode,
            'warehouse_id' => $warehouseId,
            'destination_warehouse_id' => $destinationWarehouseId,
            'variant_id' => $variantId,
            'type' => $type,
            'quantity_change' => $quantityChange,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'unit_cost' => $unitCost,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'created_by' => $userId,
            'notes' => $notes,
            'created_at' => now(),
        ]);
    }

    /**
     * Duyệt Phiếu Nhập Kho (Purchase Receipt) và ghi sổ cái kho.
     */
    public function approvePurchaseReceipt(PurchaseReceipt $receipt, int $approverId): void
    {
        DB::transaction(function () use ($receipt, $approverId) {
            if ($receipt->status === 'approved') {
                throw new Exception("Phiếu nhập kho này đã được duyệt trước đó.");
            }

            $receipt->load('items');

            foreach ($receipt->items as $item) {
                $this->recordMovement(
                    warehouseId: $receipt->warehouse_id,
                    variantId: $item->variant_id,
                    type: 'purchase_receipt',
                    quantityChange: (int)$item->quantity,
                    unitCost: (int)$item->unit_cost,
                    referenceType: 'PurchaseReceipt',
                    referenceId: $receipt->id,
                    userId: $approverId,
                    notes: "Nhập kho theo phiếu {$receipt->receipt_code} từ {$receipt->supplier_name}"
                );
            }

            $receipt->status = 'approved';
            $receipt->approved_by = $approverId;
            $receipt->approved_at = now();
            $receipt->save();
        });
    }

    /**
     * Duyệt Phiếu Xuất Kho Nội Bộ / Xuất Hủy.
     */
    public function approveStockIssue(StockIssue $issue, int $approverId): void
    {
        DB::transaction(function () use ($issue, $approverId) {
            if ($issue->status === 'approved') {
                throw new Exception("Phiếu xuất kho này đã được duyệt.");
            }

            $issue->load('items');

            foreach ($issue->items as $item) {
                $this->recordMovement(
                    warehouseId: $issue->warehouse_id,
                    variantId: $item->variant_id,
                    type: 'damage_writeoff',
                    quantityChange: -((int)$item->quantity),
                    unitCost: (int)$item->unit_cost,
                    referenceType: 'StockIssue',
                    referenceId: $issue->id,
                    userId: $approverId,
                    notes: "Xuất kho theo phiếu {$issue->issue_code} lý do: {$issue->reason}"
                );
            }

            $issue->status = 'approved';
            $issue->approved_by = $approverId;
            $issue->approved_at = now();
            $issue->save();
        });
    }

    /**
     * Xuất điều chuyển kho (Dispatched).
     */
    public function dispatchStockTransfer(StockTransfer $transfer, int $userId): void
    {
        DB::transaction(function () use ($transfer, $userId) {
            if ($transfer->status !== 'draft') {
                throw new Exception("Trạng thái chuyển kho không hợp lệ để xuất đi.");
            }

            $transfer->load('items');

            foreach ($transfer->items as $item) {
                $this->recordMovement(
                    warehouseId: $transfer->from_warehouse_id,
                    variantId: $item->variant_id,
                    type: 'stock_transfer_out',
                    quantityChange: -((int)$item->quantity),
                    unitCost: 0,
                    referenceType: 'StockTransfer',
                    referenceId: $transfer->id,
                    userId: $userId,
                    destinationWarehouseId: $transfer->to_warehouse_id,
                    notes: "Xuất chuyển kho {$transfer->transfer_code}"
                );
            }

            $transfer->status = 'dispatched';
            $transfer->dispatched_at = now();
            $transfer->save();
        });
    }

    /**
     * Nhận hàng chuyển kho tại kho đích (Received).
     */
    public function receiveStockTransfer(StockTransfer $transfer, array $receivedQuantities = [], ?int $userId = null): void
    {
        $userId = $userId ?? auth()->id() ?? 1;
        DB::transaction(function () use ($transfer, $receivedQuantities, $userId) {
            if ($transfer->status !== 'dispatched') {
                throw new Exception("Chuyến hàng chưa được xuất đi để nhận.");
            }

            $transfer->load('items');

            foreach ($transfer->items as $item) {
                $qty = $receivedQuantities[$item->id] ?? $item->quantity;
                $item->received_quantity = $qty;
                $item->save();

                $this->recordMovement(
                    warehouseId: $transfer->to_warehouse_id,
                    variantId: $item->variant_id,
                    type: 'stock_transfer_in',
                    quantityChange: (int)$qty,
                    unitCost: 0,
                    referenceType: 'StockTransfer',
                    referenceId: $transfer->id,
                    userId: $userId,
                    destinationWarehouseId: null,
                    notes: "Nhập nhận hàng chuyển kho {$transfer->transfer_code}"
                );
            }

            $transfer->status = 'received';
            $transfer->received_at = now();
            $transfer->save();
        });
    }

    /**
     * Cân bằng kho sau kiểm kê (Inventory Count Reconciliation).
     */
    public function reconcileInventoryCount(InventoryCount $count, int $reconcilerId): void
    {
        DB::transaction(function () use ($count, $reconcilerId) {
            if ($count->status === 'reconciled') {
                throw new Exception("Phiếu kiểm kê này đã được cân bằng.");
            }

            $count->load('items');

            foreach ($count->items as $item) {
                $diff = (int)$item->difference;
                if ($diff !== 0) {
                    $this->recordMovement(
                        warehouseId: $count->warehouse_id,
                        variantId: $item->variant_id,
                        type: 'count_adjustment',
                        quantityChange: $diff,
                        unitCost: 0,
                        referenceType: 'InventoryCount',
                        referenceId: $count->id,
                        userId: $reconcilerId,
                        notes: "Điều chỉnh chênh lệch kiểm kê {$count->count_code} (Lệch: {$diff})"
                    );
                }
            }

            $count->status = 'reconciled';
            $count->reconciled_by = $reconcilerId;
            $count->reconciled_at = now();
            $count->save();
        });
    }
}
