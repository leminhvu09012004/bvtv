<x-layouts.storefront title="Tra cứu thuốc BVTV">
    <div class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto">

        <!-- Header & Hero -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <div
                    class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs px-3 py-1 rounded-full font-medium mb-2">
                    <span>🌱</span> Sổ Tay Tra Cứu Nông Nghiệp
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                    Tra Cứu Thuốc Bảo Vệ Thực Vật
                </h1>
                <p class="text-gray-500 text-sm mt-1 max-w-2xl">
                    Thông tin chuẩn xác về nhãn thuốc, hoạt chất, đặc tính lưu dẫn và công dụng phòng trị sâu bệnh cây
                    trồng Tây Nguyên.
                </p>
            </div>

            <!-- Liên kết hữu ích cho nhà nông -->
            <div class="flex items-center gap-2 self-start md:self-auto shrink-0">
                <a href="{{ route('benh.tra-cuu') }}"
                    class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 px-3.5 py-2 rounded-xl text-xs font-semibold shadow-2xs transition-all">
                    <span>🌿</span> Phác đồ trị sâu bệnh
                </a>
            </div>
        </div>

        <!-- Search & Filters Bar -->
        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5 shadow-xs mb-6 space-y-4">

            <!-- Search Input & View Toggle -->
            <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                <div class="relative flex-1">
                    <span
                        class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 text-base">
                        🔍
                    </span>
                    <input type="text" id="user-search-input" value="{{ request('q') }}"
                        placeholder="Gõ để tìm thuốc theo tên, hoạt chất, nấm bệnh, sâu rầy..."
                        class="w-full pl-10 pr-10 py-2.5 bg-gray-50/70 hover:bg-gray-50 focus:bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder:text-gray-400"
                        autocomplete="off">
                    <button type="button" id="user-search-clear"
                        class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 text-sm cursor-pointer"
                        title="Xóa tìm kiếm">
                        ✕
                    </button>
                </div>

                <!-- View Switcher (Grid vs Table) -->
                <div
                    class="inline-flex items-center bg-gray-100 p-1 rounded-xl shrink-0 self-end sm:self-auto border border-gray-200/70">
                    <button type="button" id="btn-view-grid"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-emerald-700 shadow-xs cursor-pointer"
                        title="Dạng Lưới Thẻ Sản Phẩm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Lưới thẻ</span>
                    </button>
                    <button type="button" id="btn-view-table"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-gray-900 transition-all cursor-pointer"
                        title="Dạng Bảng Danh Sách">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Bảng gọn</span>
                    </button>
                </div>
            </div>

            <!-- Unified Single Filter Bar (Phân loại & Nhu cầu, Dạng thuốc, Mức giá, Còn hàng) -->
            <div class="pt-3 pb-2 border-t border-gray-100 flex flex-col gap-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-2.5 items-center">
                    <!-- 1. Bộ chọn Nhu cầu & Phân loại duy nhất (Không bao giờ bị xung đột chéo) -->
                    <div class="relative sm:col-span-2 md:col-span-1 lg:col-span-1">
                        <select id="filter-classification"
                                class="w-full text-xs font-semibold py-2.5 px-3 pr-7 bg-gray-50/90 hover:bg-gray-100 focus:bg-white border border-gray-200 focus:border-emerald-500 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 cursor-pointer transition">
                            <option value="">📁 Tất cả sản phẩm ({{ $totalPesticides }})</option>
                            <optgroup label="── 📦 THEO DANH MỤC THUỐC ──">
                                @foreach($categories as $cat)
                                    @continue($cat->pesticides_count == 0)
                                    @php
                                        $isCatMatch = empty($selectedPurpose) && ((($selectedCategoryId ?? request('category_id')) == $cat->id) || (($selectedCategorySlug ?? request('category')) == $cat->slug));
                                    @endphp
                                    <option value="cat:{{ $cat->id }}" data-type="category" data-id="{{ $cat->id }}" data-slug="{{ $cat->slug }}" {{ $isCatMatch ? 'selected' : '' }}>
                                        {{ $cat->emoji }} {{ $cat->name }} ({{ $cat->pesticides_count }})
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="── 🎯 THEO MỤC ĐÍCH & GIAI ĐOẠN ──">
                                @foreach(\App\Models\Pesticide::PURPOSES as $pKey => $pMeta)
                                    @php
                                        $isPurpMatch = ($selectedPurpose ?? request('muc_dich') ?? request('purpose')) === $pKey;
                                        $count = $purposeCounts[$pKey] ?? 0;
                                    @endphp
                                    @continue($count == 0)
                                    <option value="purp:{{ $pKey }}" data-type="purpose" data-purpose="{{ $pKey }}" {{ $isPurpMatch ? 'selected' : '' }}>
                                        {{ $pMeta['emoji'] }} {{ $pMeta['label'] }} ({{ $count }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <!-- 2. Dạng thuốc Dropdown -->
                    <div class="relative">
                        <select id="filter-form-type"
                                class="w-full text-xs font-semibold py-2.5 px-3 pr-7 bg-gray-50/90 hover:bg-gray-100 focus:bg-white border border-gray-200 focus:border-emerald-500 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 cursor-pointer transition">
                            <option value="">💊 Tất cả dạng thuốc</option>
                            <option value="ec">Nhũ dầu (EC)</option>
                            <option value="sc">Huyền phù (SC)</option>
                            <option value="wg">Cốm hòa tan (WG)</option>
                            <option value="wp">Bột thấm nước (WP)</option>
                            <option value="sl">Dung dịch nước (SL)</option>
                            <option value="me">Vi nhũ tương (ME)</option>
                            <option value="gr">Dạng hạt (GR)</option>
                        </select>
                    </div>

                    <!-- 3. Mức giá Dropdown -->
                    <div class="relative">
                        <select id="filter-price-range"
                                class="w-full text-xs font-semibold py-2.5 px-3 pr-7 bg-gray-50/90 hover:bg-gray-100 focus:bg-white border border-gray-200 focus:border-emerald-500 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 cursor-pointer transition">
                            <option value="">💰 Tất cả mức giá</option>
                            <option value="under_100k">Dưới 100.000 ₫</option>
                            <option value="100k_300k">100.000 ₫ - 300.000 ₫</option>
                            <option value="above_300k">Trên 300.000 ₫</option>
                        </select>
                    </div>

                    <!-- 4. Tùy chọn Còn hàng & Đặt lại -->
                    <div class="flex items-center gap-2">
                        <label class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-gray-50/90 hover:bg-gray-100 border border-gray-200 text-xs font-semibold text-gray-700 cursor-pointer select-none transition flex-1">
                            <input type="checkbox" id="filter-in-stock" class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500">
                            <span class="whitespace-nowrap">📦 Chỉ hàng có sẵn</span>
                        </label>

                        <button type="button" id="btn-reset-filters-bar"
                                class="hidden text-xs font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-2.5 rounded-xl border border-rose-200 transition cursor-pointer whitespace-nowrap">
                            🔄 Đặt lại bộ lọc
                        </button>
                    </div>
                </div>
            </div>

            <!-- Count indicator -->
            <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
                <span id="user-count-text">Hiển thị <strong class="text-gray-800"
                        id="visible-count">{{ $pesticides->count() }}</strong> sản phẩm</span>
                <span class="text-gray-400">💡 Nhấp vào từng loại thuốc để xem công dụng & liều lượng chi tiết</span>
            </div>
        </div>

        <!-- Empty State -->
        <div id="user-empty-state"
            class="hidden bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-xs my-6">
            <div class="text-5xl mb-3">🔍</div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Không tìm thấy sản phẩm phù hợp</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto mb-4">
                Vui lòng thử tìm kiếm bằng từ khóa khác (ví dụ: tên hoạt chất, tên bệnh, hoặc đổi danh mục).
            </p>
            <button type="button" id="btn-reset-filters"
                class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2 rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                🔄 Xóa bộ lọc & Xem lại tất cả
            </button>
        </div>

        <!-- 1. GRID CARDS VIEW (4 cột / hàng trên Desktop, gọn gàng, chuẩn E-commerce) -->
        <div id="user-view-cards" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($pesticides as $pesticide)
                @php
                    $vars = $pesticide->productVariants;
                    $firstVariant = $vars->first();
                    $minP = $vars->isNotEmpty() ? $vars->min('effective_price') : 0;
                    $maxP = $vars->isNotEmpty() ? $vars->max('effective_price') : 0;
                    $availStock = $vars->isNotEmpty() ? $vars->flatMap->inventories->sum('quantity_available') : 0;
                @endphp
                <div class="product-item group bg-white border border-gray-200 hover:border-emerald-500 rounded-2xl shadow-2xs hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden"
                    data-id="{{ $pesticide->id }}" data-name="{{ mb_strtolower($pesticide->name) }}"
                    data-category-id="{{ $pesticide->category_id }}"
                    data-category-name="{{ mb_strtolower($pesticide->category->name ?? '') }}"
                    data-purposes="{{ implode(' ', $pesticide->purposes) }}"
                    data-ingredient="{{ mb_strtolower($pesticide->active_ingredient ?? '') }}"
                    data-water="{{ mb_strtolower($pesticide->water_volume ?? '') }}"
                    data-usage="{{ mb_strtolower($pesticide->usage ?? '') }}"
                    data-target="{{ mb_strtolower($pesticide->target ?? '') }}"
                    data-crops="{{ mb_strtolower($pesticide->crops ?? '') }}"
                    data-manufacturer="{{ mb_strtolower($pesticide->manufacturer ?? '') }}"
                    data-notes="{{ mb_strtolower($pesticide->notes ?? '') }}"
                    data-form-type="{{ mb_strtolower($pesticide->form_type ?? '') }}"
                    data-concentration="{{ mb_strtolower($pesticide->concentration ?? '') }}"
                    data-diseases="{{ mb_strtolower($pesticide->diseases->pluck('name')->implode(' ')) }}"
                    data-min-price="{{ (int)$minP }}"
                    data-in-stock="{{ $availStock > 0 ? '1' : '0' }}">

                    <!-- Card Image Area (Height ~155px) -->
                    <div class="relative bg-gradient-to-b from-gray-50 to-white p-2.5 flex items-center justify-center border-b border-gray-100 overflow-hidden"
                        style="height: 155px; min-height: 155px; max-height: 155px;">
                        @if($pesticide->image_url)
                            <img id="card-img-{{ $pesticide->id }}" src="{{ $pesticide->image_url }}"
                                alt="{{ $pesticide->name }}"
                                class="group-hover:scale-105 transition-all duration-300 drop-shadow-xs cursor-pointer"
                                style="max-height: 145px; max-width: 100%; object-fit: contain; width: auto; height: auto;"
                                onclick="moModalAnh(this.src, '{{ addslashes($pesticide->name) }}')"
                                title="Nhấp để xem ảnh lớn">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                                💊
                            </div>
                        @endif

                        <!-- Category badge on image -->
                        <div class="absolute top-1.5 left-1.5 flex flex-wrap gap-1 items-center max-w-[85%] z-10 pointer-events-none">
                            @if($pesticide->category)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-white/95 backdrop-blur-xs rounded-full shadow-xs border border-emerald-100">
                                    {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
                                </span>
                            @endif
                        </div>

                        @if($pesticide->image_url)
                            <button type="button"
                                onclick="moModalAnh(document.getElementById('card-img-{{ $pesticide->id }}')?.src || '{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                                class="absolute bottom-1.5 right-1.5 bg-white/90 hover:bg-white text-gray-600 hover:text-emerald-700 p-1 rounded-md text-[11px] shadow-xs transition-transform duration-150 cursor-pointer hover:scale-110"
                                title="Phóng to ảnh">
                                🔍
                            </button>
                        @endif
                    </div>

                    <!-- Card Body (Không còn khối công dụng & đặc tính dài dòng) -->
                    <div class="p-3 sm:p-3.5 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Title -->
                            <div class="mb-1.5">
                                <a href="{{ route('thuoc.xem', $pesticide) }}"
                                    class="font-bold text-gray-900 text-sm sm:text-[15px] leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2"
                                    title="{{ $pesticide->name }}">
                                    {{ $pesticide->name }}
                                </a>

                                <!-- Specifications (Dạng thuốc, Nồng độ, Lượng nước) -->
                                <div class="mt-1.5 flex flex-wrap gap-1 items-center">
                                    @if($pesticide->form_type)
                                        <span class="text-[10px] font-semibold text-gray-700 bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200">
                                            {{ strtoupper($pesticide->form_type) }}
                                        </span>
                                    @endif
                                    @if($pesticide->concentration)
                                        <span class="text-[10px] font-mono font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/70">
                                            {{ $pesticide->concentration }}
                                        </span>
                                    @endif
                                    @if($pesticide->water_volume)
                                        <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded border border-blue-200/80 inline-flex items-center gap-0.5">
                                            <span>💧</span> <span>{{ $pesticide->water_volume }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Active Ingredient (Gọn 1 dòng) -->
                            @if($pesticide->active_ingredient)
                                <div class="text-[11px] text-gray-600 my-1.5 line-clamp-1" title="{{ $pesticide->active_ingredient }}">
                                    <span class="text-emerald-600 font-semibold">⚗️</span> {{ $pesticide->active_ingredient }}
                                </div>
                            @endif

                            <!-- Bệnh liên kết trong phác đồ kỹ sư -->
                            @if($pesticide->diseases && $pesticide->diseases->isNotEmpty())
                                <div class="flex flex-wrap gap-1 my-1">
                                    @foreach($pesticide->diseases->take(2) as $dis)
                                        <span class="inline-flex items-center gap-1 text-[9.5px] font-bold px-1.5 py-0.5 rounded-md bg-teal-50 text-teal-800 border border-teal-200/70" title="Chỉ định điều trị: {{ $dis->name }}">
                                            <span>🎯</span> <span class="truncate max-w-[120px]">{{ $dis->name }}</span>
                                        </span>
                                    @endforeach
                                    @if($pesticide->diseases->count() > 2)
                                        <span class="text-[9px] font-bold text-teal-600 self-center">+{{ $pesticide->diseases->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Price, Stock & Actions -->
                        <div class="mt-2.5 pt-2 border-t border-slate-100 flex flex-col gap-2">
                            <div class="flex items-baseline justify-between gap-1">
                                <div>
                                    @if($minP > 0)
                                        <div class="text-sm sm:text-base font-black text-emerald-600 tracking-tight">
                                            {{ number_format($minP, 0, ',', '.') }} ₫
                                        </div>
                                    @else
                                        <div class="text-xs font-bold text-slate-500">Liên hệ báo giá</div>
                                    @endif
                                    <div class="text-[10px] text-slate-400 truncate">
                                        {{ $firstVariant?->specification ?? ($pesticide->concentration ?: 'Quy cách chuẩn') }}
                                    </div>
                                </div>
                                <div>
                                    @if($availStock > 0)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            ✓ Còn hàng
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                            Tạm hết
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 pt-0.5">
                                @if($firstVariant && $availStock > 0)
                                    <button type="button"
                                            onclick="quickAddToCart({{ $firstVariant->id }}, '{{ addslashes($pesticide->name) }}')"
                                            class="py-1.5 px-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs transition border border-emerald-300 flex items-center justify-center gap-1 shadow-2xs cursor-pointer">
                                        <span>🛒</span>
                                    </button>
                                @endif
                                <a href="{{ route('thuoc.xem', $pesticide) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white py-1.5 px-2.5 rounded-xl text-xs font-bold shadow-2xs transition-all text-center">
                                    <span>Chi tiết</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 2. CLEAN TABLE VIEW (Alternative clean view for users) -->
        <div id="user-view-table" class="hidden bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/80 border-b border-gray-200">
                        <tr>
                            <th
                                class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[340px]">
                                Tên thuốc</th>
                            <th
                                class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell whitespace-nowrap">
                                Danh mục</th>
                            <th
                                class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Hoạt chất</th>
                            <th
                                class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Công dụng phòng trị</th>
                            <th
                                class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body" class="divide-y divide-gray-100">
                        @foreach($pesticides as $pesticide)
                            @php
                                $vars = $pesticide->productVariants;
                                $minP = $vars->isNotEmpty() ? $vars->min('effective_price') : 0;
                                $availStock = $vars->isNotEmpty() ? $vars->flatMap->inventories->sum('quantity_available') : 0;
                            @endphp
                            <tr class="product-row hover:bg-emerald-50/30 transition-colors" data-id="{{ $pesticide->id }}"
                                data-name="{{ mb_strtolower($pesticide->name) }}"
                                data-category-id="{{ $pesticide->category_id }}"
                                data-category-name="{{ mb_strtolower($pesticide->category->name ?? '') }}"
                                data-purposes="{{ implode(' ', $pesticide->purposes) }}"
                                data-ingredient="{{ mb_strtolower($pesticide->active_ingredient ?? '') }}"
                                data-water="{{ mb_strtolower($pesticide->water_volume ?? '') }}"
                                data-usage="{{ mb_strtolower($pesticide->usage ?? '') }}"
                                data-target="{{ mb_strtolower($pesticide->target ?? '') }}"
                                data-crops="{{ mb_strtolower($pesticide->crops ?? '') }}"
                                data-manufacturer="{{ mb_strtolower($pesticide->manufacturer ?? '') }}"
                                data-notes="{{ mb_strtolower($pesticide->notes ?? '') }}"
                                data-form-type="{{ mb_strtolower($pesticide->form_type ?? '') }}"
                                data-concentration="{{ mb_strtolower($pesticide->concentration ?? '') }}"
                                data-diseases="{{ mb_strtolower($pesticide->diseases->pluck('name')->implode(' ')) }}"
                                data-min-price="{{ (int)$minP }}"
                                data-in-stock="{{ $availStock > 0 ? '1' : '0' }}">

                                <!-- Tên, ảnh & Lượng nước pha -->
                                <td class="px-5 py-3.5 min-w-[340px]">
                                    <div class="flex items-center gap-3.5">
                                        @if($pesticide->image_url)
                                            <div class="relative w-16 h-16 rounded-xl overflow-hidden border border-gray-200 shrink-0 cursor-pointer shadow-2xs hover:ring-2 hover:ring-emerald-500 transition-all bg-white p-0.5"
                                                onclick="moModalAnh('{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                                                title="Xem ảnh lớn">
                                                <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}"
                                                    class="w-full h-full object-contain hover:scale-105 transition-transform">
                                            </div>
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-xl">
                                                💊
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <a href="{{ route('thuoc.xem', $pesticide) }}"
                                                class="font-bold text-gray-900 hover:text-emerald-700 transition-colors block text-sm">
                                                {{ $pesticide->name }}
                                            </a>
                                            <div class="flex flex-wrap gap-1.5 items-center mt-1">
                                                @if($pesticide->concentration)
                                                    <span
                                                        class="text-xs font-mono text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60 inline-block">
                                                        {{ $pesticide->concentration }}
                                                    </span>
                                                @endif
                                                @if($pesticide->water_volume)
                                                    <span
                                                        class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/80 inline-flex items-center gap-1"
                                                        title="Lượng nước pha khuyến cáo">
                                                        💧 Pha: {{ $pesticide->water_volume }}
                                                    </span>
                                                @endif
                                                @if($pesticide->stains_fruit)
                                                    <span
                                                        class="text-xs font-bold text-amber-900 bg-amber-100 px-2 py-0.5 rounded border border-amber-300 inline-flex items-center gap-1"
                                                        title="Có thể dính màu trên vỏ trái">
                                                        🎨 Dính màu trái
                                                    </span>
                                                @endif
                                            </div>


                                            @if(!empty($pesticide->purposes))
                                                <div class="flex flex-wrap gap-1 mt-1.5">
                                                    @foreach($pesticide->purposes as $purpKey)
                                                        @if(isset(\App\Models\Pesticide::PURPOSES[$purpKey]))
                                                            @php $pMeta = \App\Models\Pesticide::PURPOSES[$purpKey]; @endphp
                                                            <span
                                                                class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold border {{ $pMeta['badge_class'] }}"
                                                                title="{{ $pMeta['description'] }}">
                                                                <span>{{ $pMeta['emoji'] }}</span>
                                                                <span>{{ $pMeta['short_label'] }}</span>
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Danh mục -->
                                <td class="px-4 py-3.5 hidden sm:table-cell whitespace-nowrap">
                                    @if($pesticide->category)
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-emerald-50 text-emerald-800 border border-emerald-200/60 px-2.5 py-1 rounded-full font-medium">
                                            {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
                                        </span>
                                    @endif
                                </td>


                                <!-- Hoạt chất -->
                                <td class="px-4 py-3.5 text-gray-700 text-xs hidden md:table-cell">
                                    {{ $pesticide->active_ingredient ?? '—' }}
                                </td>

                                <!-- Công dụng -->
                                <td class="px-4 py-3.5 text-gray-600 text-xs hidden lg:table-cell max-w-xs">
                                    <span class="line-clamp-2 leading-relaxed">{{ $pesticide->usage ?? '—' }}</span>
                                </td>

                                <!-- Nút xem chi tiết -->
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <a href="{{ route('thuoc.xem', $pesticide) }}"
                                        class="inline-flex items-center gap-1 text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3 py-1.5 rounded-lg shadow-2xs transition-colors">
                                        <span>Xem</span>
                                        <span>→</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- AJAX Pagination Bar (Phân trang mượt mà không reload trang) -->
        <div id="ajax-pagination-container" class="mt-8 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-gray-500 font-medium" id="pagination-info-text">
                Hiển thị <span class="font-bold text-gray-800" id="page-start-count">1</span> - <span class="font-bold text-gray-800" id="page-end-count">16</span> trên tổng số <span class="font-bold text-gray-800" id="page-total-count">0</span> sản phẩm
            </div>
            <div class="flex items-center gap-1.5 flex-wrap justify-center" id="pagination-buttons">
                <!-- Nút phân trang AJAX tự render -->
            </div>
        </div>

    </div>

    <!-- Client-side Fast Filter, History API & Scroll Restoration Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 0. Disable automatic browser scroll restoration to control it precisely
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            const searchInput = document.getElementById('user-search-input');
            const clearBtn = document.getElementById('user-search-clear');
            const classificationSelect = document.getElementById('filter-classification');
            const cardsContainer = document.getElementById('user-view-cards');
            const tableContainer = document.getElementById('user-view-table');
            const tableBody = document.getElementById('user-table-body');
            const btnGrid = document.getElementById('btn-view-grid');
            const btnTable = document.getElementById('btn-view-table');
            const emptyState = document.getElementById('user-empty-state');
            const visibleCountEl = document.getElementById('visible-count');
            const resetFiltersBtn = document.getElementById('btn-reset-filters');

            // AJAX Pagination elements & state
            const paginationContainer = document.getElementById('ajax-pagination-container');
            const paginationButtons = document.getElementById('pagination-buttons');
            const pageStartCount = document.getElementById('page-start-count');
            const pageEndCount = document.getElementById('page-end-count');
            const pageTotalCount = document.getElementById('page-total-count');
            const pageSize = 16;
            let currentPage = 1;
            let currentMatchedCards = [];
            let currentMatchedRows = [];

            const cardItems = Array.from(document.querySelectorAll('.product-item'));
            const rowItems = Array.from(document.querySelectorAll('.product-row'));

            // Vietnamese accent removal helper
            const removeVietnameseTones = (str) => {
                if (!str) return '';
                str = str.toLowerCase();
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a');
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e');
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i');
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o');
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u');
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y');
                str = str.replace(/đ/g, 'd');
                return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            };

            // Pre-calculate search index for high performance & multi-word match
            const buildSearchIndex = (items) => {
                return items.map((el, idx) => {
                    const d = el.dataset;
                    const name = d.name || '';
                    const ing = d.ingredient || '';
                    const target = d.target || '';
                    const usage = d.usage || '';
                    const water = d.water || '';
                    const crops = d.crops || '';
                    const catName = d.categoryName || '';
                    const mfg = d.manufacturer || '';
                    const catId = d.categoryId || '';
                    const purposes = (d.purposes || '').split(/\s+/).filter(Boolean);
                    const notes = d.notes || '';
                    const form = (d.formType || '').toLowerCase();
                    const conc = d.concentration || '';
                    const diseases = d.diseases || '';
                    const inStock = d.inStock === '1';
                    const price = parseInt(d.minPrice || '0', 10);

                    const rawFull = [name, ing, target, usage, water, crops, catName, mfg, notes, form, conc, diseases].join(' ').toLowerCase();
                    const cleanFull = removeVietnameseTones(rawFull);

                    return {
                        el,
                        catId,
                        purposes,
                        form,
                        inStock,
                        price,
                        originalIndex: idx,
                        nameRaw: name,
                        nameClean: removeVietnameseTones(name),
                        targetRaw: target,
                        targetClean: removeVietnameseTones(target),
                        diseasesRaw: diseases,
                        diseasesClean: removeVietnameseTones(diseases),
                        ingRaw: ing,
                        ingClean: removeVietnameseTones(ing),
                        usageRaw: usage,
                        usageClean: removeVietnameseTones(usage),
                        cropsRaw: crops,
                        cropsClean: removeVietnameseTones(crops),
                        rawFull,
                        cleanFull
                    };
                });
            };

            const cardIndexed = buildSearchIndex(cardItems);
            const rowIndexed = buildSearchIndex(rowItems);

            // Score an item against query
            const evaluateItem = (item, qRaw, qClean, qWordsRaw, qWordsClean) => {
                let score = 0;

                // 1. Exact phrase matches (highest priority)
                if (item.nameRaw.includes(qRaw)) score += 500;
                else if (item.nameClean.includes(qClean)) score += 300;

                if (item.targetRaw.includes(qRaw)) score += 250;
                else if (item.targetClean.includes(qClean)) score += 180;

                if (item.diseasesRaw && item.diseasesRaw.includes(qRaw)) score += 260;
                else if (item.diseasesClean && item.diseasesClean.includes(qClean)) score += 190;

                if (item.ingRaw.includes(qRaw) || item.ingClean.includes(qClean)) score += 150;
                if (item.usageRaw.includes(qRaw) || item.usageClean.includes(qClean)) score += 120;
                if (item.cropsRaw.includes(qRaw) || item.cropsClean.includes(qClean)) score += 100;

                // 2. Token / word matching
                let matchedCount = 0;
                let allWordsInClean = true;
                let allWordsInRaw = true;

                for (let i = 0; i < qWordsClean.length; i++) {
                    const wClean = qWordsClean[i];
                    const wRaw = qWordsRaw[i];
                    if (!wClean) continue;

                    if (item.cleanFull.includes(wClean)) {
                        matchedCount++;
                        if (item.nameClean.includes(wClean)) score += 50;
                        if (item.targetClean.includes(wClean)) score += 40;
                        if (item.diseasesClean && item.diseasesClean.includes(wClean)) score += 45;
                        if (item.ingClean.includes(wClean)) score += 25;
                        if (item.usageClean.includes(wClean)) score += 20;
                        if (item.cropsClean.includes(wClean)) score += 15;
                    } else {
                        allWordsInClean = false;
                    }

                    if (!item.rawFull.includes(wRaw)) {
                        allWordsInRaw = false;
                    }
                }

                // Multi-word bonus
                if (qWordsClean.length > 1 && allWordsInClean) {
                    score += 200;
                    if (allWordsInRaw) score += 60;
                }

                const isMatch = (
                    item.rawFull.includes(qRaw) ||
                    item.cleanFull.includes(qClean) ||
                    (qWordsClean.length > 1 && allWordsInClean) ||
                    (qWordsClean.length >= 3 && matchedCount >= Math.ceil(qWordsClean.length * 0.67))
                );

                return { isMatch, score };
            };

            // Server-injected values
            const serverCatId = "{{ $selectedCategoryId ?? request('category_id') ?? '' }}";
            const serverCatSlug = "{{ $selectedCategorySlug ?? request('category') ?? '' }}";
            const serverPurpose = "{{ $selectedPurpose ?? request('muc_dich') ?? request('purpose') ?? '' }}".trim();
            const serverQuery = "{{ request('q') ?? '' }}".trim().toLowerCase();

            let currentCategoryId = serverCatId;
            let currentCategorySlug = serverCatSlug;
            let currentPurpose = serverPurpose;
            let currentKeyword = serverQuery;
            let currentFormType = '';
            let currentPriceRange = '';
            let currentInStock = false;
            let currentView = localStorage.getItem('bvtv_user_view_mode') || 'grid';

            const formSelect = document.getElementById('filter-form-type');
            const priceSelect = document.getElementById('filter-price-range');
            const inStockCheckbox = document.getElementById('filter-in-stock');
            const resetBarBtn = document.getElementById('btn-reset-filters-bar');
            const activeTagsSummary = document.getElementById('active-filter-tags-summary');
            const activeTagsList = document.getElementById('active-filter-chips-list');

            // Helper to build URL query with page support
            const buildUrl = (slug, q, purpose, page = 1) => {
                const params = new URLSearchParams();
                if (slug) params.set('category', slug);
                if (purpose) params.set('muc_dich', purpose);
                if (q) params.set('q', q);
                if (page && page > 1) params.set('page', page);
                const qStr = params.toString();
                return window.location.pathname + (qStr ? '?' + qStr : '');
            };

            // Helper to update active select dropdown values
            const updateActiveChipUi = () => {
                if (classificationSelect) {
                    if (currentCategoryId) {
                        classificationSelect.value = 'cat:' + currentCategoryId;
                    } else if (currentCategorySlug) {
                        const opt = Array.from(classificationSelect.options).find(o => o.getAttribute('data-slug') === currentCategorySlug);
                        if (opt) {
                            classificationSelect.value = opt.value;
                            currentCategoryId = opt.getAttribute('data-id') || '';
                        }
                    } else if (currentPurpose) {
                        classificationSelect.value = 'purp:' + currentPurpose;
                    } else {
                        classificationSelect.value = '';
                    }
                }

                if (formSelect) formSelect.value = currentFormType || '';
                if (priceSelect) priceSelect.value = currentPriceRange || '';
                if (inStockCheckbox) inStockCheckbox.checked = !!currentInStock;

                const hasFilters = !!(currentCategoryId || currentCategorySlug || currentPurpose || currentFormType || currentPriceRange || currentInStock || currentKeyword);
                if (resetBarBtn) resetBarBtn.classList.toggle('hidden', !hasFilters);
            };

            const updateActiveTagsUi = () => {
                // Tối giản: Giá trị lọc đã hiển thị trực quan ngay trên từng dropdown, chỉ bật/tắt nút Đặt lại khi có bộ lọc
                const hasFilters = !!(currentCategoryId || currentCategorySlug || currentPurpose || currentFormType || currentPriceRange || currentInStock || currentKeyword);
                if (resetBarBtn) resetBarBtn.classList.toggle('hidden', !hasFilters);
            };

            // Helper to check category, purpose, form type, stock, and price match
            const matchesFilter = (item, catId, purpose, formType, onlyStock, priceRange) => {
                if (catId && item.catId !== catId) return false;
                if (purpose && !item.purposes.includes(purpose)) return false;
                if (formType && !item.form.includes(formType)) return false;
                if (onlyStock && !item.inStock) return false;
                if (priceRange) {
                    if (priceRange === 'under_100k' && (item.price <= 0 || item.price > 100000)) return false;
                    if (priceRange === '100k_300k' && (item.price < 100000 || item.price > 300000)) return false;
                    if (priceRange === 'above_300k' && item.price < 300000) return false;
                }
                return true;
            };

            // AJAX Pagination Render function
            const renderPagination = () => {
                const totalItems = currentMatchedCards.length;
                const totalPages = Math.max(1, Math.ceil(totalItems / pageSize));

                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, totalItems);

                if (pageStartCount) pageStartCount.textContent = totalItems > 0 ? (startIndex + 1) : 0;
                if (pageEndCount) pageEndCount.textContent = endIndex;
                if (pageTotalCount) pageTotalCount.textContent = totalItems;

                // Slice visibility for active page
                currentMatchedCards.forEach((item, index) => {
                    const isVisible = (index >= startIndex && index < endIndex);
                    item.el.classList.toggle('hidden', !isVisible);
                });

                currentMatchedRows.forEach((item, index) => {
                    const isVisible = (index >= startIndex && index < endIndex);
                    item.el.classList.toggle('hidden', !isVisible);
                });

                if (!paginationContainer || !paginationButtons) return;

                if (totalItems === 0 || totalPages <= 1) {
                    paginationContainer.classList.add('hidden');
                    paginationButtons.innerHTML = '';
                    return;
                }

                paginationContainer.classList.remove('hidden');

                let html = '';

                // Prev button
                const isFirst = currentPage === 1;
                html += `
                    <button type="button" data-page="${currentPage - 1}" ${isFirst ? 'disabled' : ''}
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-all border ${isFirst ? 'opacity-40 cursor-not-allowed bg-gray-50 text-gray-400 border-gray-200' : 'bg-white text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border-gray-200 shadow-2xs cursor-pointer'}">
                        « Trước
                    </button>
                `;

                // Calculate pages to show
                const pageNumbers = [];
                if (totalPages <= 7) {
                    for (let i = 1; i <= totalPages; i++) pageNumbers.push(i);
                } else {
                    pageNumbers.push(1);
                    if (currentPage > 3) pageNumbers.push('...');

                    const start = Math.max(2, currentPage - 1);
                    const end = Math.min(totalPages - 1, currentPage + 1);
                    for (let i = start; i <= end; i++) {
                        if (!pageNumbers.includes(i)) pageNumbers.push(i);
                    }

                    if (currentPage < totalPages - 2) pageNumbers.push('...');
                    if (!pageNumbers.includes(totalPages)) pageNumbers.push(totalPages);
                }

                // Render page numbers
                pageNumbers.forEach(p => {
                    if (p === '...') {
                        html += `<span class="px-2 py-1 text-xs text-gray-400 font-bold select-none">...</span>`;
                    } else {
                        const isActive = p === currentPage;
                        html += `
                            <button type="button" data-page="${p}"
                                class="w-8 h-8 rounded-xl text-xs font-bold transition-all border flex items-center justify-center cursor-pointer ${isActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-white text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border-gray-200 shadow-2xs'}">
                                ${p}
                            </button>
                        `;
                    }
                });

                // Next button
                const isLast = currentPage === totalPages;
                html += `
                    <button type="button" data-page="${currentPage + 1}" ${isLast ? 'disabled' : ''}
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-all border ${isLast ? 'opacity-40 cursor-not-allowed bg-gray-50 text-gray-400 border-gray-200' : 'bg-white text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border-gray-200 shadow-2xs cursor-pointer'}">
                        Sau »
                    </button>
                `;

                paginationButtons.innerHTML = html;
            };

            // Event listener for pagination button clicks
            paginationButtons?.addEventListener('click', (e) => {
                const btn = e.target.closest('button[data-page]');
                if (!btn || btn.disabled) return;
                const targetPage = parseInt(btn.getAttribute('data-page'), 10);
                if (targetPage && targetPage !== currentPage) {
                    currentPage = targetPage;
                    renderPagination();
                    saveCurrentState(false);
                    // Smooth scroll up to product list
                    const targetEl = document.getElementById('user-view-cards') || cardsContainer;
                    if (targetEl) {
                        const y = targetEl.getBoundingClientRect().top + window.pageYOffset - 120;
                        window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
                    }
                }
            });

            // 1. View mode toggle (Grid vs Table)
            const applyViewMode = (mode, shouldSaveState = true) => {
                currentView = mode;
                if (mode === 'table') {
                    cardsContainer?.classList.add('hidden');
                    tableContainer?.classList.remove('hidden');
                    if (btnTable) btnTable.className = 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-emerald-700 shadow-xs cursor-pointer';
                    if (btnGrid) btnGrid.className = 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-gray-900 transition-all cursor-pointer';
                } else {
                    tableContainer?.classList.add('hidden');
                    cardsContainer?.classList.remove('hidden');
                    if (btnGrid) btnGrid.className = 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-emerald-700 shadow-xs cursor-pointer';
                    if (btnTable) btnTable.className = 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-gray-900 transition-all cursor-pointer';
                }
                localStorage.setItem('bvtv_user_view_mode', mode);
                filterProducts(false);
                if (shouldSaveState) {
                    saveCurrentState(false);
                }
            };

            btnGrid?.addEventListener('click', () => applyViewMode('grid'));
            btnTable?.addEventListener('click', () => applyViewMode('table'));

            // 2. Client-side instant filtering & relevance sorting with pagination
            const filterProducts = (resetPage = true) => {
                if (resetPage) {
                    currentPage = 1;
                }
                const q = currentKeyword.trim();
                const catId = currentCategoryId;
                const purpose = currentPurpose;
                const formType = currentFormType;
                const onlyStock = currentInStock;
                const priceRange = currentPriceRange;

                currentMatchedCards = [];
                currentMatchedRows = [];

                if (q) {
                    const qRaw = q.toLowerCase();
                    const qClean = removeVietnameseTones(qRaw);
                    const qWordsRaw = qRaw.split(/[\s,./\-_–—+:]+/).filter(Boolean);
                    const qWordsClean = qClean.split(/[\s,./\-_–—+:]+/).filter(Boolean);

                    // Process Cards
                    const cardMatches = [];
                    cardIndexed.forEach(item => {
                        if (!matchesFilter(item, catId, purpose, formType, onlyStock, priceRange)) {
                            item.el.classList.add('hidden');
                            return;
                        }
                        const { isMatch, score } = evaluateItem(item, qRaw, qClean, qWordsRaw, qWordsClean);
                        if (isMatch) {
                            cardMatches.push({ item, score });
                        } else {
                            item.el.classList.add('hidden');
                        }
                    });

                    // Sort matched cards by score descending, stable tie-breaker
                    cardMatches.sort((a, b) => b.score - a.score || a.item.originalIndex - b.item.originalIndex);
                    cardMatches.forEach(({ item }) => {
                        cardsContainer?.appendChild(item.el);
                        currentMatchedCards.push(item);
                    });

                    // Process Rows
                    const rowMatches = [];
                    rowIndexed.forEach(item => {
                        if (!matchesFilter(item, catId, purpose, formType, onlyStock, priceRange)) {
                            item.el.classList.add('hidden');
                            return;
                        }
                        const { isMatch, score } = evaluateItem(item, qRaw, qClean, qWordsRaw, qWordsClean);
                        if (isMatch) {
                            rowMatches.push({ item, score });
                        } else {
                            item.el.classList.add('hidden');
                        }
                    });

                    // Sort matched rows
                    rowMatches.sort((a, b) => b.score - a.score || a.item.originalIndex - b.item.originalIndex);
                    rowMatches.forEach(({ item }) => {
                        tableBody?.appendChild(item.el);
                        currentMatchedRows.push(item);
                    });

                } else {
                    // Category & Purpose & Advanced filter without search query - restore original order
                    cardIndexed.sort((a, b) => a.originalIndex - b.originalIndex);
                    cardIndexed.forEach(item => {
                        const isMatch = matchesFilter(item, catId, purpose, formType, onlyStock, priceRange);
                        if (isMatch) {
                            currentMatchedCards.push(item);
                        } else {
                            item.el.classList.add('hidden');
                        }
                        cardsContainer?.appendChild(item.el);
                    });

                    rowIndexed.sort((a, b) => a.originalIndex - b.originalIndex);
                    rowIndexed.forEach(item => {
                        const isMatch = matchesFilter(item, catId, purpose, formType, onlyStock, priceRange);
                        if (isMatch) {
                            currentMatchedRows.push(item);
                        } else {
                            item.el.classList.add('hidden');
                        }
                        tableBody?.appendChild(item.el);
                    });
                }

                const visibleCount = currentMatchedCards.length;
                if (visibleCountEl) {
                    visibleCountEl.textContent = visibleCount;
                }

                updateActiveTagsUi();

                const isEmpty = visibleCount === 0;
                if (emptyState) emptyState.classList.toggle('hidden', !isEmpty);
                if (cardsContainer) cardsContainer.classList.toggle('hidden', isEmpty || currentView !== 'grid');
                if (tableContainer) tableContainer.classList.toggle('hidden', isEmpty || currentView !== 'table');

                if (clearBtn) {
                    clearBtn.classList.toggle('hidden', !q);
                }

                renderPagination();
            };

            // 3. State storage & synchronization
            const saveCurrentState = (isPush = false, customScrollY = null) => {
                const scrollY = customScrollY !== null ? customScrollY : window.scrollY;
                const stateObj = {
                    categoryId: currentCategoryId,
                    categorySlug: currentCategorySlug,
                    purpose: currentPurpose,
                    q: currentKeyword,
                    view: currentView,
                    page: currentPage,
                    scrollY: scrollY
                };

                const targetUrl = buildUrl(currentCategorySlug, currentKeyword, currentPurpose, currentPage);

                try {
                    sessionStorage.setItem('bvtv_tra_cuu_state', JSON.stringify(stateObj));
                    sessionStorage.setItem('bvtv_tra_cuu_url', targetUrl);
                    sessionStorage.setItem('bvtv_tra_cuu_scroll', String(scrollY));
                } catch (e) { }

                if (isPush) {
                    history.pushState(stateObj, '', targetUrl);
                } else {
                    history.replaceState(stateObj, '', targetUrl);
                }
            };

            // 4. Scroll restoration helper
            const restoreScroll = (y) => {
                if (typeof y !== 'number' || y <= 0) return;
                const doScroll = () => {
                    window.scrollTo({ top: y, behavior: 'instant' });
                };
                doScroll();
                requestAnimationFrame(() => {
                    doScroll();
                    requestAnimationFrame(doScroll);
                });
                [20, 60, 120, 250, 450, 750].forEach(delay => {
                    setTimeout(doScroll, delay);
                });
            };

            // 5. Apply state object to page
            const applyState = (state, shouldRestoreScroll = true) => {
                if (!state) return;

                if (state.categorySlug !== undefined || state.categoryId !== undefined) {
                    currentCategorySlug = state.categorySlug || '';
                    currentCategoryId = state.categoryId || '';

                    // Resolve ID/slug if one is missing
                    if (currentCategorySlug && !currentCategoryId && classificationSelect) {
                        const matchedOpt = Array.from(classificationSelect.options).find(o => o.getAttribute('data-slug') === currentCategorySlug);
                        if (matchedOpt) currentCategoryId = matchedOpt.getAttribute('data-id') || '';
                    } else if (currentCategoryId && !currentCategorySlug && classificationSelect) {
                        const matchedOpt = Array.from(classificationSelect.options).find(o => o.getAttribute('data-id') === currentCategoryId);
                        if (matchedOpt) currentCategorySlug = matchedOpt.getAttribute('data-slug') || '';
                    }
                }

                if (state.purpose !== undefined) {
                    currentPurpose = state.purpose || '';
                }

                updateActiveChipUi();

                if (state.q !== undefined) {
                    currentKeyword = state.q.trim().toLowerCase();
                    if (searchInput) searchInput.value = state.q;
                }

                if (state.page !== undefined) {
                    currentPage = parseInt(state.page, 10) || 1;
                } else {
                    currentPage = 1;
                }

                if (state.view && state.view !== currentView) {
                    applyViewMode(state.view, false);
                } else {
                    filterProducts(false);
                }

                if (shouldRestoreScroll && state.scrollY) {
                    restoreScroll(state.scrollY);
                }
            };

            // 6. Classification select change handler (Gộp Danh mục & Mục đích thành 1, tránh xung đột)
            classificationSelect?.addEventListener('change', (e) => {
                const val = e.target.value;
                const opt = e.target.options[e.target.selectedIndex];

                if (val.startsWith('cat:')) {
                    currentCategoryId = opt ? (opt.getAttribute('data-id') || '') : '';
                    currentCategorySlug = opt ? (opt.getAttribute('data-slug') || '') : '';
                    currentPurpose = '';
                } else if (val.startsWith('purp:')) {
                    currentCategoryId = '';
                    currentCategorySlug = '';
                    currentPurpose = opt ? (opt.getAttribute('data-purpose') || '') : '';
                } else {
                    currentCategoryId = '';
                    currentCategorySlug = '';
                    currentPurpose = '';
                }

                // Khi người dùng chọn phân loại, xóa từ khóa tìm kiếm nếu có
                if (currentKeyword) {
                    currentKeyword = '';
                    if (searchInput) searchInput.value = '';
                }

                updateActiveChipUi();
                filterProducts(true);
                saveCurrentState(false, 0);
            });

            // 7. Search input typing (Debounced replaceState)
            let searchDebounceTimer = null;
            searchInput?.addEventListener('input', (e) => {
                currentKeyword = e.target.value.trim().toLowerCase();

                // Khi tìm kiếm: tìm trên tất cả sản phẩm, reset danh mục/mục đích về Tất cả
                if (currentKeyword && (currentCategoryId || currentCategorySlug || currentPurpose)) {
                    currentCategoryId = '';
                    currentCategorySlug = '';
                    currentPurpose = '';
                    if (classificationSelect) classificationSelect.value = '';
                    updateActiveChipUi();
                }

                filterProducts(true);

                if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    saveCurrentState(false);
                }, 250);
            });

            // 8. Clear & Reset filter buttons
            clearBtn?.addEventListener('click', () => {
                searchInput.value = '';
                currentKeyword = '';
                searchInput.focus();
                filterProducts(true);
                saveCurrentState(false);
            });

            formSelect?.addEventListener('change', (e) => {
                currentFormType = e.target.value.toLowerCase();
                filterProducts(true);
            });

            priceSelect?.addEventListener('change', (e) => {
                currentPriceRange = e.target.value;
                filterProducts(true);
            });

            inStockCheckbox?.addEventListener('change', (e) => {
                currentInStock = e.target.checked;
                filterProducts(true);
            });

            const resetAllFilters = () => {
                if (searchInput) searchInput.value = '';
                currentKeyword = '';
                currentCategoryId = '';
                currentCategorySlug = '';
                currentPurpose = '';
                currentFormType = '';
                currentPriceRange = '';
                currentInStock = false;

                if (classificationSelect) classificationSelect.value = '';
                if (formSelect) formSelect.value = '';
                if (priceSelect) priceSelect.value = '';
                if (inStockCheckbox) inStockCheckbox.checked = false;

                updateActiveChipUi();
                filterProducts(true);
                saveCurrentState(false, 0);
            };

            resetFiltersBtn?.addEventListener('click', resetAllFilters);
            resetBarBtn?.addEventListener('click', resetAllFilters);

            // 9. Debounced scroll listener to update scrollY in current state
            let scrollDebounceTimer = null;
            window.addEventListener('scroll', () => {
                if (scrollDebounceTimer) clearTimeout(scrollDebounceTimer);
                scrollDebounceTimer = setTimeout(() => {
                    saveCurrentState(false);
                }, 150);
            }, { passive: true });

            // 10. Record scroll position immediately when user clicks any product link or leaves
            document.addEventListener('click', (e) => {
                const productLink = e.target.closest('a[href*="/thuoc/"]');
                if (productLink && !productLink.target && !e.ctrlKey && !e.metaKey) {
                    saveCurrentState(false, window.scrollY);
                }
            });

            window.addEventListener('pagehide', () => {
                saveCurrentState(false, window.scrollY);
            });

            window.addEventListener('beforeunload', () => {
                saveCurrentState(false, window.scrollY);
            });

            // 11. Handle Browser Back/Forward (popstate event)
            window.addEventListener('popstate', (e) => {
                let state = e.state;
                if (!state) {
                    // Reconstruct state from current URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const slug = urlParams.get('category') || '';
                    const catId = urlParams.get('category_id') || '';
                    const purpose = urlParams.get('muc_dich') || urlParams.get('purpose') || '';
                    const q = urlParams.get('q') || '';
                    const p = parseInt(urlParams.get('page') || '1', 10);
                    state = {
                        categorySlug: slug,
                        categoryId: catId,
                        purpose: purpose,
                        q: q,
                        view: currentView,
                        page: p,
                        scrollY: 0
                    };
                }
                applyState(state, true);
            });

            // 12. Initial page load / restoration logic
            const initPage = () => {
                if ('scrollRestoration' in history) {
                    history.scrollRestoration = 'manual';
                }

                const urlParams = new URLSearchParams(window.location.search);
                const isReturning = sessionStorage.getItem('bvtv_is_returning') === '1' ||
                    (document.referrer && document.referrer.includes('/thuoc/') && !document.referrer.includes('/tra-cuu'));

                sessionStorage.removeItem('bvtv_is_returning');

                let initialState = null;

                // When returning from product details, always prioritize saved state
                if (isReturning) {
                    try {
                        initialState = JSON.parse(sessionStorage.getItem('bvtv_tra_cuu_state') || 'null');
                    } catch (e) { }
                }

                if (!initialState) {
                    initialState = history.state;
                }

                // If still no state, construct from URL params or server-injected values
                if (!initialState) {
                    const initialSlug = urlParams.get('category') || serverCatSlug || '';
                    const initialId = urlParams.get('category_id') || serverCatId || '';
                    const initialPurp = urlParams.get('muc_dich') || urlParams.get('purpose') || serverPurpose || '';
                    const initialQ = urlParams.get('q') !== null ? urlParams.get('q') : serverQuery;
                    const initialPage = parseInt(urlParams.get('page') || '1', 10);

                    initialState = {
                        categorySlug: initialSlug,
                        categoryId: initialId,
                        purpose: initialPurp,
                        q: initialQ,
                        view: currentView,
                        page: initialPage,
                        scrollY: 0
                    };
                }

                // Check if there is a direct scroll saved
                if (isReturning && (!initialState.scrollY || initialState.scrollY === 0)) {
                    const savedScroll = parseInt(sessionStorage.getItem('bvtv_tra_cuu_scroll') || '0', 10);
                    if (savedScroll > 0) {
                        initialState.scrollY = savedScroll;
                    }
                }

                // Apply view mode
                applyViewMode(initialState.view || currentView, false);

                // Apply state and restore scroll position
                applyState(initialState, true);

                // Save entry in history
                saveCurrentState(false, initialState.scrollY || 0);
            };

            initPage();

            // Also handle bfcache restore
            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    try {
                        const saved = JSON.parse(sessionStorage.getItem('bvtv_tra_cuu_state') || 'null') || history.state;
                        if (saved) {
                            applyState(saved, true);
                        }
                    } catch (e) { }
                }
            });
        });

    </script>
</x-layouts.app>