<x-layouts.storefront title="Trang chủ — Cửa hàng BVTV Tây Nguyên">


    <!-- 2. FEATURED PRODUCTS WITH LIVE FILTER TOOLBAR -->
    <section class="bg-slate-50/60 border-y border-slate-200/80 py-10 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        Bán chạy & Hiệu quả cao
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 tracking-tight">
                        Sản Phẩm Được Nhà Vườn Tin Dùng
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Các dòng thuốc đặc trị nấm bệnh, rầy xanh và dinh dưỡng được nông dân Tây Nguyên tin chọn.
                    </p>
                </div>
                <a href="{{ route('thuoc.tra-cuu') }}"
                   class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                    <span>Xem toàn bộ {{ $totalPesticides }} sản phẩm</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Filter Toolbar Container -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xs space-y-4">
                
                <!-- Category Chips (Horizontal Scrollable) -->
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2 flex items-center justify-between">
                        <span>📂 Lọc theo danh mục:</span>
                        <span class="text-slate-400 normal-case font-normal text-xs" id="home-filter-count-badge">
                            Đang hiển thị <strong class="text-slate-800" id="home-visible-count">{{ $featuredProducts->count() }}</strong> sản phẩm
                        </span>
                    </div>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin" id="home-category-chips">
                        <button type="button" data-cat-id=""
                                class="home-cat-chip px-3.5 py-1.5 rounded-full text-xs font-bold border transition-all cursor-pointer bg-emerald-700 text-white border-emerald-700 shadow-xs">
                            🌾 Tất cả ({{ $featuredProducts->count() }})
                        </button>
                        @foreach($categories as $cat)
                            <button type="button" data-cat-id="{{ $cat->id }}"
                                    class="home-cat-chip px-3.5 py-1.5 rounded-full text-xs font-medium border transition-all cursor-pointer bg-slate-100 hover:bg-slate-200/80 text-slate-700 border-slate-200 whitespace-nowrap">
                                <span>{{ $cat->emoji ?? '📦' }}</span>
                                <span>{{ $cat->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Secondary Filter Bar (Search + Form Type + In Stock Toggle + Reset) -->
                <div class="pt-3 border-t border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                    
                    <!-- Search input -->
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            🔍
                        </span>
                        <input type="text" id="home-search-input"
                               placeholder="Tìm nhanh theo tên thuốc hoặc hoạt chất..."
                               class="w-full pl-9 pr-8 py-2 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition placeholder:text-slate-400">
                        <button type="button" id="home-search-clear" class="hidden absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 text-xs">
                            ✕
                        </button>
                    </div>

                    <!-- Dropdowns and Toggles -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <!-- Form Type Dropdown -->
                        <div class="relative">
                            <select id="home-form-type-select"
                                    class="text-xs font-semibold py-2 px-3 pr-7 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                                <option value="">💊 Tất cả dạng thuốc</option>
                                <option value="ec">Nhũ dầu (EC)</option>
                                <option value="sc">Huyền phù (SC)</option>
                                <option value="wg">Cốm hòa tan (WG)</option>
                                <option value="wp">Bột thấm nước (WP)</option>
                                <option value="sl">Dung dịch nước (SL)</option>
                                <option value="me">Vi nhũ tương (ME)</option>
                            </select>
                        </div>

                        <!-- In-stock toggle -->
                        <label class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-700 cursor-pointer select-none hover:bg-slate-100 transition">
                            <input type="checkbox" id="home-in-stock-checkbox" class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500">
                            <span>📦 Chỉ hàng có sẵn</span>
                        </label>

                        <!-- Reset button -->
                        <button type="button" id="home-filter-reset-btn"
                                class="hidden text-xs font-bold text-rose-600 hover:text-rose-700 hover:bg-rose-50 px-2.5 py-2 rounded-xl border border-rose-200 transition cursor-pointer">
                            🔄 Đặt lại
                        </button>
                    </div>

                </div>

            </div>

            <!-- Empty State -->
            <div id="home-products-empty" class="hidden bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center space-y-3">
                <div class="text-4xl">🔍</div>
                <h4 class="text-base font-bold text-slate-800">Không tìm thấy sản phẩm nào phù hợp</h4>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Hãy thử đổi từ khóa tìm kiếm hoặc chọn danh mục khác để xem thêm sản phẩm.
                </p>
                <button type="button" onclick="resetHomeFilters()" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200 transition cursor-pointer">
                    🔄 Xem lại tất cả sản phẩm
                </button>
            </div>

            <!-- Product Cards Grid (4 cols desktop, 2 cols mobile) -->
            <div id="home-products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :pesticide="$product" />
                @endforeach
            </div>

        </div>
    </section>

    <!-- Client-side Interactive Filter Script for Home Page -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('home-products-grid');
        if (!grid) return;

        const cards = grid.querySelectorAll('[data-product-card="1"]');
        const emptyState = document.getElementById('home-products-empty');
        const searchInput = document.getElementById('home-search-input');
        const searchClear = document.getElementById('home-search-clear');
        const formSelect = document.getElementById('home-form-type-select');
        const stockCheckbox = document.getElementById('home-in-stock-checkbox');
        const catChips = document.querySelectorAll('.home-cat-chip');
        const resetBtn = document.getElementById('home-filter-reset-btn');
        const countText = document.getElementById('home-visible-count');

        let selectedCatId = '';
        let selectedForm = '';
        let onlyInStock = false;
        let searchQuery = '';

        function applyFilters() {
            let visibleCount = 0;
            const queryNorm = searchQuery.trim().toLowerCase();

            cards.forEach(card => {
                const catId = card.getAttribute('data-category-id') || '';
                const formType = (card.getAttribute('data-form-type') || '').toLowerCase();
                const inStock = card.getAttribute('data-in-stock') === '1';
                const name = (card.querySelector('a[title]')?.getAttribute('title') || '').toLowerCase();
                const ingredient = (card.getAttribute('data-ingredient') || '').toLowerCase();

                let matchCat = !selectedCatId || catId === selectedCatId;
                let matchForm = !selectedForm || formType.includes(selectedForm);
                let matchStock = !onlyInStock || inStock;
                let matchSearch = !queryNorm || name.includes(queryNorm) || ingredient.includes(queryNorm);

                if (matchCat && matchForm && matchStock && matchSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (countText) countText.textContent = visibleCount;
            if (emptyState) emptyState.classList.toggle('hidden', visibleCount > 0);
            if (grid) grid.classList.toggle('hidden', visibleCount === 0);

            // Toggle reset button
            const isFiltered = !!selectedCatId || !!selectedForm || onlyInStock || !!queryNorm;
            if (resetBtn) resetBtn.classList.toggle('hidden', !isFiltered);
            if (searchClear) searchClear.classList.toggle('hidden', !queryNorm);
        }

        // Cat chips click
        catChips.forEach(chip => {
            chip.addEventListener('click', function () {
                selectedCatId = this.getAttribute('data-cat-id') || '';
                catChips.forEach(c => {
                    c.classList.remove('bg-emerald-700', 'text-white', 'border-emerald-700', 'shadow-xs');
                    c.classList.add('bg-slate-100', 'text-slate-700', 'border-slate-200');
                });
                this.classList.remove('bg-slate-100', 'text-slate-700', 'border-slate-200');
                this.classList.add('bg-emerald-700', 'text-white', 'border-emerald-700', 'shadow-xs');
                applyFilters();
            });
        });

        // Search input
        searchInput?.addEventListener('input', function () {
            searchQuery = this.value;
            applyFilters();
        });

        searchClear?.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            applyFilters();
        });

        // Form type select
        formSelect?.addEventListener('change', function () {
            selectedForm = this.value.toLowerCase();
            applyFilters();
        });

        // In-stock checkbox
        stockCheckbox?.addEventListener('change', function () {
            onlyInStock = this.checked;
            applyFilters();
        });

        // Reset
        window.resetHomeFilters = function () {
            selectedCatId = '';
            selectedForm = '';
            onlyInStock = false;
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            if (formSelect) formSelect.value = '';
            if (stockCheckbox) stockCheckbox.checked = false;

            catChips.forEach((c, idx) => {
                if (idx === 0) {
                    c.classList.add('bg-emerald-700', 'text-white', 'border-emerald-700', 'shadow-xs');
                    c.classList.remove('bg-slate-100', 'text-slate-700', 'border-slate-200');
                } else {
                    c.classList.remove('bg-emerald-700', 'text-white', 'border-emerald-700', 'shadow-xs');
                    c.classList.add('bg-slate-100', 'text-slate-700', 'border-slate-200');
                }
            });
            applyFilters();
        };

        resetBtn?.addEventListener('click', window.resetHomeFilters);
    });
    </script>

    <!-- 4. TRUST & COMMITMENT SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Cam Kết Đồng Hành Cùng Nhà Nông
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Đặt lợi ích và sự an toàn của vườn cây lên hàng đầu với 4 trụ cột dịch vụ uy tín.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center space-y-3 shadow-2xs">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 mx-auto flex items-center justify-center text-2xl">
                    🛡️
                </div>
                <h3 class="font-bold text-slate-900 text-sm">100% Thuốc Chính Hãng</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Có mã đăng ký lưu hành Cục BVTV, xuất xứ rõ ràng từ Syngenta, Bayer, Hợp Trí, Lộc Trời...
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center space-y-3 shadow-2xs">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 mx-auto flex items-center justify-center text-2xl">
                    💧
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Hướng Dẫn Pha Chuẩn</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Liều lượng pha phuy cụ thể (200L - 400L), cảnh báo dính màu trái và thời gian cách ly rõ ràng.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center space-y-3 shadow-2xs">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 mx-auto flex items-center justify-center text-2xl">
                    🚚
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Đồng Kiểm Khi Nhận Hàng</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Bà con được mở thùng kiểm tra đúng tên thuốc, hạn dùng mới thanh toán tiền cho nhân viên giao vận.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center space-y-3 shadow-2xs">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 mx-auto flex items-center justify-center text-2xl">
                    📞
                </div>
                <h3 class="font-bold text-slate-900 text-sm">Dược Sĩ Cây Trồng Tư Vấn</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Hỗ trợ chẩn đoán qua hình ảnh lá, trái; đưa phác đồ dứt điểm thán thư, nấm hồng 24/7.
                </p>
            </div>
        </div>
    </section>

    <!-- 5. TANK-MIX LAB CALLOUT BANNER -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="rounded-3xl bg-gradient-to-r from-emerald-800 to-teal-900 text-white p-6 sm:p-10 shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="text-xs font-black uppercase tracking-wider bg-emerald-500 text-white px-2.5 py-0.5 rounded-full">
                    Cẩm Nang Trị Bệnh Nông Nghiệp
                </span>
                <h3 class="text-xl sm:text-2xl font-black">
                    Cần Tìm Phác Đồ Trị Sâu Bệnh Cho Vườn Cây?
                </h3>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-xl">
                    Tra cứu ngay các toa thuốc phối hợp chuẩn đặc trị rầy xanh, rệp sáp, xì mủ sầu riêng, thán thư cà phê và tiêu được kiểm chứng thực tế.
                </p>
            </div>
            <a href="{{ route('benh.tra-cuu') }}"
               class="shrink-0 px-6 py-3.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm rounded-2xl transition shadow-md hover:scale-105">
                🌿 Xem phác đồ sâu bệnh ngay
            </a>
        </div>
    </section>

</x-layouts.storefront>
