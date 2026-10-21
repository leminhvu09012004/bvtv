<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('login'))->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        if ($user->is_active === false || $user->is_active === 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa hoặc vô hiệu hóa.');
        }

        // Nếu admin, cho phép toàn quyền truy cập
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Kiểm tra xem role của user có nằm trong danh sách được phép không
        if (!in_array($user->role, $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập chức năng này.',
                    'required_roles' => $roles,
                    'your_role' => $user->role,
                ], 403);
            }

            return response()->view('errors.403', [
                'user' => $user,
                'requiredRoles' => $roles,
                'message' => 'Bạn không có quyền truy cập vào phân hệ này.',
            ], 403);
        }

        return $next($request);
    }
}
