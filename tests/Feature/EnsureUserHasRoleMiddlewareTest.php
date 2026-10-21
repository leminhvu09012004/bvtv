<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EnsureUserHasRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['web', 'role:engineer,staff'])->get('/test-role-protected', function () {
            return response()->json(['success' => true]);
        });
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/test-role-protected');
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_guest_json_request_receives_401(): void
    {
        $response = $this->getJson('/test-role-protected');
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_inactive_user_is_logged_out_and_redirected(): void
    {
        $user = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)->get('/test-role-protected');
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Tài khoản của bạn đã bị khóa hoặc vô hiệu hóa.');
        $this->assertGuest();
    }

    public function test_admin_bypasses_role_restriction(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/test-role-protected');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_allowed_role_passes_middleware(): void
    {
        $engineer = User::create([
            'name' => 'Engineer User',
            'email' => 'engineer@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'engineer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($engineer)->get('/test-role-protected');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_disallowed_role_receives_403_view(): void
    {
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)->get('/test-role-protected');
        $response->assertStatus(403);
    }

    public function test_disallowed_role_receives_403_json(): void
    {
        $customer = User::create([
            'name' => 'Customer User JSON',
            'email' => 'customer.json@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)->getJson('/test-role-protected');
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Bạn không có quyền truy cập chức năng này.',
            'your_role' => 'customer',
        ]);
    }
}
