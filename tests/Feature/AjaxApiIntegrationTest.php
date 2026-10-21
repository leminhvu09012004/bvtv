<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CustomerProfile;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use App\Models\StockTransfer;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AjaxApiIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajax_tim_kiem_returns_valid_json_payload(): void
    {
        $cat = Category::create([
            'name' => 'Thuốc Trừ Sâu',
            'slug' => 'thuoc-tru-sau',
            'emoji' => '🐛',
        ]);

        $pest = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Actara 25WG Trừ Rầy Nâu',
            'active_ingredient' => 'Thiamethoxam',
            'concentration' => '25% w/w',
            'crops' => 'Lúa, Cam, Quýt',
        ]);

        $res = $this->getJson('/ajax/tim-kiem?q=Actara');

        $res->assertOk()
            ->assertJsonStructure([
                'total',
                'data' => [
                    '*' => [
                        'id',
                        'ten',
                        'hoat_chat',
                        'danh_muc',
                        'url_xem',
                    ],
                ],
            ]);

        $data = $res->json('data');
        $this->assertNotEmpty($data);
        $this->assertEquals($pest->id, $data[0]['id']);
    }

    public function test_admin_can_quick_update_pesticide_via_ajax(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $cat = Category::create([
            'name' => 'Thuốc Trừ Bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🍄',
        ]);

        $pest = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Anvil 5SC',
            'active_ingredient' => 'Hexaconazole',
            'concentration' => '50g/l',
        ]);

        $res = $this->actingAs($admin)
            ->putJson("/ajax/thuoc/{$pest->id}/quick-update", [
                'category_id' => $cat->id,
                'name' => 'Anvil 5SC Cải Tiến',
                'active_ingredient' => 'Hexaconazole Chuẩn',
                'concentration' => '50g/l SC',
                'water_volume' => '400 lít',
                'crops' => 'Sầu riêng, Lúa',
                'usage' => 'Đặc trị nấm hồng, lem lép hạt',
            ]);

        $res->assertOk()
            ->assertJson([
                'success' => true,
                'thuoc' => [
                    'id' => $pest->id,
                    'ten' => 'Anvil 5SC Cải Tiến',
                    'hoat_chat' => 'Hexaconazole Chuẩn',
                ],
            ]);

        $this->assertDatabaseHas('pesticides', [
            'id' => $pest->id,
            'name' => 'Anvil 5SC Cải Tiến',
            'active_ingredient' => 'Hexaconazole Chuẩn',
        ]);
    }

    public function test_customer_can_update_farm_profile_via_ajax(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Bác Ba Nông Dân',
            'phone' => '0912345678',
        ]);

        $res = $this->actingAs($customer)
            ->postJson('/ajax/tai-khoan/cap-nhat', [
                'full_name' => 'Bác Ba Sầu Riêng',
                'phone' => '0988776655',
                'crop_type' => 'Sầu riêng Monthong & Ri6',
                'farm_area_hectares' => 3.5,
                'notes' => 'Vườn đang làm bông năm 4',
            ]);

        $res->assertOk()
            ->assertJson([
                'success' => true,
                'profile' => [
                    'full_name' => 'Bác Ba Sầu Riêng',
                    'phone' => '0988776655',
                    'crop_type' => 'Sầu riêng Monthong & Ri6',
                    'farm_area_hectares' => '3.5',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Bác Ba Sầu Riêng',
            'phone' => '0988776655',
        ]);

        $this->assertDatabaseHas('customer_profiles', [
            'user_id' => $customer->id,
            'full_name' => 'Bác Ba Sầu Riêng',
            'crop_type' => 'Sầu riêng Monthong & Ri6',
        ]);
    }

    public function test_customer_account_page_renders_successfully(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'name' => 'Bác Sáu Nông Hộ',
            'phone' => '0912345678',
        ]);

        $res = $this->actingAs($customer)->get('/tai-khoan');

        $res->assertOk()
            ->assertSee('Bác Sáu Nông Hộ')
            ->assertSee('Cập nhật vườn cây');
    }

    public function test_inventory_transfer_ajax_dispatch(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $wh1 = Warehouse::create([
            'name' => 'Kho Trung Tâm',
            'code' => 'KHO-TT-01',
            'address' => 'Số 1 Trung Tâm',
            'is_active' => true,
        ]);

        $wh2 = Warehouse::create([
            'name' => 'Chi Nhánh Đắk Lắk',
            'code' => 'CN-DL-02',
            'address' => 'Km 19 QL26',
            'is_active' => true,
        ]);

        $transfer = StockTransfer::create([
            'transfer_code' => 'TRF-TEST-001',
            'from_warehouse_id' => $wh1->id,
            'to_warehouse_id' => $wh2->id,
            'created_by' => $admin->id,
            'status' => 'draft',
        ]);

        $res = $this->actingAs($admin)
            ->postJson("/quan-ly/kho/chuyen-kho/{$transfer->id}/xuat");

        $res->assertOk()
            ->assertJson([
                'success' => true,
                'status' => 'dispatched',
            ]);

        $this->assertEquals('dispatched', $transfer->fresh()->status);
    }
}
