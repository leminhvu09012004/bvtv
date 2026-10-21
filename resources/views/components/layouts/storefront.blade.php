<!DOCTYPE html>
<html lang="vi" class="h-full overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'Cửa hàng vật tư nông nghiệp & sổ tay tra cứu thuốc bảo vệ thực vật chính hãng' }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Sổ Tay Thuốc BVTV Tây Nguyên</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full w-full max-w-full overflow-x-hidden flex flex-col bg-slate-50/60 font-sans text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- 0. ADMIN MASTER INTERFACE SWITCHER -->
        <div class="bg-slate-900 text-slate-200 px-3 sm:px-4 py-1.5 text-xs border-b border-slate-800 shadow-inner z-50">
            <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-black bg-rose-900/80 text-rose-200 border border-rose-700/60 uppercase tracking-wider">
                        <span>🛡️</span> QUẢN TRỊ VIÊN
                    </span>
                    <span class="text-slate-400 text-xs hidden sm:inline">Chuyển đổi phân hệ:</span>
                </div>
                <div class="flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition font-medium text-xs">
                        <span>🏢</span> Quản trị kho
                    </a>
                    <a href="{{ route('phoi-tron.index') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg {{ request()->routeIs('phoi-tron.*') ? 'bg-teal-600 text-white font-bold shadow-xs' : 'bg-slate-800 hover:bg-slate-700 text-teal-300 hover:text-teal-200' }} transition text-xs">
                        <span>🔬</span> Phân hệ Kỹ sư
                    </a>
                    <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-blue-300 hover:text-blue-200 transition text-xs">
                        <span>💻</span> Quầy Bán POS
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg {{ request()->routeIs('home') ? 'bg-emerald-700 text-white font-bold shadow-xs' : 'bg-slate-800 hover:bg-slate-700 text-emerald-300 hover:text-emerald-200' }} transition text-xs">
                        <span>🌐</span> Cửa hàng
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-emerald-900 text-emerald-100 text-[11px] sm:text-xs py-1.5 px-3 sm:px-4 border-b border-emerald-800 overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3 overflow-hidden">
            <div class="flex items-center gap-2 min-w-0 overflow-hidden">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                <span class="font-medium truncate text-[11px] sm:text-xs">Cửa hàng BVTV Tây Nguyên — 100% thuốc chính hãng có tem kiểm định Cục BVTV</span>
            </div>
            <div class="hidden md:flex items-center gap-4 text-emerald-200 shrink-0">
                <span>📞 Hotline tư vấn: <strong class="text-white">0984.123.456</strong></span>
                <span>•</span>
                <span>🚚 Giao tận vườn toàn quốc</span>
            </div>
        </div>
    </div>

    <!-- 2. MAIN HEADER (E-COMMERCE FULL-WIDTH) -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200/80 shadow-2xs backdrop-blur-md bg-white/95"
            x-data="{ mobileMenuOpen: false, searchExpanded: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-3 sm:gap-6">

                <!-- Logo & Brand -->
                <div class="flex items-center gap-3 shrink-0">
                    <!-- Mobile Hamburger Button -->
                    <button type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 focus:outline-none"
                            aria-label="Mở Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm group-hover:scale-105 transition-transform duration-200">
                            🌿
                        </div>
                        <div>
                            <div class="font-extrabold text-base sm:text-xl text-slate-900 leading-tight group-hover:text-emerald-700 transition">
                                Sổ Tay BVTV
                            </div>
                            <div class="text-[10px] sm:text-xs font-semibold text-emerald-600 tracking-tight">
                                Nông Nghiệp Tây Nguyên
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Central Search Bar (Desktop) with Live Autocomplete -->
                <div class="hidden md:flex flex-1 max-w-xl mx-2 relative"
                     x-data="headerSearch()"
                     @click.away="isOpen = false">
                    <form action="{{ route('thuoc.tra-cuu') }}" method="GET" class="w-full relative">
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 text-base">🔍</span>
                            <input type="text"
                                   name="q"
                                   x-model="query"
                                   @input.debounce.300ms="search()"
                                   @focus="if(query.trim().length >= 2) isOpen = true"
                                   @keydown.escape="isOpen = false"
                                   autocomplete="off"
                                   placeholder="Tìm tên thuốc, hoạt chất, sâu bệnh (rầy xanh, rệp sáp, xì mủ...)"
                                   class="w-full pl-10 pr-24 py-2.5 text-xs sm:text-sm bg-slate-100 hover:bg-white focus:bg-white border border-slate-200 focus:border-emerald-500 rounded-2xl focus:ring-2 focus:ring-emerald-100 transition shadow-2xs focus:outline-none">
                            <button type="submit"
                                    class="absolute right-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-2xs">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>

                    <!-- Autocomplete Dropdown Result Box -->
                    <div x-show="isOpen && (results.length > 0 || loading || (query.trim().length >= 2 && !loading && results.length === 0))"
                         x-cloak
                         class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50 divide-y divide-slate-100 max-h-96 overflow-y-auto">
                        <!-- Loading State -->
                        <div x-show="loading" class="p-4 text-center text-xs text-slate-500 flex items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Đang tra cứu cơ sở dữ liệu BVTV...</span>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!loading && results.length === 0 && query.trim().length >= 2" class="p-4 text-center text-xs text-slate-500">
                            Không tìm thấy thuốc hoặc hoạt chất nào khớp với "<span class="font-bold text-slate-800" x-text="query"></span>".
                        </div>

                        <!-- Results List -->
                        <template x-for="item in results" :key="item.id">
                            <a :href="item.url_xem" class="flex items-center gap-3 p-3 hover:bg-emerald-50/70 transition group">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                    <template x-if="item.image_url">
                                        <img :src="item.image_url" :alt="item.ten" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image_url">
                                        <span class="text-xl">🌿</span>
                                    </template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-emerald-700 truncate" x-text="item.ten"></span>
                                        <span x-show="item.danh_muc" class="text-[10px] px-1.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 font-medium shrink-0" x-text="item.danh_muc"></span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 truncate mt-0.5" x-show="item.hoat_chat">
                                        Hoạt chất: <span class="font-medium text-slate-700" x-text="item.hoat_chat"></span>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-xs font-bold text-emerald-700" x-text="item.formatted_price || 'Liên hệ'"></div>
                                    <span class="text-[10px] text-slate-400 group-hover:text-emerald-600 font-medium">Chi tiết ➔</span>
                                </div>
                            </a>
                        </template>

                        <!-- Footer Link: Tra cứu nâng cao -->
                        <div x-show="!loading && results.length > 0" class="p-2.5 bg-slate-50 text-center">
                            <a :href="'{{ route('thuoc.tra-cuu') }}?q=' + encodeURIComponent(query)" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                                <span>Xem toàn bộ kết quả cho "<span x-text="query"></span>"</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Header Actions (Hotline, Tank-mix, Cart) -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">

                    <!-- Mobile search toggle -->
                    <button type="button"
                            @click="searchExpanded = !searchExpanded"
                            class="md:hidden p-2 text-slate-600 hover:text-emerald-600 hover:bg-slate-100 rounded-xl transition">
                        <span class="text-lg">🔍</span>
                    </button>

                    <!-- Hotline pill (Desktop) -->
                    <a href="tel:0984123456"
                       class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 transition text-xs">
                        <span class="text-base">📞</span>
                        <div>
                            <div class="text-[10px] text-slate-400 font-medium leading-none">Tư vấn kỹ thuật</div>
                            <div class="font-bold text-slate-900 text-xs leading-tight">0984.123.456</div>
                        </div>
                    </a>

                    <!-- POS Switcher button (Staff/Admin only) -->
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'staff']))
                        <a href="{{ route('pos.index') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition border border-slate-200/80"
                           title="Chuyển sang Bàn bán hàng thu ngân">
                            <span>💻</span>
                            <span class="hidden md:inline">Bán POS</span>
                        </a>
                    @endif

                    <!-- Wishlist (Yêu thích) -->
                    <a href="{{ route('thuoc.tra-cuu') }}"
                       class="hidden lg:inline-flex items-center gap-1.5 px-2.5 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-rose-600 hover:bg-slate-100 transition"
                       title="Danh sách yêu thích">
                        <span>❤️</span>
                        <span>Yêu thích</span>
                    </a>

                    <!-- Account (Tài khoản) - Auth vs Guest -->
                    @auth
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button type="button"
                                    @click="userMenuOpen = !userMenuOpen"
                                    @click.away="userMenuOpen = false"
                                    class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:text-emerald-700 hover:bg-slate-100 transition border border-slate-200"
                                    title="Menu tài khoản">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden xl:inline max-w-[110px] truncate text-slate-900 font-bold">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-[10px] text-slate-400">▼</span>
                            </button>
                            <div x-show="userMenuOpen"
                                 x-cloak
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 text-xs">
                                <!-- User Info Header -->
                                <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/70">
                                    <div class="font-bold text-slate-900 truncate">{{ auth()->user()->name }}</div>
                                    <div class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email ?? auth()->user()->phone ?? auth()->user()->username }}</div>
                                    <div class="mt-1.5">
                                        @if(auth()->user()->role === 'admin')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-800">
                                                🛡️ Quản trị viên
                                            </span>
                                        @elseif(auth()->user()->role === 'staff')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-100 text-blue-800">
                                                💻 Thu ngân POS
                                            </span>
                                        @elseif(auth()->user()->role === 'engineer')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-100 text-purple-800">
                                                🔬 Kỹ sư BVTV
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">
                                                🌱 Khách hàng nông hộ
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Links by Role -->
                                <div class="py-1">
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                            <span>🏢</span> Quản lý kho & sổ cái
                                        </a>
                                        <a href="{{ route('thuoc.quan-ly') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                            <span>💊</span> Quản lý thuốc & danh mục
                                        </a>
                                        <a href="{{ route('phoi-tron.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-teal-700 font-medium">
                                            <span>🔬</span> Kỹ sư: Kỵ phối trộn thuốc
                                        </a>
                                        <a href="{{ route('hoatchat.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-teal-700 font-medium">
                                            <span>⚗️</span> Kỹ sư: Tra cứu hoạt chất
                                        </a>
                                        <a href="{{ route('pos.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-blue-700 font-medium">
                                            <span>💻</span> Quầy thu ngân POS
                                        </a>
                                    @endif

                                    @if(auth()->user()->role === 'staff')
                                        <a href="{{ route('pos.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-bold text-emerald-800">
                                            <span>💻</span> Vào Bàn bán POS
                                        </a>
                                    @endif

                                    @if(auth()->user()->role === 'engineer')
                                        <a href="{{ route('phoi-tron.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                            <span>🚫</span> Kiểm tra phối trộn Tank-mix
                                        </a>
                                        <a href="{{ route('hoatchat.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                            <span>⚗️</span> Tra cứu hoạt chất
                                        </a>
                                    @endif

                                    <a href="{{ route('customer.account') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                        <span>🏡</span> Hồ sơ nông hộ & Vườn
                                    </a>
                                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-emerald-700 font-medium">
                                        <span>🛒</span> Giỏ hàng hiện tại
                                    </a>
                                </div>

                                <!-- Logout Action -->
                                <div class="border-t border-slate-100 pt-1">
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-rose-600 hover:bg-rose-50 text-left font-semibold">
                                            <span>🚪</span> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center gap-1 px-2.5 sm:px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-emerald-700 hover:bg-slate-100 border border-slate-200 transition">
                                <span>🔑</span>
                                <span>Đăng nhập</span>
                            </a>
                            <a href="{{ route('register') }}"
                               class="hidden sm:inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-2xs">
                                <span>🌱</span>
                                <span>Đăng ký</span>
                            </a>
                        </div>
                    @endauth

                    <!-- Cart Button with Live Dynamic Counter -->
                    @php $storefrontCartCount = app(\App\Services\CartService::class)->getCount(); @endphp
                    <a href="{{ route('cart.index') }}"
                       class="relative inline-flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition shadow-sm hover:shadow-md group">
                        <span class="text-base sm:text-lg">🛒</span>
                        <span class="hidden sm:inline">Giỏ hàng</span>
                        <span id="cart-badge-storefront"
                              class="{{ $storefrontCartCount > 0 ? '' : 'hidden' }} px-1.5 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 leading-none shadow-xs">
                            {{ $storefrontCartCount }}
                        </span>
                    </a>
                </div>

            </div>

            <!-- Mobile Expandable Search Bar -->
            <div x-show="searchExpanded"
                 x-cloak
                 class="pb-3 md:hidden">
                <form action="{{ route('thuoc.tra-cuu') }}" method="GET" class="w-full relative">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Tìm thuốc, hoạt chất, sâu bệnh..."
                           class="w-full pl-3.5 pr-20 py-2 text-xs bg-slate-100 border border-slate-300 rounded-xl focus:border-emerald-500 focus:outline-none">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-3 bg-emerald-600 text-white font-bold text-xs rounded-lg">
                        Tìm
                    </button>
                </form>
            </div>
        </div>

        <!-- Sub-Navigation Mega Bar (Desktop) -->
        <div class="hidden lg:block bg-slate-50/90 border-t border-slate-100 text-xs font-medium text-slate-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-1 py-1.5">
                    <a href="{{ route('thuoc.tra-cuu') }}"
                       class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-white transition flex items-center gap-1.5 font-bold text-slate-800 {{ request()->routeIs('thuoc.tra-cuu') ? 'text-emerald-700 bg-white shadow-2xs' : '' }}">
                        <span>🌾 Tất cả thuốc BVTV</span>
                    </a>
                    <a href="{{ route('benh.danh-sach') }}"
                       class="px-3 py-1.5 rounded-lg hover:text-emerald-700 hover:bg-white transition flex items-center gap-1.5 {{ request()->routeIs('benh.*') ? 'text-emerald-700 bg-white shadow-2xs font-bold' : '' }}">
                        <span>🌿 Phác đồ sâu bệnh hại</span>
                    </a>
                </div>

                <div class="text-[11px] text-slate-500 flex items-center gap-3">
                    <span>Kho Krông Pắk & Buôn Ma Thuột</span>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer (Offcanvas Menu) -->
        <div x-show="mobileMenuOpen"
             x-cloak
             class="fixed inset-0 z-50 lg:hidden flex">
            <!-- Backdrop -->
            <div @click="mobileMenuOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

            <!-- Drawer Container -->
            <div class="relative w-4/5 max-w-sm bg-white h-full shadow-2xl flex flex-col z-10 overflow-y-auto">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🌿</span>
                        <span class="font-extrabold text-slate-900 text-sm">Sổ Tay BVTV</span>
                    </div>
                    <button type="button" @click="mobileMenuOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-800">
                        ✕
                    </button>
                </div>

                <div class="p-4 space-y-1 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700">🏠 Trang chủ</a>
                    <a href="{{ route('thuoc.tra-cuu') }}" class="block px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700">🔍 Danh mục thuốc BVTV</a>
                    <a href="{{ route('benh.danh-sach') }}" class="block px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700">🌿 Các bài thuốc điều trị</a>
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700">🛒 Giỏ hàng của tôi</a>
                    @auth
                        <a href="{{ route('customer.account') }}" class="block px-3 py-2 rounded-xl hover:bg-emerald-50 hover:text-emerald-700">🌾 Hồ sơ nông hộ & Vườn</a>
                    @endauth
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'staff']))
                        <div class="pt-3 border-t border-slate-100 text-xs">
                            <a href="{{ route('pos.index') }}" class="block px-3 py-2 rounded-xl bg-slate-100 text-slate-800">💻 Quầy Bán POS (Thu ngân)</a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.inventory.index') }}" class="block px-3 py-2 rounded-xl text-slate-500 hover:text-slate-800 mt-1">⚙️ Khu vực Quản trị kho</a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mt-auto p-4 bg-slate-50 border-t border-slate-100 text-xs text-slate-500">
                    <div>📞 Hotline: <strong>0984.123.456</strong></div>
                    <div class="mt-1">Địa chỉ: TT. Phước An, Krông Pắk, Đắk Lắk</div>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. MAIN CONTENT SLOT (FULL WIDTH CONTAINER) -->
    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-start gap-2 shadow-2xs">
                    <span class="text-lg">✅</span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl flex items-start gap-2 shadow-2xs">
                    <span class="text-lg">❌</span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- 4. MODERN E-COMMERCE FOOTER -->
    <footer class="mt-20 bg-slate-900 text-slate-300 text-xs border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">

                <!-- Col 1: Brand & Info (2 cols) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2 text-white text-lg font-extrabold">
                        <span class="text-2xl">🌿</span>
                        <span>Sổ Tay Thuốc BVTV Tây Nguyên</span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Hệ thống thương mại điện tử và cẩm nang nông học chuyên sâu về thuốc bảo vệ thực vật, phân bón dinh dưỡng cho cây trồng chủ lực Tây Nguyên: Sầu riêng, Cà phê, Hồ tiêu, Chanh dây.
                    </p>
                    <div class="space-y-1.5 text-[11px] text-slate-400">
                        <div>🏢 <strong>Kho 1:</strong> Thị trấn Phước An, Huyện Krông Pắk, Tỉnh Đắk Lắk</div>
                        <div>🏢 <strong>Kho 2:</strong> Đường Lê Duẩn, Phường Tân Thành, TP. Buôn Ma Thuột</div>
                        <div>📞 Hotline kỹ thuật: <strong class="text-emerald-400">0984.123.456</strong> (Zalo 24/7)</div>
                    </div>
                </div>

                <!-- Col 2: Danh mục thuốc -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Danh mục thuốc</h3>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="{{ route('thuoc.tra-cuu', ['category' => 'thuoc-tru-nam-benh']) }}" class="hover:text-emerald-400 transition">Thuốc trừ nấm bệnh</a></li>
                        <li><a href="{{ route('thuoc.tra-cuu', ['category' => 'thuoc-tru-sau']) }}" class="hover:text-emerald-400 transition">Thuốc trừ sâu & rầy</a></li>
                        <li><a href="{{ route('thuoc.tra-cuu', ['category' => 'phan-bon-la']) }}" class="hover:text-emerald-400 transition">Phân bón lá vi lượng</a></li>
                        <li><a href="{{ route('thuoc.tra-cuu', ['category' => 'che-pham-vi-sinh']) }}" class="hover:text-emerald-400 transition">Chế phẩm vi sinh vật</a></li>
                        <li><a href="{{ route('thuoc.tra-cuu') }}" class="hover:text-emerald-400 transition">Tất cả sản phẩm</a></li>
                    </ul>
                </div>

                <!-- Col 3: Tra cứu & Dịch vụ khách hàng -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Tra cứu & Dịch vụ</h3>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="{{ route('thuoc.tra-cuu') }}" class="hover:text-emerald-400 transition">Danh mục thuốc BVTV</a></li>
                        <li><a href="{{ route('benh.danh-sach') }}" class="hover:text-emerald-400 transition">Phác đồ sâu bệnh hại</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-emerald-400 transition">Giỏ hàng của tôi</a></li>
                        <li><a href="{{ route('customer.account') }}" class="hover:text-emerald-400 transition">Hồ sơ nông hộ & Vườn</a></li>
                    </ul>
                </div>

                <!-- Col 4: Cam kết khách hàng -->
                <div class="space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Cam kết dịch vụ</h3>
                    <div class="space-y-2 text-slate-400 text-[11px] leading-relaxed">
                        <div class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                            <span>✓</span> 100% Thuốc chính hãng
                        </div>
                        <p>Đầy đủ giấy tờ công bố và hạn sử dụng rõ ràng.</p>
                        <div class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                            <span>✓</span> Đồng kiểm khi nhận COD
                        </div>
                        <p>Bà con kiểm tra thuốc trước khi gửi tiền cho shipper.</p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="mt-12 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-500">
                <div>
                    &copy; 2026 Cửa Hàng Bảo Vệ Thực Vật Tây Nguyên. Tất cả các quyền được bảo hộ.
                </div>
                <div class="flex items-center gap-4">
                    <span>Đạt tiêu chuẩn an toàn Cục BVTV</span>
                    <span>•</span>
                    <span>Bảo tồn mùa màng & cây trồng</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm pointer-events-none"></div>

    <!-- Image Lightbox Modal -->
    <div id="image-lightbox-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-all"
        onclick="if(event.target===this)dongModalAnh()">
        <div class="relative max-w-2xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/80">
                <span id="lightbox-title" class="font-semibold text-gray-800 text-sm truncate max-w-md">Hình ảnh thuốc</span>
                <button type="button" onclick="dongModalAnh()"
                    class="w-8 h-8 rounded-full hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center text-lg font-bold transition-colors">
                    &times;
                </button>
            </div>
            <div class="p-2 bg-gray-950/5 flex items-center justify-center min-h-[250px] max-h-[75vh] overflow-auto">
                <img id="lightbox-img" src="" alt="" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-sm">
            </div>
        </div>
    </div>

    <script>
        function moModalAnh(src, ten) {
            const modal = document.getElementById('image-lightbox-modal');
            const img = document.getElementById('lightbox-img');
            const title = document.getElementById('lightbox-title');
            if (!modal || !img) return;
            img.src = src;
            img.alt = ten || 'Ảnh thuốc';
            if (title) title.textContent = ten || 'Hình ảnh thuốc';
            modal.classList.remove('hidden');
        }
        function dongModalAnh() {
            document.getElementById('image-lightbox-modal')?.classList.add('hidden');
        }
        window.moModalAnh = moModalAnh;
        window.dongModalAnh = dongModalAnh;

        // Reactive Cart Badge Updater for Storefront
        window.addEventListener('cart-updated', function (e) {
            const count = (e.detail && typeof e.detail.count !== 'undefined') ? e.detail.count : 0;
            const badge = document.getElementById('cart-badge-storefront');
            if (badge) {
                badge.textContent = count;
                badge.classList.toggle('hidden', count <= 0);
            }
        });

        // Global Toast Notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `p-3.5 rounded-2xl shadow-xl text-xs font-bold text-white flex items-center gap-2 transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto ${
                type === 'error' ? 'bg-rose-600' : 'bg-emerald-600'
            }`;
            toast.innerHTML = `<span>${type === 'error' ? '⚠️' : '✅'}</span><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
        // Quick Add To Cart from product card
        async function quickAddToCart(variantId, name = 'Sản phẩm') {
            try {
                const res = await fetch("{{ route('ajax.cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ variant_id: variantId, quantity: 1 })
                });
                const data = await res.json();
                if (data.success) {
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart }));
                    showToast(`✅ Đã thêm "${name}" vào giỏ hàng!`);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            } catch (e) {
                showToast('Lỗi kết nối khi thêm giỏ hàng', 'error');
            }
        }
        window.quickAddToCart = quickAddToCart;
        window.showToast = showToast;

        // Alpine Live Autocomplete Search Component
        function headerSearch() {
            return {
                query: @json(request('q', '')),
                results: [],
                loading: false,
                isOpen: false,
                async search() {
                    const q = this.query.trim();
                    if (q.length < 2) {
                        this.results = [];
                        this.isOpen = false;
                        return;
                    }
                    this.loading = true;
                    this.isOpen = true;
                    try {
                        const res = await fetch(`{{ route('ajax.tim-kiem') }}?q=${encodeURIComponent(q)}`, {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!res.ok) throw new Error('Search failed');
                        const data = await res.json();
                        this.results = (data.data || []).slice(0, 6);
                    } catch (err) {
                        console.error('Lỗi tra cứu AJAX:', err);
                        this.results = [];
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
        window.headerSearch = headerSearch;
    </script>
</body>
</html>
