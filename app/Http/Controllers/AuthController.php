<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Hiển thị Form Đăng nhập
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Xử lý Đăng nhập (Chấp nhận Username, Email hoặc Số điện thoại)
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Vui lòng nhập tên đăng nhập, email hoặc số điện thoại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $loginInput = trim($request->input('login'));
        $password = $request->input('password');

        // Tìm người dùng theo username, email hoặc phone
        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->orWhere('phone', $loginInput)
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withInput($request->only('login', 'remember'))->withErrors([
                'login' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác.',
            ]);
        }

        if (!$user->is_active) {
            return back()->withInput($request->only('login', 'remember'))->withErrors([
                'login' => 'Tài khoản của bạn đã bị khóa hoặc ngừng hoạt động.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user)->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name . '.');
    }

    /**
     * Hiển thị Form Đăng ký (Dành cho Khách hàng / Nông hộ)
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Xử lý Đăng ký tài khoản Nông hộ mới
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'password' => ['required', 'string', 'min:1', 'confirmed'],
            'crop_type' => ['nullable', 'string', 'max:255'],
            'farm_area' => ['nullable', 'numeric', 'min:0'],
            'farm_area_hectares' => ['nullable', 'numeric', 'min:0'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại này đã được đăng ký tài khoản.',
            'email.unique' => 'Email này đã được sử dụng.',
            'username.unique' => 'Tên đăng nhập này đã tồn tại, vui lòng chọn tên khác.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        $username = $request->input('username');
        if (empty($username)) {
            // Tự động gán username từ số điện thoại nếu để trống
            $username = 'nd_' . preg_replace('/[^0-9]/', '', $request->input('phone'));
            if (User::where('username', $username)->exists()) {
                $username .= '_' . Str::random(3);
            }
        }

        $user = User::create([
            'username' => $username,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email') ?: ($username . '@bvtvtaynguyen.vn'),
            'password' => Hash::make($request->input('password')),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Tạo hồ sơ nông hộ
        CustomerProfile::create([
            'user_id' => $user->id,
            'customer_code' => 'KH-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'full_name' => $user->name,
            'phone' => $user->phone,
            'crop_type' => $request->input('crop_type'),
            'farm_area_hectares' => $request->input('farm_area_hectares', $request->input('farm_area')),
            'loyalty_tier' => 'standard',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('customer.account')->with('success', 'Đăng ký tài khoản thành công! Chào mừng bà con ' . $user->name . '.');
    }

    /**
     * Xử lý Đăng xuất
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
    }

    /**
     * Tự động điều hướng theo Vai trò (Role-based Navigation)
     */
    protected function redirectByRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'admin' => redirect()->intended(route('admin.inventory.index')),
            'staff' => redirect()->intended(route('pos.index')),
            'engineer' => redirect()->intended(route('phoi-tron.index')),
            default => redirect()->intended(route('home')),
        };
    }
}
