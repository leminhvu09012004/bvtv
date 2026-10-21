<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVariantPriceEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = \App\Models\User::create([
            'name'     => 'Admin Price Test',
            'email'    => 'admin.price@bvtv.vn',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);
        $this->actingAs($admin);
    }

    private function taoDanhMuc(): Category
    {
        return Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🧪',
            'sort_order' => 1,
        ]);
    }

    /**
     * Test: Form sửa thuốc không còn các ô nhập giá và bộ chọn quy cách / kích thước.
     */
    public function test_form_chinh_sua_khong_con_tabs_quy_cach_va_gia(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc = Pesticide::create([
            'category_id' => $cat->id,
            'name' => '1.0.16 Huỳnh Lâm Test',
            'active_ingredient' => 'Chitosan 1%',
            'water_volume' => '200 lít',
        ]);

        $resp = $this->get(route('thuoc.sua', $thuoc));
        $resp->assertStatus(200);

        // Không còn hiển thị tabs chọn size hay ô nhập giá
        $resp->assertDontSee('variant-tab-0');
        $resp->assertDontSee('name="price"', false);
        $resp->assertDontSee('name="variants_price', false);
        $resp->assertDontSee('name="variants_size', false);

        // Hiển thị các trường học thuốc nông nghiệp
        $resp->assertSee('Chitosan 1%');
        $resp->assertSee('200 lít');
    }

    /**
     * Test: Admin cập nhật thông tin thuốc thành công, price và variants luôn giữ an toàn.
     */
    public function test_admin_cap_nhat_thong_tin_nong_nghiep_thanh_cong(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Thuốc Học Tập',
            'active_ingredient' => 'Chitosan',
            'water_volume' => '200 lít',
        ]);

        $resp = $this->put(route('thuoc.cap-nhat', $thuoc), [
            'category_id' => $cat->id,
            'name' => 'Thuốc Học Tập Cập Nhật',
            'active_ingredient' => 'Chitosan + Salicylic Acid',
            'water_volume' => '400 lít',
            'concentration' => '2%',
            'form_type' => 'SL',
            'target' => 'Bệnh vàng lá thối rễ',
            'usage' => 'Pha 1 chai cho 400 lít nước',
        ]);

        $resp->assertRedirect();

        $thuoc->refresh();
        $this->assertEquals('Thuốc Học Tập Cập Nhật', $thuoc->name);
        $this->assertEquals('Chitosan + Salicylic Acid', $thuoc->active_ingredient);
        $this->assertEquals('400 lít', $thuoc->water_volume);
        $this->assertNull($thuoc->price);
        $this->assertNull($thuoc->variants);
    }

    /**
     * Test: Trang quản lý danh sách của Admin không còn cột giá bán.
     */
    public function test_admin_danh_sach_khong_con_cot_gia_ban(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Thuốc Danh Sách Admin',
        ]);

        $resp = $this->get(route('thuoc.quan-ly'));
        $resp->assertStatus(200);
        $resp->assertDontSee('<th>Giá bán</th>', false);
        $resp->assertDontSee('admin-var-btn', false);
    }
}
