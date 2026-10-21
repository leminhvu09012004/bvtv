<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    /**
     * Danh sách tất cả chi nhánh / kho hàng.
     */
    public function index(): View
    {
        $warehouses = Warehouse::withCount('inventories')
            ->withSum('inventories as total_stock', 'quantity_on_hand')
            ->orderByDesc('is_active')
            ->orderBy('id')
            ->get();

        $totalWarehouses = $warehouses->count();
        $activeWarehouses = $warehouses->where('is_active', true)->count();
        $totalStockAll = $warehouses->sum('total_stock') ?? 0;

        return view('admin.warehouses.index', compact(
            'warehouses',
            'totalWarehouses',
            'activeWarehouses',
            'totalStockAll'
        ));
    }

    /**
     * Lưu chi nhánh mới.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'code'      => ['nullable', 'string', 'max:50', 'unique:warehouses,code'],
            'address'   => ['nullable', 'string', 'max:500'],
            'phone'     => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Vui lòng nhập tên chi nhánh / kho.',
            'code.unique'   => 'Mã chi nhánh đã tồn tại trên hệ thống.',
        ]);

        if (empty($validated['code'])) {
            $slug = strtoupper(Str::slug(Str::words($validated['name'], 3, '')));
            $validated['code'] = 'KHO-' . ($slug ?: strtoupper(Str::random(4)));
            // Tránh trùng code tự sinh
            $count = 1;
            $baseCode = $validated['code'];
            while (Warehouse::where('code', $validated['code'])->exists()) {
                $validated['code'] = $baseCode . '-' . $count++;
            }
        } else {
            $validated['code'] = strtoupper(trim($validated['code']));
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Warehouse::create($validated);

        return redirect()->route('admin.warehouses.index')
            ->with('success', "Đã thêm chi nhánh [{$validated['name']}] thành công!");
    }

    /**
     * Cập nhật thông tin chi nhánh.
     */
    public function update(Request $request, Warehouse $warehouse): RedirectResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'code'      => ['required', 'string', 'max:50', Rule::unique('warehouses', 'code')->ignore($warehouse->id)],
            'address'   => ['nullable', 'string', 'max:500'],
            'phone'     => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Vui lòng nhập tên chi nhánh / kho.',
            'code.required' => 'Mã chi nhánh không được để trống.',
            'code.unique'   => 'Mã chi nhánh đã tồn tại trên hệ thống.',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = $request->boolean('is_active', true);

        $warehouse->update($validated);

        return redirect()->route('admin.warehouses.index')
            ->with('success', "Đã cập nhật thông tin chi nhánh [{$warehouse->name}] thành công!");
    }

    /**
     * Bật / Tắt trạng thái hoạt động của chi nhánh.
     */
    public function toggle(Warehouse $warehouse): RedirectResponse
    {
        $warehouse->is_active = !$warehouse->is_active;
        $warehouse->save();

        $statusText = $warehouse->is_active ? 'Kích hoạt hoạt động' : 'Tạm dừng hoạt động';

        return redirect()->route('admin.warehouses.index')
            ->with('success', "Đã chuyển chi nhánh [{$warehouse->name}] sang trạng thái: {$statusText}!");
    }

    /**
     * Xóa chi nhánh (hoặc chuyển sang ngừng hoạt động nếu đã có dữ liệu sổ cái/tồn kho).
     */
    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        $hasStock = $warehouse->inventories()->where('quantity_on_hand', '>', 0)->exists();
        $hasMovements = $warehouse->stockMovements()->exists();

        if ($hasStock || $hasMovements) {
            $warehouse->update(['is_active' => false]);
            return redirect()->route('admin.warehouses.index')
                ->with('success', "Chi nhánh [{$warehouse->name}] đã có lịch sử sổ cái / tồn kho, hệ thống đã tự động chuyển sang trạng thái [Tạm dừng hoạt động] để bảo toàn sổ sách!");
        }

        $warehouse->inventories()->delete();
        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')
            ->with('success', "Đã xóa chi nhánh [{$warehouse->name}] thành công!");
    }
}
