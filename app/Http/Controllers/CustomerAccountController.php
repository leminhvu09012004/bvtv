<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    /**
     * Trang Hồ Sơ Nông Hộ & Lịch Sử Đơn Mua Thuốc
     */
    public function index(): View
    {
        $user = Auth::user();
        $profile = $user->customerProfile;

        // Lấy lịch sử đơn hàng của khách hàng theo số điện thoại hoặc customer_profile_id
        $orders = Order::with('orderItems')
            ->where(function ($query) use ($user, $profile) {
                if ($user->phone) {
                    $query->where('shipping_phone', $user->phone);
                }
                if ($profile) {
                    $query->orWhere('customer_profile_id', $profile->id);
                }
            })
            ->latest()
            ->paginate(10);

        return view('customer.account', compact('user', 'profile', 'orders'));
    }

    /**
     * AJAX Cập nhật Hồ sơ Nông hộ & Vườn cây
     */
    public function ajaxUpdateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'crop_type' => ['nullable', 'string', 'max:255'],
            'farm_area_hectares' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cập nhật tên user nếu có
        $user->update([
            'name' => $validated['full_name'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        // Cập nhật hoặc tạo mới customer profile
        $profile = $user->customerProfile;
        if (! $profile) {
            $profile = CustomerProfile::create([
                'user_id' => $user->id,
                'customer_code' => 'KH-' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'] ?? $user->phone,
                'crop_type' => $validated['crop_type'] ?? null,
                'farm_area_hectares' => $validated['farm_area_hectares'] ?? 0,
                'notes' => $validated['notes'] ?? null,
            ]);
        } else {
            $profile->update([
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'] ?? $profile->phone,
                'crop_type' => $validated['crop_type'] ?? $profile->crop_type,
                'farm_area_hectares' => $validated['farm_area_hectares'] ?? $profile->farm_area_hectares,
                'notes' => $validated['notes'] ?? $profile->notes,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật hồ sơ vườn cây thành công!',
            'profile' => [
                'full_name' => $profile->full_name,
                'phone' => $profile->phone,
                'crop_type' => $profile->crop_type ?? 'Chưa cập nhật',
                'farm_area_hectares' => number_format((float) $profile->farm_area_hectares, 1),
                'notes' => $profile->notes ?? '',
            ],
        ]);
    }
}
