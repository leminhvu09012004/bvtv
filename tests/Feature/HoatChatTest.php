<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HoatChatTest extends TestCase
{
    use RefreshDatabase;

    protected User $engineer;
    protected User $admin;
    protected User $customer;
    protected User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engineer = User::create([
            'name' => 'Kỹ Sư Nông Nghiệp Test',
            'email' => 'engineer.test@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'engineer',
            'is_active' => true,
        ]);

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin.test@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->customer = User::create([
            'name' => 'Nông Dân Test',
            'email' => 'customer.test@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->staff = User::create([
            'name' => 'Nhân Viên Test',
            'email' => 'staff.test@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        $category = Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🛡️',
        ]);

        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Thuốc Mancozeb Xanh Mới',
            'active_ingredient' => 'Mancozeb 800g/kg',
            'water_volume' => '400 lít nước',
            'form_type' => 'WP',
        ]);

        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Thuốc Trừ Nấm Dimethor',
            'active_ingredient' => 'Dimethomorph 500g/l',
            'water_volume' => '200 lít nước',
            'form_type' => 'SC',
        ]);
    }

    /**
     * Khách vãng lai chưa đăng nhập cố tình vào /hoat-chat sẽ bị chuyển hướng về login
     */
    public function test_khach_chua_dang_nhap_bi_chuyen_huong_ve_login(): void
    {
        $response = $this->get(route('hoatchat.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Khách hàng nông hộ thông thường (customer) không được vào /hoat-chat -> 403 Forbidden
     */
    public function test_customer_vao_hoat_chat_bi_chan_403(): void
    {
        $response = $this->actingAs($this->customer)->get(route('hoatchat.index'));
        $response->assertStatus(403);
    }

    /**
     * Nhân viên bán hàng POS (staff) không thuộc phân hệ Kỹ sư -> 403 Forbidden
     */
    public function test_staff_vao_hoat_chat_bi_chan_403(): void
    {
        $response = $this->actingAs($this->staff)->get(route('hoatchat.index'));
        $response->assertStatus(403);
    }

    /**
     * Kỹ sư (engineer) đăng nhập vào /hoat-chat thành công với giao diện Kỹ sư BVTV
     */
    public function test_engineer_vao_hoat_chat_thanh_cong(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('hoatchat.index'));

        $response->assertStatus(200);
        $response->assertSee('PHÂN HỆ KỸ SƯ BVTV');
        $response->assertSee('Tra Cứu Hoạt Chất');
        $response->assertSee('Kiểm Tra Kỵ Phối Trộn');
        $response->assertSee('Mancozeb');
        $response->assertSee('Dimethomorph');
    }

    /**
     * Quản trị viên (admin) toàn quyền truy cập phân hệ kỹ sư /hoat-chat
     */
    public function test_admin_vao_hoat_chat_thanh_cong(): void
    {
        $response = $this->actingAs($this->admin)->get(route('hoatchat.index'));

        $response->assertStatus(200);
        $response->assertSee('PHÂN HỆ KỸ SƯ BVTV');
        $response->assertSee('Mancozeb');
    }

    /**
     * Alias route /tra-cuu-hoat-chat cũng được bảo vệ và kỹ sư truy cập được
     */
    public function test_alias_tra_cuu_hoat_chat_tai_thanh_cong(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('hoatchat.tra-cuu'));

        $response->assertStatus(200);
        $response->assertSee('Mancozeb');
    }

    /**
     * Tìm kiếm hoạt chất hoạt động chính xác cho kỹ sư
     */
    public function test_tim_kiem_hoat_chat_qua_query(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('hoatchat.index', ['q' => 'mancozeb']));

        $response->assertStatus(200);
        $response->assertSee('Mancozeb');
    }
}
