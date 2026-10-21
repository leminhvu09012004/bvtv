<x-layouts.storefront title="Đăng nhập tài khoản — Sổ Tay Thuốc BVTV">
<div class="min-h-[75vh] flex items-center justify-center px-4 py-10 sm:py-16">
    <div class="max-w-md w-full bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden"
         x-data="{
             login: '{{ old('login', '') }}',
             password: '',
             showPass: false,
             fillAccount(u, p) {
                 this.login = u;
                 this.password = p;
             }
         }">

        <!-- Decorative top accent -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-3 shadow-inner">
                🌿
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Đăng nhập hệ thống
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Sổ Tay Vật Tư Nông Nghiệp & Thuốc BVTV Tây Nguyên
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <div class="font-bold mb-0.5">⚠️ Không thể đăng nhập:</div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- Quick Fill Buttons for 4 Roles -->
        <div class="mb-6 p-3 bg-slate-50 border border-slate-200/80 rounded-2xl">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                <span>⚡ Tài khoản thử nghiệm nhanh (1-Click):</span>
                <span class="text-[10px] text-emerald-600 font-mono">Pass: 1</span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button"
                        @click="fillAccount('admin', '1')"
                        class="p-2 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-900 text-left transition flex items-center gap-1.5 cursor-pointer">
                    <span class="text-sm">👑</span>
                    <div>
                        <div class="font-extrabold text-[11px]">Admin</div>
                        <div class="text-[10px] text-purple-600 font-mono">admin / 1</div>
                    </div>
                </button>

                <button type="button"
                        @click="fillAccount('pos', '1')"
                        class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-900 text-left transition flex items-center gap-1.5 cursor-pointer">
                    <span class="text-sm">💻</span>
                    <div>
                        <div class="font-extrabold text-[11px]">Thu Ngân POS</div>
                        <div class="text-[10px] text-blue-600 font-mono">pos / 1</div>
                    </div>
                </button>

                <button type="button"
                        @click="fillAccount('customer', '1')"
                        class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-900 text-left transition flex items-center gap-1.5 cursor-pointer">
                    <span class="text-sm">🌾</span>
                    <div>
                        <div class="font-extrabold text-[11px]">Khách Hàng</div>
                        <div class="text-[10px] text-emerald-600 font-mono">customer / 1</div>
                    </div>
                </button>

                <button type="button"
                        @click="fillAccount('user', '1')"
                        class="p-2 rounded-xl bg-teal-50 hover:bg-teal-100 border border-teal-200 text-teal-900 text-left transition flex items-center gap-1.5 cursor-pointer">
                    <span class="text-sm">🔬</span>
                    <div>
                        <div class="font-extrabold text-[11px]">Kỹ Sư BVTV</div>
                        <div class="text-[10px] text-teal-600 font-mono">user / 1</div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Username / Email / Phone -->
            <div>
                <label for="login" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Tên đăng nhập / Email / SĐT:
                </label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-slate-400 text-sm">👤</span>
                    <input type="text"
                           id="login"
                           name="login"
                           x-model="login"
                           required
                           autofocus
                           placeholder="admin, pos, customer, user hoặc email..."
                           class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition font-medium">
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Mật khẩu:
                    </label>
                    <span class="text-[11px] text-slate-400">Mặc định: <strong class="text-emerald-700 font-mono">1</strong></span>
                </div>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-slate-400 text-sm">🔒</span>
                    <input :type="showPass ? 'text' : 'password'"
                           id="password"
                           name="password"
                           x-model="password"
                           required
                           placeholder="Nhập mật khẩu..."
                           class="w-full pl-10 pr-10 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-emerald-500 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition font-medium">
                    <button type="button"
                            @click="showPass = !showPass"
                            class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-sm focus:outline-none"
                            tabindex="-1">
                        <span x-text="showPass ? '🙈' : '👁️'"></span>
                    </button>
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                    <input type="checkbox"
                           name="remember"
                           value="1"
                           checked
                           class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-emerald-600 transition">
                    Về trang chủ
                </a>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-extrabold text-sm rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                    <span>🔑</span>
                    <span>Đăng nhập hệ thống</span>
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600">
            <span>Bà con chưa có tài khoản?</span>
            <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline ml-1">
                Đăng ký tài khoản nông hộ ngay →
            </a>
        </div>

    </div>
</div>
</x-layouts.storefront>
