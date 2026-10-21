<x-layouts.storefront title="Hồ sơ tài khoản — Sổ Tay Thuốc BVTV">
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">

    <!-- Breadcrumb -->
    <nav class="text-xs sm:text-sm text-slate-500 mb-6 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Trang chủ</a>
        <span>/</span>
        <span class="text-slate-900 font-semibold">Tài khoản nông hộ</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>🌾</span> Hồ Sơ Tài Khoản Nông Hộ
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Xem lại thông tin vườn cây, hạng thành viên và theo dõi lịch sử các đơn hàng đặt thuốc BVTV.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                    <span>🚪 Đăng xuất</span>
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- CỘT TRÁI: THÔNG TIN HỒ SƠ & VƯỜN CÂY (4 cols) -->
        <div class="lg:col-span-4 space-y-6" x-data="customerProfileManager()">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-2xl font-black shadow-sm">
                        <span x-text="fullName ? fullName.charAt(0).toUpperCase() : '🌾'"></span>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900 leading-tight" x-text="fullName"></h3>
                        <div class="text-xs text-slate-400 font-mono mt-0.5">@<span>{{ $user->username }}</span></div>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase">
                            {{ $user->role === 'customer' ? 'Bà Con Nông Dân' : $user->role }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Số điện thoại:</span>
                        <strong class="text-slate-900 font-mono" x-text="phone || '—'"></strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Email liên hệ:</span>
                        <strong class="text-slate-900">{{ $user->email }}</strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Mã khách hàng:</span>
                        <strong class="text-emerald-700 font-mono font-bold">{{ $profile?->customer_code ?? ('KH-' . str_pad((string)$user->id, 5, '0', STR_PAD_LEFT)) }}</strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Cây trồng chính:</span>
                        <strong class="text-slate-900" x-text="cropType"></strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Diện tích canh tác:</span>
                        <strong class="text-slate-900" x-text="farmArea ? (farmArea + ' ha') : '—'"></strong>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Hạng thành viên:</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-100 text-amber-900 border border-amber-300">
                            🌟 {{ $profile?->loyalty_tier ?? 'Bronze' }}
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <button type="button"
                            @click="openModal = true"
                            class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-200 transition cursor-pointer">
                        <span>✏️ Cập nhật vườn cây & hồ sơ</span>
                    </button>
                    <a href="{{ route('thuoc.tra-cuu') }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md">
                        <span>🌱 Mua thêm thuốc BVTV</span>
                    </a>
                </div>
            </div>

            <!-- Modal AJAX Edit Profile -->
            <div x-show="openModal"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-200"
                     @click.away="openModal = false">
                    <div class="px-6 py-4 bg-emerald-800 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2 font-bold text-sm sm:text-base">
                            <span>🏡</span> Cập nhật thông tin vườn cây
                        </div>
                        <button type="button" @click="openModal = false" class="text-white/80 hover:text-white text-lg">✕</button>
                    </div>

                    <form @submit.prevent="submitProfile" class="p-6 space-y-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Họ và tên nông hộ <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="form.full_name" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Số điện thoại liên hệ</label>
                            <input type="text" x-model="form.phone"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Cây trồng chính</label>
                                <input type="text" x-model="form.crop_type" placeholder="Ví dụ: Sầu riêng, Lúa..."
                                       class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Diện tích (ha)</label>
                                <input type="number" step="0.1" min="0" x-model="form.farm_area_hectares" placeholder="1.5"
                                       class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Ghi chú đất đai / tình trạng vườn</label>
                            <textarea x-model="form.notes" rows="2" placeholder="Ví dụ: Đất đỏ bazan, đang chuẩn bị làm bông..."
                                      class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 resize-none"></textarea>
                        </div>

                        <div class="pt-2 flex items-center justify-end gap-2">
                            <button type="button" @click="openModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold">
                                Hủy bỏ
                            </button>
                            <button type="submit" :disabled="loading"
                                    class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold flex items-center gap-2 disabled:opacity-50">
                                <span x-show="loading" class="animate-spin text-xs">⏳</span>
                                <span>Lưu thay đổi</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: LỊCH SỬ ĐƠN HÀNG (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <h2 class="text-base font-bold text-slate-900 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <span>📦 Lịch sử đơn hàng của bạn</span>
                    <span class="text-xs font-semibold text-slate-400">{{ $orders->total() }} đơn hàng</span>
                </h2>

                @if($orders->isEmpty())
                    <div class="text-center py-12 px-4">
                        <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mb-3">
                            🧺
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Chưa có đơn hàng nào</h4>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Bà con chưa đặt đơn thuốc BVTV nào trên hệ thống. Hãy dạo quanh danh mục thuốc và đặt thử ngay nhé!
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('thuoc.tra-cuu') }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                <span>Khám phá sản phẩm →</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <div class="py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/50 p-2 rounded-xl transition">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-xs text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                            {{ $order->code }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $order->created_at->format('H:i - d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-700 font-medium">
                                        {{ $order->orderItems->count() }} mặt hàng &bull;
                                        <span class="text-slate-500">{{ $order->shipping_address_line ?: 'Giao tận vườn' }}</span>
                                    </div>
                                </div>

                                <div class="text-right flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-2">
                                    <div class="text-sm font-black text-emerald-700 tabular-nums">
                                        {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                                    </div>
                                    @php
                                        $displayStatus = $order->fulfillment_status ?: ($order->payment_status ?: 'pending');
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        @if($displayStatus === 'delivered' || $displayStatus === 'completed' || $displayStatus === 'paid') bg-emerald-100 text-emerald-800
                                        @elseif($displayStatus === 'cancelled') bg-rose-100 text-rose-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ $displayStatus }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

<script>
function customerProfileManager() {
    return {
        openModal: false,
        loading: false,
        fullName: @json($user->name),
        phone: @json($user->phone ?? ($profile?->phone ?? '')),
        cropType: @json($profile?->crop_type ?? 'Chưa cập nhật'),
        farmArea: @json($profile?->farm_area_hectares ? number_format((float)$profile->farm_area_hectares, 1) : ''),
        form: {
            full_name: @json($user->name),
            phone: @json($user->phone ?? ($profile?->phone ?? '')),
            crop_type: @json($profile?->crop_type ?? ''),
            farm_area_hectares: @json($profile?->farm_area_hectares ?? ''),
            notes: @json($profile?->notes ?? ''),
        },
        async submitProfile() {
            this.loading = true;
            try {
                const res = await fetch("{{ route('ajax.tai-khoan.cap-nhat') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });
                const data = await res.json();
                if (data.success) {
                    this.fullName = data.profile.full_name;
                    this.phone = data.profile.phone;
                    this.cropType = data.profile.crop_type;
                    this.farmArea = data.profile.farm_area_hectares;
                    this.openModal = false;
                    if (window.showToast) {
                        window.showToast(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                } else {
                    alert(data.message || 'Cập nhật thất bại');
                }
            } catch (err) {
                console.error(err);
                alert('Có lỗi xảy ra khi kết nối máy chủ.');
            } finally {
                this.loading = false;
            }
        }
    };
}
window.customerProfileManager = customerProfileManager;
</script>
</x-layouts.storefront>
