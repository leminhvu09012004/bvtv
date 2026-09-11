<x-layouts.app title="Trang chủ">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <div class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-800 text-xs px-2.5 py-1 rounded-full font-medium mb-2">
            📍 Cửa hàng BVTV Tây Nguyên
        </div>
        <h1 class="text-2xl font-bold text-gray-900">🌿 Sổ Tay Thuốc BVTV Tây Nguyên</h1>
        <p class="text-gray-600 mt-1 text-sm">
            Tra cứu & quản lý các loại thuốc bảo vệ thực vật chuyên dùng cho <strong>Sầu riêng • Cà phê • Hồ tiêu • Chanh dây</strong>
        </p>
        <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
            <span>📦 Tổng cộng: <strong class="text-gray-800">{{ $totalPesticides }}</strong> loại thuốc</span>
            <span>🗂️ <strong class="text-gray-800">{{ $categories->count() }}</strong> danh mục</span>
        </div>
    </div>

    <!-- Tìm kiếm nhanh -->
    <form action="{{ route('thuoc.danh-sach') }}" method="GET" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="q"
                placeholder="🔍 Tìm nhanh tên thuốc, hoạt chất, sâu bệnh (rầy xanh, rệp sáp, xì mủ, rỉ sắt...)"
                class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-xs"
            >
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg text-sm font-medium transition-colors shadow-xs">
                Tìm kiếm
            </button>
        </div>
    </form>

    <!-- Cây trồng chủ lực Tây Nguyên -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <span>🌳</span> Cây trồng chủ lực Tây Nguyên
            </h2>
            <span class="text-xs text-gray-400">Bấm để lọc thuốc theo cây</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <!-- Sầu riêng -->
            <a href="{{ route('thuoc.danh-sach', ['cay_trong' => 'Sầu riêng']) }}"
               class="group bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200/80 hover:border-amber-400 rounded-xl p-4 transition-all hover:shadow-md">
                <div class="text-3xl mb-2">🍈</div>
                <div class="font-bold text-gray-900 group-hover:text-amber-700 transition-colors">Sầu riêng</div>
                <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">Rầy xanh, rệp sáp, xì mủ, thán thư</div>
                <div class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-amber-700 bg-amber-100/70 px-2 py-0.5 rounded-full">
                    {{ $cropStats['sau_rieng'] }} thuốc
                </div>
            </a>

            <!-- Cà phê -->
            <a href="{{ route('thuoc.danh-sach', ['cay_trong' => 'Cà phê']) }}"
               class="group bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/80 hover:border-emerald-400 rounded-xl p-4 transition-all hover:shadow-md">
                <div class="text-3xl mb-2">☕</div>
                <div class="font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">Cà phê</div>
                <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">Rỉ sắt, rệp sáp, mọt cành, ve sầu</div>
                <div class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-100/70 px-2 py-0.5 rounded-full">
                    {{ $cropStats['ca_phe'] }} thuốc
                </div>
            </a>

            <!-- Hồ tiêu -->
            <a href="{{ route('thuoc.danh-sach', ['cay_trong' => 'Hồ tiêu']) }}"
               class="group bg-gradient-to-br from-green-50 to-lime-50 border border-green-200/80 hover:border-green-400 rounded-xl p-4 transition-all hover:shadow-md">
                <div class="text-3xl mb-2">🌿</div>
                <div class="font-bold text-gray-900 group-hover:text-green-700 transition-colors">Hồ tiêu</div>
                <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">Chết nhanh, chết chậm, tuyến trùng</div>
                <div class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-100/70 px-2 py-0.5 rounded-full">
                    {{ $cropStats['ho_tieu'] }} thuốc
                </div>
            </a>

            <!-- Chanh dây -->
            <a href="{{ route('thuoc.danh-sach', ['cay_trong' => 'Chanh dây']) }}"
               class="group bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-200/80 hover:border-purple-400 rounded-xl p-4 transition-all hover:shadow-md">
                <div class="text-3xl mb-2">🟣</div>
                <div class="font-bold text-gray-900 group-hover:text-purple-700 transition-colors">Chanh dây</div>
                <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">Đốm dầu, bã trầu, phấn trắng, nhện đỏ</div>
                <div class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-purple-700 bg-purple-100/70 px-2 py-0.5 rounded-full">
                    {{ $cropStats['chanh_day'] }} thuốc
                </div>
            </a>
        </div>
    </div>

    <!-- Thao tác nhanh -->
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('thuoc.them') }}"
           class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-xs">
            ➕ Thêm thuốc mới
        </a>
        <a href="{{ route('thuoc.danh-sach') }}"
           class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            💊 Xem tất cả thuốc
        </a>
        <a href="{{ route('danhmuc.danh-sach') }}"
           class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            📁 Quản lý danh mục
        </a>
    </div>

    <!-- Lưới danh mục -->
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-base font-bold text-gray-900">Danh mục thuốc</h2>
        <a href="{{ route('danhmuc.danh-sach') }}" class="text-xs text-green-700 hover:underline">Quản lý danh mục →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($categories as $category)
            <a href="{{ route('danhmuc.xem', $category->slug) }}"
               class="group bg-white border border-gray-200 rounded-xl p-4 hover:border-green-400 hover:shadow-md transition-all flex items-center gap-3.5">
                <div class="text-2xl shrink-0">{{ $category->emoji }}</div>
                <div class="min-w-0">
                    <div class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors leading-tight text-sm">
                        {{ $category->name }}
                    </div>
                    <div class="text-xs text-gray-500 mt-0.5">
                        {{ $category->pesticides_count }} sản phẩm
                    </div>
                </div>
                <div class="ml-auto shrink-0 text-gray-400 group-hover:text-green-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        @endforeach
    </div>
</div>
</x-layouts.app>
