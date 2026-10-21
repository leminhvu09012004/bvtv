<x-layouts.storefront title="Đăng ký tài khoản nông hộ — Sổ Tay Thuốc BVTV">
<div class="min-h-[75vh] flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="max-w-lg w-full bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">

        <!-- Top accent -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-teal-500 via-emerald-500 to-green-600"></div>

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-3 shadow-inner">
                🌾
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Đăng ký tài khoản nông hộ
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Nhận phác đồ điều trị sâu bệnh và ưu đãi giá thuốc chính hãng tận vườn
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <div class="font-bold mb-0.5">⚠️ Vui lòng kiểm tra lại thông tin:</div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Họ và tên -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Họ và tên chủ vườn: <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       placeholder="Ví dụ: Nguyễn Văn Nông"
                       class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition font-medium">
            </div>

            <!-- Số điện thoại & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Số điện thoại: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone') }}"
                           required
                           placeholder="09xx xxx xxx"
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition font-mono">
                </div>

                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tên đăng nhập: <span class="text-slate-400 font-normal">(tùy chọn)</span>
                    </label>
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="để trống sẽ lấy theo SĐT"
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition font-mono">
                </div>
            </div>

            <!-- Email & Cây trồng -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Email: <span class="text-slate-400 font-normal">(tùy chọn)</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="email@example.com"
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div>
                    <label for="crop_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Cây trồng chính:
                    </label>
                    <input type="text"
                           id="crop_type"
                           name="crop_type"
                           value="{{ old('crop_type') }}"
                           placeholder="Sầu riêng, Cà phê, Hồ tiêu..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition">
                </div>
            </div>

            <!-- Mật khẩu & Nhập lại -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Mật khẩu: <span class="text-rose-500">*</span>
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           placeholder="Nhập mật khẩu..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nhập lại mật khẩu: <span class="text-rose-500">*</span>
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           placeholder="Nhập lại mật khẩu..."
                           class="w-full px-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button type="submit"
                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-extrabold text-sm rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                    <span>🌱</span>
                    <span>Hoàn tất đăng ký nông hộ</span>
                </button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            <span>Đã có tài khoản nông hộ?</span>
            <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline ml-1">
                Đăng nhập ngay →
            </a>
        </div>

    </div>
</div>
</x-layouts.storefront>
