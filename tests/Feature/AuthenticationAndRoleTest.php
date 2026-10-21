<?php

namespace Tests\Feature;

use App\Models\CustomerProfile;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationAndRoleTest extends TestCase
{
    use RefreshDatabase;

    private function createSeedUsers(): array
    {
        $admin = User::create([
            'username' => 'admin',
            'name' => 'Quản Trị Viên',
            'email' => 'admin@bvtvtaynguyen.vn',
            'phone' => '0988888888',
            'password' => Hash::make('1'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $pos = User::create([
            'username' => 'pos',
            'name' => 'Nhân Viên Thu Ngân POS',
            'email' => 'pos@bvtvtaynguyen.vn',
            'phone' => '0977777777',
            'password' => Hash::make('1'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        $customer = User::create([
            'username' => 'customer',
            'name' => 'Khách Hàng Nông Dân',
            'email' => 'customer@bvtvtaynguyen.vn',
            'phone' => '0912345678',
            'password' => Hash::make('1'),
            'role' => 'customer',
            'is_active' => true,
        ]);
        CustomerProfile::create([
            'user_id' => $customer->id,
            'customer_code' => 'KH-0001',
            'full_name' => $customer->name,
            'phone' => $customer->phone,
            'crop_type' => 'Sầu riêng',
            'farm_area_hectares' => 2.5,
            'loyalty_tier' => 'gold',
        ]);

        $user = User::create([
            'username' => 'user',
            'name' => 'Kỹ Sư Nông Nghiệp',
            'email' => 'user@bvtvtaynguyen.vn',
            'phone' => '0966666666',
            'password' => Hash::make('1'),
            'role' => 'engineer',
            'is_active' => true,
        ]);

        $nongdan = User::create([
            'username' => 'nongdan',
            'name' => 'Nông Dân Tây Nguyên',
            'email' => 'nongdan@gmail.com',
            'phone' => '0933456789',
            'password' => Hash::make('1'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        return compact('admin', 'pos', 'customer', 'user', 'nongdan');
    }

    /** TC-AUTH01 — Xem form đăng nhập và form đăng ký. */
    public function test_hien_thi_form_dang_nhap_va_dang_ky(): void
    {
        $resLogin = $this->get(route('login'));
        $resLogin->assertStatus(200);
        $resLogin->assertSee('Đăng nhập');
        $resLogin->assertSee('Pass: 1');

        $resRegister = $this->get(route('register'));
        $resRegister->assertStatus(200);
        $resRegister->assertSee('Đăng ký tài khoản');
    }

    /** TC-AUTH02 — Đăng nhập bằng username 'admin' và pass '1' -> redirect /quan-ly/kho. */
    public function test_dang_nhap_admin_thanh_cong(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'admin',
            'password' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.inventory.index'));
    }

    /** TC-AUTH03 — Đăng nhập bằng username 'pos' và pass '1' -> redirect /pos. */
    public function test_dang_nhap_pos_thanh_cong(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'pos',
            'password' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('pos.index'));
    }

    /** TC-AUTH04 — Đăng nhập bằng username 'customer' và pass '1' -> redirect trang chủ. */
    public function test_dang_nhap_customer_thanh_cong(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'customer',
            'password' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    /** TC-AUTH05 — Đăng nhập bằng username 'user' (engineer) và pass '1' -> redirect /ky-phoi-tron. */
    public function test_dang_nhap_engineer_thanh_cong(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'user',
            'password' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('phoi-tron.index'));
    }

    /** TC-AUTH06 — Đăng nhập bằng email 'nongdan@gmail.com' và pass '1'. */
    public function test_dang_nhap_bang_email(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'nongdan@gmail.com',
            'password' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home'));
    }

    /** TC-AUTH07 — Đăng nhập sai mật khẩu -> lỗi session. */
    public function test_dang_nhap_sai_mat_khau_that_bai(): void
    {
        $this->createSeedUsers();

        $response = $this->post(route('login.post'), [
            'login' => 'admin',
            'password' => 'sai_mat_khau',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('login');
    }

    /** TC-AUTH08 — Đăng ký tài khoản nông hộ mới -> role customer và tự động đăng nhập. */
    public function test_dang_ky_tai_khoan_moi_thanh_cong(): void
    {
        $response = $this->post(route('register.post'), [
            'name' => 'Nguyễn Văn Cà Phê',
            'phone' => '0944111222',
            'email' => 'caphe@gmail.com',
            'crop_type' => 'Cà phê Robusta',
            'farm_area_hectares' => 3.2,
            'password' => '1',
            'password_confirmation' => '1',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'phone' => '0944111222',
            'email' => 'caphe@gmail.com',
            'role' => 'customer',
        ]);
        $this->assertDatabaseHas('customer_profiles', [
            'crop_type' => 'Cà phê Robusta',
            'farm_area_hectares' => 3.2,
        ]);
        $response->assertRedirect(route('customer.account'));
    }

    /** TC-AUTH09 — Đăng xuất thành công. */
    public function test_dang_xuat_thanh_cong(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['customer']);

        $response = $this->post(route('logout'));
        $this->assertGuest();
        $response->assertRedirect(route('home'));
    }

    /** TC-ROLE01 — Khách chưa đăng nhập vào /pos -> redirect /dang-nhap. */
    public function test_guest_vao_pos_bi_redirect_login(): void
    {
        $response = $this->get(route('pos.index'));
        $response->assertRedirect(route('login'));
    }

    /** TC-ROLE02 — Customer vào /pos -> nhận 403 Forbidden. */
    public function test_customer_vao_pos_bi_chan_403(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['customer']);

        $response = $this->get(route('pos.index'));
        $response->assertStatus(403);
    }

    /** TC-ROLE03 — Customer vào /quan-ly/kho -> nhận 403 Forbidden. */
    public function test_customer_vao_quan_ly_kho_bi_chan_403(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['customer']);

        $response = $this->get(route('admin.inventory.index'));
        $response->assertStatus(403);
    }

    /** TC-ROLE04 — Staff vào /pos -> HTTP 200 OK. */
    public function test_staff_vao_pos_thanh_cong(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['pos']);

        Warehouse::create([
            'code' => 'KHO-AUTH-TEST',
            'name' => 'Kho Test',
            'address' => 'Địa chỉ test',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $response = $this->get(route('pos.index'));
        $response->assertStatus(200);
    }

    /** TC-ROLE05 — Staff vào /quan-ly/kho -> nhận 403 Forbidden. */
    public function test_staff_vao_quan_ly_kho_bi_chan_403(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['pos']);

        $response = $this->get(route('admin.inventory.index'));
        $response->assertStatus(403);
    }

    /** TC-ROLE06 — Admin vào /quan-ly/kho và /pos -> Đều được phép (Bypass hoặc thuộc role). */
    public function test_admin_truy_cap_duoc_moi_phan_he(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['admin']);

        Warehouse::create([
            'code' => 'KHO-AUTH-ADMIN',
            'name' => 'Kho Admin Test',
            'address' => 'Địa chỉ test',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $resAdmin = $this->get(route('admin.inventory.index'));
        $resAdmin->assertStatus(200);
        $resAdmin->assertSee('Phân Hệ Kỹ Sư BVTV');
        $resAdmin->assertSee(route('phoi-tron.index'));

        $resPos = $this->get(route('pos.index'));
        $resPos->assertStatus(200);
        $resPos->assertSee('Về Quản Trị');
        $resPos->assertSee('Sang Kỹ Sư');

        $resMixing = $this->get(route('phoi-tron.index'));
        $resMixing->assertStatus(200);
        $resMixing->assertSee('Về Quản Trị Kho');
        $resMixing->assertSee('Phân Hệ Kỹ Sư BVTV');

        $resHome = $this->get(route('home'));
        $resHome->assertStatus(200);
        $resHome->assertSee('QUẢN TRỊ VIÊN');
        $resHome->assertSee('Phân hệ Kỹ sư');
    }

    /** TC-ROLE07 — Customer vào trang hồ sơ /tai-khoan -> HTTP 200 OK. */
    public function test_customer_vao_ho_so_tai_khoan_thanh_cong(): void
    {
        $users = $this->createSeedUsers();
        $this->actingAs($users['customer']);

        $response = $this->get(route('customer.account'));
        $response->assertStatus(200);
        $response->assertSee('Hồ sơ nông hộ');
        $response->assertSee('Sầu riêng');
    }
}
