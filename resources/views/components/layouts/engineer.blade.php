<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Phân Hệ Kỹ Sư BVTV — Sổ Tay Nông Học</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-100 font-sans text-slate-800 antialiased flex flex-col">

    @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- 0. MASTER ADMIN SWITCHER BAR -->
        <div class="bg-slate-950 text-slate-200 px-4 py-1.5 text-xs border-b border-slate-800 shadow-sm z-50">
            <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-black bg-rose-900/90 text-rose-200 border border-rose-700 uppercase tracking-wider">
                        <span>🛡️</span> QUẢN TRỊ VIÊN
                    </span>
                    <span class="text-slate-400 text-xs hidden sm:inline">Chuyển sang phân hệ khác:</span>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition font-medium text-xs">
                        <span>🏢</span> Về Quản Trị Kho
                    </a>
                    <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition font-medium text-xs">
                        <span>💻</span> Quầy Thu Ngân POS
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition font-medium text-xs">
                        <span>🌐</span> Xem Cửa Hàng ↗
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- 1. DEDICATED ENGINEER HEADER -->
    <header class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-15 gap-3">
                <!-- Brand / Phân hệ -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <span class="w-8 h-8 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-400 text-slate-950 font-black text-base flex items-center justify-center shadow-md shadow-emerald-500/20 shrink-0">
                        🔬
                    </span>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs sm:text-sm font-black tracking-tight text-white whitespace-nowrap">PHÂN HỆ KỸ SƯ BVTV</span>
                            <span class="hidden sm:inline-flex px-1.5 py-0.5 rounded text-[9px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 uppercase whitespace-nowrap">
                                FRAC • IRAC
                            </span>
                        </div>
                        <p class="text-[10px] text-slate-400 hidden xl:block leading-tight">Tra cứu hoạt chất & phối trộn nông nghiệp Tây Nguyên</p>
                    </div>
                </div>

                <!-- Navigation Tabs giữa 3 phân hệ kỹ sư -->
                <nav class="hidden md:flex items-center gap-1 p-1 rounded-xl bg-slate-800/90 border border-slate-700/80 shrink-0">
                    <a href="{{ route('phoi-tron.index') }}"
                       class="px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1.5 whitespace-nowrap transition {{ request()->routeIs('phoi-tron.*') ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">
                        <span>🚫</span> Kỵ Phối Trộn
                    </a>
                    <a href="{{ route('hoatchat.index') }}"
                       class="px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1.5 whitespace-nowrap transition {{ request()->routeIs('hoatchat.*') ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">
                        <span>⚗️</span> Tra Cứu Hoạt Chất
                    </a>
                    <a href="{{ route('engineer.benh.index') }}"
                       class="px-2.5 py-1 rounded-lg text-xs font-bold flex items-center gap-1.5 whitespace-nowrap transition {{ request()->routeIs('engineer.benh.*') ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">
                        <span>🌿</span> Bệnh Hại & Phác Đồ
                    </a>
                </nav>

                <!-- User actions & Switcher -->
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="hidden lg:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 transition border border-slate-700 whitespace-nowrap"
                       title="Mở giao diện khách hàng trong tab mới">
                        <span>🌐</span>
                        <span>Cửa hàng ↗</span>
                    </a>

                    @auth
                        <div class="flex items-center gap-2 pl-2 border-l border-slate-800">
                            <span class="w-7 h-7 rounded-lg bg-teal-800 text-teal-100 font-bold text-xs flex items-center justify-center border border-teal-600/40 shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <div class="hidden xl:block text-left">
                                <div class="text-[11px] font-bold text-white leading-tight max-w-[100px] truncate">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-[9px] text-teal-400 font-semibold uppercase leading-tight">
                                    {{ auth()->user()->role === 'admin' ? 'Quản trị viên' : 'Kỹ sư BVTV' }}
                                </div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition cursor-pointer"
                                        title="Đăng xuất khỏi hệ thống">
                                    <span class="text-xs">🚪</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Tabs Bar -->
            <div class="md:hidden flex items-center gap-1 py-2 border-t border-slate-800 text-xs">
                <a href="{{ route('phoi-tron.index') }}"
                   class="flex-1 text-center py-2 rounded-xl font-bold transition {{ request()->routeIs('phoi-tron.*') ? 'bg-teal-600 text-white' : 'text-slate-300 bg-slate-800' }}">
                    🚫 Kỵ Trộn
                </a>
                <a href="{{ route('hoatchat.index') }}"
                   class="flex-1 text-center py-2 rounded-xl font-bold transition {{ request()->routeIs('hoatchat.*') ? 'bg-teal-600 text-white' : 'text-slate-300 bg-slate-800' }}">
                    ⚗️ Hoạt Chất
                </a>
                <a href="{{ route('engineer.benh.index') }}"
                   class="flex-1 text-center py-2 rounded-xl font-bold transition {{ request()->routeIs('engineer.benh.*') ? 'bg-teal-600 text-white' : 'text-slate-300 bg-slate-800' }}">
                    🌿 Bệnh Hại
                </a>
            </div>
        </div>
    </header>

    <!-- 2. MAIN WORKSPACE SLOT -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- 3. TECHNICAL FOOTER (NO E-COMMERCE ELEMENTS) -->
    <footer class="mt-auto bg-slate-900 border-t border-slate-800 text-slate-400 py-6 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span>🔬</span>
                <span class="font-bold text-slate-300">Phân Hệ Nghiên Cứu Kỹ Sư BVTV Tây Nguyên</span>
                <span>•</span>
                <span>Chuẩn hóa FRAC & IRAC</span>
            </div>
            <div class="text-[11px] text-slate-500">
                Hệ thống chuyên môn hóa kỹ thuật nông nghiệp — Dành riêng cho Kỹ sư và Quản trị viên.
            </div>
        </div>
    </footer>

</body>
</html>
