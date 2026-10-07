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
    <form action="{{ route('thuoc.tra-cuu') }}" method="GET" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="q"
                placeholder="🔍 Tìm nhanh tên thuốc, hoạt chất, sâu bệnh (rầy xanh, rệp sáp, xì mủ, rỉ sắt...)"
                class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-xs"
            >
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg text-sm font-medium transition-colors shadow-xs cursor-pointer">
                Tìm kiếm
            </button>
        </div>
    </form>


    <!-- Chức năng Tra cứu (Dành cho Người dùng - Chỉ xem) -->
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-2.5">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                🔍 Tra cứu (Người dùng)
            </span>
            <span class="text-xs text-gray-400">Xem thông tin thuốc, hoạt chất, liều lượng và phác đồ</span>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('thuoc.tra-cuu') }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-xs">
                <span>🔍</span> Tra cứu thuốc
            </a>
            <a href="{{ route('hoatchat.index') }}"
               class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-800 border border-emerald-300 hover:border-emerald-400 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-2xs">
                <span>⚗️</span> Tra cứu hoạt chất
            </a>
            <a href="{{ route('benh.danh-sach') }}"
               class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-800 border border-emerald-300 hover:border-emerald-400 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-2xs">
                <span>🌿</span> Các bài thuốc trị bệnh
            </a>
            <a href="{{ route('phoi-tron.index') }}"
               class="inline-flex items-center gap-2 bg-white hover:bg-red-50 text-red-800 border border-red-200 hover:border-red-400 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-2xs">
                <span>🚫</span> Kỵ phối trộn thuốc
            </a>
        </div>
    </div>

    <!-- Khu vực Quản trị (Admin - CRUD) -->
    <div class="mb-6 p-4 bg-amber-50/80 border border-amber-200 rounded-2xl">
        <div class="flex items-center justify-between gap-2 mb-2.5">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-900 bg-amber-100 border border-amber-300 px-2 py-0.5 rounded-md">
                    ⚙️ Khu vực Quản trị (Admin)
                </span>
                <span class="text-xs text-amber-700 hidden sm:inline">Thêm, sửa, xóa, xuất nhập dữ liệu</span>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('thuoc.quan-ly') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>💊</span> Quản lý thuốc
            </a>
            <a href="{{ route('danhmuc.danh-sach') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>📁</span> Quản lý danh mục
            </a>
            <a href="{{ route('benh.quan-ly') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>🌿</span> Quản lý bài thuốc
            </a>
            <a href="{{ route('thuoc.them') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>➕</span> Thêm thuốc mới
            </a>
            <a href="{{ route('thuoc.nhap-csv') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>📤</span> Import CSV
            </a>
            <a href="{{ route('thuoc.xuat-csv') }}"
               class="inline-flex items-center gap-1.5 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>📥</span> Xuất CSV đầy đủ
            </a>
            <a href="{{ route('thuoc.xuat-ten') }}"
               class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-300 px-3.5 py-2 rounded-lg text-xs font-semibold transition-colors shadow-2xs">
                <span>📊</span> Xuất 1 cột tên Excel
            </a>
        </div>
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
