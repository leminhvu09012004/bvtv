<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWarehouseFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        return User::create([
            'name' => 'Admin Kho',
            'email' => 'admin.warehouse@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    public function test_guest_cannot_access_warehouses(): void
    {
        $response = $this->get(route('admin.warehouses.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_warehouses_index(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        Warehouse::create([
            'code' => 'KHO-TEST-1',
            'name' => 'Kho Cư Mgar',
            'address' => 'Thị trấn Quảng Phú',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $response = $this->get(route('admin.warehouses.index'));
        $response->assertStatus(200);
        $response->assertSee('Kho Cư Mgar');
        $response->assertSee('KHO-TEST-1');
    }

    public function test_admin_can_store_warehouse_with_explicit_code(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $response = $this->post(route('admin.warehouses.store'), [
            'name' => 'Kho Buôn Đôn',
            'code' => 'KHO-BDN',
            'address' => 'Xã Cuôr Knia',
            'phone' => '0912345678',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.warehouses.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('warehouses', [
            'code' => 'KHO-BDN',
            'name' => 'Kho Buôn Đôn',
            'is_active' => true,
        ]);
    }

    public function test_admin_store_warehouse_auto_generates_code_if_omitted(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $response = $this->post(route('admin.warehouses.store'), [
            'name' => 'Kho Lắk Mới',
            'address' => 'Thị trấn Liên Sơn',
        ]);

        $response->assertRedirect(route('admin.warehouses.index'));
        $this->assertDatabaseHas('warehouses', [
            'name' => 'Kho Lắk Mới',
        ]);
    }

    public function test_admin_cannot_store_warehouse_with_duplicate_code(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        Warehouse::create([
            'code' => 'KHO-DUP',
            'name' => 'Kho Cũ',
            'address' => 'Buôn Ma Thuột',
            'province' => 'Đắk Lắk',
        ]);

        $response = $this->post(route('admin.warehouses.store'), [
            'name' => 'Kho Trùng Mã',
            'code' => 'KHO-DUP',
            'address' => 'Buôn Ma Thuột',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_admin_can_update_warehouse(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $warehouse = Warehouse::create([
            'code' => 'KHO-UPDATE',
            'name' => 'Kho Tên Cũ',
            'address' => 'Địa chỉ cũ',
            'province' => 'Đắk Lắk',
        ]);

        $response = $this->put(route('admin.warehouses.update', $warehouse), [
            'name' => 'Kho Tên Mới Đã Đổi',
            'code' => 'KHO-UPDATE-NEW',
            'address' => 'Địa chỉ mới',
            'phone' => '0988776655',
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('admin.warehouses.index'));
        $this->assertDatabaseHas('warehouses', [
            'id' => $warehouse->id,
            'code' => 'KHO-UPDATE-NEW',
            'name' => 'Kho Tên Mới Đã Đổi',
            'is_active' => false,
        ]);
    }

    public function test_admin_can_toggle_warehouse_status(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $warehouse = Warehouse::create([
            'code' => 'KHO-TOGGLE',
            'name' => 'Kho Bật Tắt',
            'address' => 'Địa chỉ',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.warehouses.toggle', $warehouse));
        $response->assertRedirect(route('admin.warehouses.index'));

        $this->assertDatabaseHas('warehouses', [
            'id' => $warehouse->id,
            'is_active' => false,
        ]);

        // Toggle lại
        $response = $this->post(route('admin.warehouses.toggle', $warehouse));
        $response->assertRedirect(route('admin.warehouses.index'));

        $this->assertDatabaseHas('warehouses', [
            'id' => $warehouse->id,
            'is_active' => true,
        ]);
    }

    public function test_admin_destroy_warehouse_with_stock_or_movements_deactivates_only(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $category = \App\Models\Category::create([
            'name' => 'Thuốc trừ sâu',
            'slug' => 'thuoc-tru-sau',
            'emoji' => '🐛',
            'sort_order' => 1,
        ]);

        $pesticide = \App\Models\Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Regent 800WG',
            'active_ingredient' => 'Fipronil 800g/kg',
        ]);

        $variant = \App\Models\ProductVariant::create([
            'pesticide_id' => $pesticide->id,
            'sku' => 'REG-800WG-100G',
            'specification' => 'Gói 100g',
            'unit' => 'Gói',
            'selling_price' => 50000,
            'status' => 'active',
        ]);

        $warehouse = Warehouse::create([
            'code' => 'KHO-STOCK',
            'name' => 'Kho Có Hàng',
            'address' => 'Địa chỉ',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        Inventory::create([
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 50,
            'quantity_reserved' => 0,
            'reorder_point' => 10,
        ]);

        $response = $this->delete(route('admin.warehouses.destroy', $warehouse));
        $response->assertRedirect(route('admin.warehouses.index'));

        // Không bị xóa khỏi database, chỉ chuyển is_active = false
        $this->assertDatabaseHas('warehouses', [
            'id' => $warehouse->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_destroy_empty_warehouse_deletes_record(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $warehouse = Warehouse::create([
            'code' => 'KHO-EMPTY',
            'name' => 'Kho Rỗng',
            'address' => 'Địa chỉ',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $response = $this->delete(route('admin.warehouses.destroy', $warehouse));
        $response->assertRedirect(route('admin.warehouses.index'));

        $this->assertDatabaseMissing('warehouses', [
            'id' => $warehouse->id,
        ]);
    }
}
