<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'Sổ tay điện tử lưu trữ thông tin thuốc bảo vệ thực vật cá nhân' }}">
    <title>{{ isset($title) ? $title.' — ' : '' }}Sổ Tay Thuốc BVTV</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans text-gray-800">

<!-- Mobile header -->
<header class="lg:hidden sticky top-0 z-40 bg-green-700 text-white flex items-center justify-between px-4 py-3 shadow-md">
    <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg">
        🌿 Sổ Tay BVTV
    </a>
    <button id="mobile-menu-btn" class="p-1 rounded-md hover:bg-green-600 focus:outline-none" aria-label="Mở menu">
        <svg id="icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</header>

<!-- Mobile sidebar overlay -->
<div id="mobile-overlay" class="lg:hidden fixed inset-0 bg-black/50 z-30 hidden"></div>

<!-- Layout container -->
<div class="flex h-full min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="
        fixed lg:static inset-y-0 left-0 z-40
        w-64 bg-white border-r border-gray-200
        flex flex-col
        -translate-x-full lg:translate-x-0
        transition-transform duration-200
        lg:h-screen lg:sticky lg:top-0
    ">
        <!-- Brand -->
        <div class="hidden lg:flex items-center gap-2 px-5 py-4 border-b border-gray-200">
            <span class="text-2xl">🌿</span>
            <div class="min-w-0">
                <div class="font-bold text-green-700 leading-tight">Sổ Tay BVTV</div>
                <div class="text-xs text-gray-500">Thuốc BVTV Tây Nguyên</div>
                <div class="text-[10px] text-green-600 font-medium truncate">Sầu riêng • Cà phê • Tiêu • Chanh dây</div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5">
            <a href="{{ route('home') }}"
               class="sidebar-link {{ request()->routeIs('home') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                🏠 Trang chủ
            </a>
            <a href="{{ route('thuoc.danh-sach') }}"
               class="sidebar-link {{ request()->routeIs('thuoc.danh-sach') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                💊 Tất cả thuốc
            </a>

            <a href="{{ route('danhmuc.danh-sach') }}"
               class="sidebar-link {{ request()->routeIs('danhmuc.*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                📁 Quản lý danh mục
            </a>

            <div class="pt-2 pb-1 px-2">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Công cụ</p>
            </div>
            <a href="{{ route('thuoc.them') }}"
               class="sidebar-link text-gray-700 hover:bg-gray-100">
                ➕ Thêm thuốc mới
            </a>
            <a href="{{ route('thuoc.xuat-csv') }}"
               class="sidebar-link text-gray-700 hover:bg-gray-100">
                📥 Xuất CSV
            </a>
            <a href="{{ route('thuoc.nhap-csv') }}"
               class="sidebar-link text-gray-700 hover:bg-gray-100">
                📤 Import CSV
            </a>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 min-w-0 overflow-y-auto">
        @if(session('success'))
            <div class="mx-4 mt-4 lg:mx-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-start gap-2" role="alert">
                <span class="shrink-0">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mx-4 mt-4 lg:mx-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-start gap-2" role="alert">
                <span class="shrink-0">❌</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot }}
    </main>
</div>

<!-- Toast notification container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm"></div>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Xác nhận xóa</h3>
        <p class="text-gray-600 mb-5" id="delete-modal-text">Bạn có chắc muốn xóa sản phẩm này không?</p>
        <div class="flex gap-3 justify-end">
            <button onclick="dongModalXoa()" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium">
                Hủy
            </button>
            <button id="ajax-xoa-btn" type="button" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 text-sm font-medium">
                Xóa
            </button>
        </div>
    </div>
</div>

<!-- Modal phóng to hình ảnh (Lightbox) -->
<div id="image-lightbox-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-all" onclick="if(event.target===this)dongModalAnh()">
    <div class="relative max-w-2xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/80">
            <span id="lightbox-title" class="font-semibold text-gray-800 text-sm truncate max-w-md">Hình ảnh thuốc</span>
            <button type="button" onclick="dongModalAnh()" class="w-8 h-8 rounded-full hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center text-lg font-bold transition-colors">
                &times;
            </button>
        </div>
        <div class="p-2 bg-gray-950/5 flex items-center justify-center min-h-[250px] max-h-[75vh] overflow-auto">
            <img id="lightbox-img" src="" alt="" class="max-h-[70vh] max-w-full object-contain rounded-lg shadow-sm">
        </div>
    </div>
</div>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.625rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: background-color 0.1s;
        text-decoration: none;
    }
</style>

<script>
    // Menu mobile
    const btn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobile-overlay');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    function moMenu() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    }
    function dongMenu() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }
    btn?.addEventListener('click', () => sidebar.classList.contains('-translate-x-full') ? moMenu() : dongMenu());
    overlay?.addEventListener('click', dongMenu);

    // Modal xóa
    function moModalXoa(url, ten) {
        document.getElementById('delete-modal-text').textContent = 'Bạn có chắc muốn xóa sản phẩm "' + ten + '" không?';
        const deleteForm = document.getElementById('delete-form');
        if (deleteForm) deleteForm.action = url;
        const xoaBtn = document.getElementById('ajax-xoa-btn');
        if (xoaBtn) {
            xoaBtn.disabled = false;
            xoaBtn.textContent = 'Xóa';
        }
        document.getElementById('delete-modal')?.classList.remove('hidden');
    }
    function dongModalXoa() {
        document.getElementById('delete-modal')?.classList.add('hidden');
        const xoaBtn = document.getElementById('ajax-xoa-btn');
        if (xoaBtn) {
            xoaBtn.disabled = false;
            xoaBtn.textContent = 'Xóa';
        }
    }
    document.getElementById('delete-modal')?.addEventListener('click', function(e) {
        if (e.target === this) { dongModalXoa(); }
    });

    // Modal Phóng to Ảnh (Lightbox)
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
</script>
</body>
</html>
