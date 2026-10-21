<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryCount;
use App\Models\ProductVariant;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use App\Models\StockIssue;
use App\Models\StockIssueItem;
use App\Models\StockMovement;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\Warehouse;
use App\Services\InventoryLedgerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InventoryController extends Controller
{
    protected InventoryLedgerService $ledgerService;

    public function __construct(InventoryLedgerService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    /**
     * Tổng quan Tồn Kho Đa Điểm (Multi-Warehouse Inventory Overview)
     */
    public function index(Request $request): View|JsonResponse
    {
        $warehouses = Warehouse::withCount('inventories')->where('is_active', true)->get();
        $selectedWarehouseId = $request->query('warehouse_id');

        $query = Inventory::with(['warehouse', 'variant.pesticide.category']);

        if ($selectedWarehouseId) {
            $query->where('warehouse_id', (int) $selectedWarehouseId);
        }

        if ($q = trim((string) $request->query('q', ''))) {
            $query->whereHas('variant', function ($v) use ($q) {
                $v->where('sku', 'like', "%{$q}%")
                  ->orWhere('barcode', 'like', "%{$q}%")
                  ->orWhereHas('pesticide', function ($p) use ($q) {
                      $p->where('name', 'like', "%{$q}%")
                        ->orWhere('active_ingredient', 'like', "%{$q}%");
                  });
            });
        }

        if ($request->query('low_stock') === '1') {
            $query->whereRaw('quantity_on_hand - quantity_reserved <= reorder_point');
        }

        $inventories = $query->paginate(25)->withQueryString();

        // Thống kê nhanh
        $totalItems = Inventory::sum('quantity_on_hand');
        $lowStockCount = Inventory::whereRaw('quantity_on_hand - quantity_reserved <= reorder_point')->count();
        $totalSkuCount = Inventory::distinct('variant_id')->count('variant_id');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.inventory.partials.table', compact('inventories'))->render(),
                'stats' => [
                    'totalItems' => number_format($totalItems),
                    'lowStockCount' => number_format($lowStockCount),
                    'totalSkuCount' => number_format($totalSkuCount),
                ],
                'pagination' => [
                    'total' => $inventories->total(),
                    'current_page' => $inventories->currentPage(),
                    'last_page' => $inventories->lastPage(),
                ]
            ]);
        }

        return view('admin.inventory.index', compact(
            'warehouses',
            'selectedWarehouseId',
            'inventories',
            'totalItems',
            'lowStockCount',
            'totalSkuCount'
        ));
    }

    /**
     * Sổ Cái Biến Động Kho Bất Biến (Immutable Stock Movements Ledger)
     */
    public function movements(Request $request): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();

        $query = StockMovement::with(['warehouse', 'destinationWarehouse', 'variant.pesticide', 'creator'])
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        if ($whId = $request->query('warehouse_id')) {
            $query->where('warehouse_id', (int) $whId);
        }

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        if ($q = trim((string) $request->query('q', ''))) {
            $query->where(function ($sub) use ($q) {
                $sub->where('movement_code', 'like', "%{$q}%")
                    ->orWhereHas('variant', function ($v) use ($q) {
                        $v->where('sku', 'like', "%{$q}%")
                          ->orWhereHas('pesticide', fn($p) => $p->where('name', 'like', "%{$q}%"));
                    });
            });
        }

        $movements = $query->paginate(30)->withQueryString();

        return view('admin.inventory.movements', compact('movements', 'warehouses'));
    }

    /**
     * Danh sách Phiếu Chuyển Kho Liên Chi Nhánh (Stock Transfers)
     */
    public function transfers(): View
    {
        $transfers = StockTransfer::with(['fromWarehouse', 'toWarehouse', 'creator', 'items.variant.pesticide'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $variants = ProductVariant::with('pesticide')->orderBy('id')->get();

        return view('admin.inventory.transfers', compact('transfers', 'warehouses', 'variants'));
    }

    /**
     * Tạo Phiếu Chuyển Kho Mới
     */
    public function storeTransfer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'from_warehouse_id' => ['required', 'exists:warehouses,id'],
            'to_warehouse_id'   => ['required', 'exists:warehouses,id', 'different:from_warehouse_id'],
            'notes'             => ['nullable', 'string', 'max:500'],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.variant_id'=> ['required', 'exists:product_variants,id'],
            'items.*.quantity'  => ['required', 'integer', 'min:1'],
        ], [
            'from_warehouse_id.required'  => 'Vui lòng chọn kho xuất nguồn.',
            'to_warehouse_id.required'    => 'Vui lòng chọn kho đích tiếp nhận.',
            'to_warehouse_id.different'   => 'Kho đích tiếp nhận phải khác với kho xuất hàng.',
            'items.required'              => 'Vui lòng chọn ít nhất một sản phẩm cần chuyển kho.',
            'items.*.quantity.min'        => 'Số lượng chuyển phải lớn hơn 0.',
        ]);

        try {
            DB::beginTransaction();

            $transferCode = 'CK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $transfer = StockTransfer::create([
                'transfer_code'     => $transferCode,
                'from_warehouse_id' => $validated['from_warehouse_id'],
                'to_warehouse_id'   => $validated['to_warehouse_id'],
                'status'            => 'draft',
                'notes'             => $validated['notes'] ?? null,
                'created_by'        => auth()->id() ?? 1,
            ]);

            foreach ($validated['items'] as $itemData) {
                StockTransferItem::create([
                    'stock_transfer_id' => $transfer->id,
                    'variant_id'        => $itemData['variant_id'],
                    'quantity'          => (int) $itemData['quantity'],
                    'received_quantity' => 0,
                ]);
            }

            // Nếu người dùng chọn xuất kho chuyển đi ngay
            if ($request->boolean('dispatch_now')) {
                $this->ledgerService->dispatchStockTransfer($transfer, auth()->id() ?? 1);
            }

            DB::commit();

            $msg = $request->boolean('dispatch_now')
                ? "Đã tạo phiếu {$transfer->transfer_code} và xuất hàng vận chuyển thành công!"
                : "Đã tạo bản nháp phiếu chuyển kho {$transfer->transfer_code} thành công!";

            return redirect()->route('admin.inventory.transfers')->with('success', $msg);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi tạo phiếu chuyển kho: ' . $e->getMessage());
        }
    }

    /**
     * Xuất kho chuyển đi (Dispatch Stock Transfer)
     */
    public function dispatchTransfer(Request $request, StockTransfer $transfer): JsonResponse|RedirectResponse
    {
        try {
            $this->ledgerService->dispatchStockTransfer($transfer, auth()->id() ?? 1);
            $message = "Đã xuất điều chuyển kho thành công theo phiếu {$transfer->transfer_code}!";
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => 'dispatched',
                    'status_label' => 'Đang vận chuyển',
                ]);
            }
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', "Lỗi điều chuyển: " . $e->getMessage());
        }
    }

    /**
     * Nhận kho chuyển đến (Receive Stock Transfer)
     */
    public function receiveTransfer(Request $request, StockTransfer $transfer): JsonResponse|RedirectResponse
    {
        try {
            $this->ledgerService->receiveStockTransfer($transfer, [], auth()->id() ?? 1);
            $message = "Đã xác nhận nhập kho thành công cho phiếu {$transfer->transfer_code}!";
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => 'completed',
                    'status_label' => 'Đã nhập kho',
                ]);
            }
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', "Lỗi xác nhận nhập kho: " . $e->getMessage());
        }
    }

    /**
     * Danh sách Phiếu Nhập Kho (Purchase Receipts)
     */
    public function receipts(): View
    {
        $receipts = PurchaseReceipt::with(['warehouse', 'creator', 'approver', 'items.variant.pesticide'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $variants = ProductVariant::with('pesticide')->orderBy('id')->get();

        return view('admin.inventory.receipts', compact('receipts', 'warehouses', 'variants'));
    }

    /**
     * Tạo Phiếu Nhập Hàng Mới Từ Nhà Cung Cấp
     */
    public function storeReceipt(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'warehouse_id'      => ['required', 'exists:warehouses,id'],
            'supplier_name'     => ['nullable', 'string', 'max:191'],
            'notes'             => ['nullable', 'string', 'max:500'],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.variant_id'=> ['required', 'exists:product_variants,id'],
            'items.*.quantity'  => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'integer', 'min:0'],
        ], [
            'warehouse_id.required'  => 'Vui lòng chọn kho hàng nhập.',
            'items.required'         => 'Vui lòng chọn ít nhất một sản phẩm cần nhập kho.',
            'items.*.quantity.min'   => 'Số lượng nhập phải lớn hơn 0.',
            'items.*.unit_cost.min'  => 'Đơn giá nhập không hợp lệ.',
        ]);

        try {
            DB::beginTransaction();

            $receiptCode = 'NK-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $totalAmount = 0;

            foreach ($validated['items'] as $itemData) {
                $totalAmount += ((int) $itemData['quantity'] * (int) $itemData['unit_cost']);
            }

            $receipt = PurchaseReceipt::create([
                'receipt_code' => $receiptCode,
                'warehouse_id' => $validated['warehouse_id'],
                'supplier_name'=> !empty($validated['supplier_name']) ? $validated['supplier_name'] : 'Nhập kho nội bộ',
                'status'       => 'draft',
                'total_amount' => $totalAmount,
                'notes'        => $validated['notes'] ?? null,
                'created_by'   => auth()->id() ?? 1,
            ]);

            foreach ($validated['items'] as $itemData) {
                $qty = (int) $itemData['quantity'];
                $cost = (int) $itemData['unit_cost'];
                PurchaseReceiptItem::create([
                    'purchase_receipt_id' => $receipt->id,
                    'variant_id'          => $itemData['variant_id'],
                    'quantity'            => $qty,
                    'unit_cost'           => $cost,
                    'line_total'          => $qty * $cost,
                ]);
            }

            // Nếu người dùng chọn duyệt nhập kho ngay
            if ($request->boolean('approve_now')) {
                $this->ledgerService->approvePurchaseReceipt($receipt, auth()->id() ?? 1);
            }

            DB::commit();

            $msg = $request->boolean('approve_now')
                ? "Đã tạo và duyệt nhập kho thành công phiếu {$receipt->receipt_code} (+{$totalAmount} ₫)!"
                : "Đã tạo phiếu nhập kho nháp {$receipt->receipt_code} thành công!";

            return redirect()->route('admin.inventory.receipts')->with('success', $msg);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi tạo phiếu nhập kho: ' . $e->getMessage());
        }
    }

    /**
     * Phê duyệt nhập kho (Approve Purchase Receipt)
     */
    public function approveReceipt(Request $request, PurchaseReceipt $receipt): JsonResponse|RedirectResponse
    {
        try {
            $this->ledgerService->approvePurchaseReceipt($receipt, auth()->id() ?? 1);
            $message = "Đã duyệt và nhập kho thành công theo phiếu {$receipt->receipt_code}!";
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => 'received',
                    'status_label' => 'Đã nhập kho',
                ]);
            }
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', "Lỗi duyệt nhập kho: " . $e->getMessage());
        }
    }

    /**
     * Phân hệ Xuất Kho Hàng Hóa (Stock Issues)
     */
    public function issues(Request $request): View
    {
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $variants = ProductVariant::with('pesticide')->orderBy('id')->get();

        $query = StockIssue::with(['warehouse', 'creator', 'items.variant.pesticide'])
            ->orderByDesc('created_at');

        if ($whId = $request->query('warehouse_id')) {
            $query->where('warehouse_id', (int) $whId);
        }

        if ($reason = $request->query('reason')) {
            $query->where('reason', $reason);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $issues = $query->paginate(20)->withQueryString();

        return view('admin.inventory.issues', compact('issues', 'warehouses', 'variants'));
    }

    /**
     * Tạo Phiếu Xuất Kho Mới (Xuất hủy, Trả hàng NCC, Sử dụng nội bộ, Mẫu thử)
     */
    public function storeIssue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'warehouse_id'      => ['required', 'exists:warehouses,id'],
            'reason'            => ['required', 'in:internal_use,damage_writeoff,supplier_return,sample'],
            'notes'             => ['nullable', 'string', 'max:500'],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.variant_id'=> ['required', 'exists:product_variants,id'],
            'items.*.quantity'  => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['nullable', 'integer', 'min:0'],
        ], [
            'warehouse_id.required' => 'Vui lòng chọn kho xuất hàng.',
            'reason.required'       => 'Vui lòng chọn lý do xuất kho.',
            'items.required'        => 'Vui lòng chọn ít nhất một sản phẩm cần xuất kho.',
            'items.*.quantity.min'  => 'Số lượng xuất kho phải lớn hơn 0.',
        ]);

        try {
            DB::beginTransaction();

            $issueCode = 'XK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $issue = StockIssue::create([
                'issue_code'   => $issueCode,
                'warehouse_id' => $validated['warehouse_id'],
                'reason'       => $validated['reason'],
                'status'       => 'draft',
                'notes'        => $validated['notes'] ?? null,
                'created_by'   => auth()->id() ?? 1,
            ]);

            foreach ($validated['items'] as $itemData) {
                StockIssueItem::create([
                    'stock_issue_id' => $issue->id,
                    'variant_id'     => $itemData['variant_id'],
                    'quantity'       => (int) $itemData['quantity'],
                    'unit_cost'      => (int) ($itemData['unit_cost'] ?? 0),
                ]);
            }

            // Nếu người dùng chọn phê duyệt và trừ tồn kho ngay
            if ($request->boolean('approve_now')) {
                $this->ledgerService->approveStockIssue($issue, auth()->id() ?? 1);
            }

            DB::commit();

            $msg = $request->boolean('approve_now')
                ? "Đã tạo và duyệt xuất kho thành công phiếu {$issue->issue_code} (đã ghi Sổ Cái trừ tồn kho)!"
                : "Đã tạo phiếu xuất kho nháp {$issue->issue_code} thành công!";

            return redirect()->route('admin.inventory.issues')->with('success', $msg);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi tạo phiếu xuất kho: ' . $e->getMessage());
        }
    }

    /**
     * Phê duyệt phiếu xuất kho nháp
     */
    public function approveIssue(Request $request, StockIssue $issue): JsonResponse|RedirectResponse
    {
        try {
            $this->ledgerService->approveStockIssue($issue, auth()->id() ?? 1);
            $message = "Đã duyệt và trừ tồn kho thành công theo phiếu {$issue->issue_code}!";
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => 'approved',
                    'status_label' => 'Đã duyệt xuất kho',
                ]);
            }
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', "Lỗi duyệt xuất kho: " . $e->getMessage());
        }
    }

    /**
     * Danh sách Phiếu Kiểm Kê (Inventory Counts)
     */
    public function counts(): View
    {
        $counts = InventoryCount::with(['warehouse', 'creator', 'reconciler', 'items.variant.pesticide'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.inventory.counts', compact('counts'));
    }

    /**
     * Cân đối chênh lệch kiểm kê (Reconcile Inventory Count)
     */
    public function reconcileCount(Request $request, InventoryCount $count): JsonResponse|RedirectResponse
    {
        try {
            $this->ledgerService->reconcileInventoryCount($count, auth()->id() ?? 1);
            $message = "Đã cân đối số dư sổ cái theo phiếu kiểm kê {$count->count_code}!";
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => 'reconciled',
                    'status_label' => 'Đã cân đối sổ',
                ]);
            }
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', "Lỗi cân đối kiểm kê: " . $e->getMessage());
        }
    }

    /**
     * Mẫu in ấn chứng từ Phiếu Xuất Kho chuẩn A4
     */
    public function printIssue(StockIssue $issue): View
    {
        $issue->load(['warehouse', 'creator', 'items.variant.pesticide']);
        return view('admin.inventory.print-issue', compact('issue'));
    }

    /**
     * AJAX Tìm kiếm nhanh sản phẩm biến thể phục vụ nhập/xuất/chuyển kho
     */
    public function ajaxSearchVariants(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        $warehouseId = (int) $request->input('warehouse_id', 0);

        $query = ProductVariant::with(['pesticide.category'])
            ->where('status', 'active');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('barcode', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('specification', 'like', "%{$q}%")
                    ->orWhereHas('pesticide', function ($p) use ($q) {
                        $p->where('name', 'like', "%{$q}%")
                          ->orWhere('active_ingredient', 'like', "%{$q}%");
                    });
            });
        }

        $results = $query->take(25)->get()->map(function ($v) use ($warehouseId) {
            $stock = 0;
            if ($warehouseId > 0) {
                $inv = Inventory::where('warehouse_id', $warehouseId)
                    ->where('variant_id', $v->id)
                    ->first();
                $stock = $inv ? max(0, (int) $inv->quantity_on_hand) : 0;
            }

            return [
                'id' => $v->id,
                'name' => $v->pesticide->name ?? 'Thuốc BVTV',
                'specification' => $v->specification ?? '',
                'sku' => $v->sku,
                'unit' => $v->unit ?: 'Chai/Gói',
                'cost_price' => (int) ($v->cost_price ?? 0),
                'selling_price' => (int) ($v->selling_price ?? 0),
                'stock' => $stock,
                'active_ingredient' => $v->pesticide->active_ingredient ?? '',
            ];
        });

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }
}

