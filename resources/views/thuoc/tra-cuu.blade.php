<x-layouts.app title="Tra cứu thuốc BVTV">
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

            <!-- Quick Switch to Admin -->
            <div class="flex items-center gap-2 self-start md:self-auto shrink-0">
                <a href="{{ route('hoatchat.index') }}"
                    class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 px-3.5 py-2 rounded-xl text-xs font-semibold shadow-2xs transition-all">
                    <span>⚗️</span> Tra cứu theo Hoạt chất
                </a>
                <a href="{{ route('thuoc.quan-ly') }}"
                    class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 hover:border-gray-400 px-3.5 py-2 rounded-xl text-xs font-semibold shadow-2xs transition-all">
                    <span>⚙️</span> Trang Quản Trị (Admin)
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

            <!-- Category Filter Chips (Pills) -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1 scrollbar-thin" id="category-chips-bar">
                @php
                    $initialCatActive = empty($selectedCategoryId) && empty($selectedCategorySlug) && !request('category_id') && !request('category');
                @endphp
                <button type="button" data-category-id="" data-category-slug=""
                    class="category-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border {{ $initialCatActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70' }}">
                    Tất cả ({{ $totalPesticides }})
                </button>
                @foreach($categories as $cat)
                    @continue($cat->pesticides_count == 0)
                    @php
                        $isCatMatch = (($selectedCategoryId ?? request('category_id')) == $cat->id) || (($selectedCategorySlug ?? request('category')) == $cat->slug);
                    @endphp
                    <button type="button" data-category-id="{{ $cat->id }}" data-category-slug="{{ $cat->slug }}"
                        class="category-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border {{ $isCatMatch ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70' }}">
                        {{ $cat->emoji }} {{ $cat->name }} ({{ $cat->pesticides_count }})
                    </button>
                @endforeach
            </div>

            <!-- Purpose Filter Chips (Mục đích & Giai đoạn cây trồng) -->
            <div class="pt-2.5 pb-1 border-t border-gray-100" id="purpose-filter-section">
                <div class="flex items-center justify-between mb-1.5 px-0.5">
                    <span
                        class="text-[11px] font-bold text-gray-600 uppercase tracking-wider flex items-center gap-1.5">
                        <span>🎯</span> <span>Lọc theo mục đích:</span>
                    </span>
                    <span class="text-[11px] text-gray-400 hidden sm:inline">Phát triển rễ, cây, hoa, trái, nấm, rệp,
                        sâu...</span>
                </div>
                <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-1 scrollbar-thin"
                    id="purpose-chips-bar">
                    @php
                        $initialPurpActive = empty($selectedPurpose);
                    @endphp
                    <button type="button" data-purpose=""
                        class="purpose-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border {{ $initialPurpActive ? 'bg-emerald-700 text-white border-emerald-700 shadow-xs' : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70' }}">
                        Tất cả mục đích
                    </button>
                    @foreach(\App\Models\Pesticide::PURPOSES as $pKey => $pMeta)
                        @php
                            $isPurpMatch = ($selectedPurpose ?? '') === $pKey;
                            $count = $purposeCounts[$pKey] ?? 0;
                        @endphp
                        <button type="button" data-purpose="{{ $pKey }}" title="{{ $pMeta['description'] }}"
                            class="purpose-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border {{ $isPurpMatch ? 'bg-emerald-700 text-white border-emerald-700 shadow-xs' : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70' }}">
                            <span>{{ $pMeta['emoji'] }}</span>
                            <span>{{ $pMeta['label'] }}</span>
                            <span
                                class="purpose-count-badge ml-1 px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $isPurpMatch ? 'bg-white/25 text-white' : 'bg-gray-200/90 text-gray-600' }}">
                                {{ $count }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Count indicator -->
            <div class="flex items-center justify-between text-xs text-gray-500 pt-1 border-t border-gray-100">
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

        <!-- 1. GRID CARDS VIEW (Default: 3 columns per row, taller cards) -->
        <div id="user-view-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pesticides as $pesticide)
                <div class="product-item group bg-white border border-gray-200 hover:border-emerald-400 rounded-2xl shadow-2xs hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden"
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
                    data-concentration="{{ mb_strtolower($pesticide->concentration ?? '') }}">

                    <!-- Card Image Area (Slightly larger ~ 165px) -->
                    <div class="relative bg-gradient-to-b from-gray-50 to-white p-2.5 flex items-center justify-center border-b border-gray-100 overflow-hidden"
                        style="height: 165px; min-height: 165px; max-height: 165px;">
                        @if($pesticide->image_url)
                            <img id="card-img-{{ $pesticide->id }}" src="{{ $pesticide->image_url }}"
                                alt="{{ $pesticide->name }}"
                                class="group-hover:scale-105 transition-all duration-300 drop-shadow-xs cursor-pointer"
                                style="max-height: 155px; max-width: 100%; object-fit: contain; width: auto; height: auto;"
                                onclick="moModalAnh(this.src, '{{ addslashes($pesticide->name) }}')"
                                title="Nhấp để xem ảnh lớn">
                        @else
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                                💊
                            </div>
                        @endif

                        <!-- Badges on image (Category & Dính màu trái) -->
                        <div
                            class="absolute top-1.5 left-1.5 flex flex-wrap gap-1 items-center max-w-[85%] z-10 pointer-events-none">
                            @if($pesticide->category)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold text-emerald-800 bg-white/95 backdrop-blur-xs rounded-full shadow-xs border border-emerald-100">
                                    {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
                                </span>
                            @endif

                            @if($pesticide->stains_fruit)
                                <span
                                    class="inline-flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-bold text-amber-900 bg-amber-100/95 backdrop-blur-xs rounded-full shadow-xs border border-amber-300"
                                    title="Thuốc có thể để lại vệt màu/bám màu trên vỏ trái">
                                    🎨 Dính màu
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

                    <!-- Card Content (Optimized whitespace, more usage details) -->
                    <div class="p-4 sm:p-4.5 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Title, Concentration & Water Volume -->
                            <div class="mb-2">
                                <a href="{{ route('thuoc.xem', $pesticide) }}"
                                    class="font-bold text-gray-900 text-base sm:text-lg leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2"
                                    title="{{ $pesticide->name }}">
                                    {{ $pesticide->name }}
                                </a>
                                <div class="mt-1.5 flex flex-wrap gap-1.5 items-center">
                                    @if($pesticide->concentration)
                                        <span
                                            class="text-[11px] sm:text-xs font-mono font-medium text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200/70 inline-block">
                                            {{ $pesticide->concentration }}
                                        </span>
                                    @endif
                                    @if($pesticide->water_volume)
                                        <span
                                            class="text-[11px] sm:text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/80 inline-flex items-center gap-1 shadow-2xs"
                                            title="Lượng nước pha khuyến cáo">
                                            <span>💧 Pha:</span> <span>{{ $pesticide->water_volume }}</span>
                                        </span>
                                    @endif
                                </div>


                            </div>

                            <!-- Purpose Badges -->
                            @if(!empty($pesticide->purposes))
                                <div class="mt-2 mb-2 flex flex-wrap gap-1 items-center">
                                    @foreach($pesticide->purposes as $purpKey)
                                        @if(isset(\App\Models\Pesticide::PURPOSES[$purpKey]))
                                            @php $pMeta = \App\Models\Pesticide::PURPOSES[$purpKey]; @endphp
                                            <span
                                                class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded text-[10px] font-semibold border {{ $pMeta['badge_class'] }}"
                                                title="{{ $pMeta['description'] }}">
                                                <span>{{ $pMeta['emoji'] }}</span>
                                                <span>{{ $pMeta['short_label'] }}</span>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Active Ingredient -->
                            @if($pesticide->active_ingredient)
                                <div class="text-xs text-gray-700 mb-1.5 flex items-start gap-1.5">
                                    <span class="text-emerald-600 shrink-0 mt-0.5">⚗️</span>
                                    <span class="line-clamp-2 leading-relaxed font-normal">
                                        <strong class="font-semibold text-gray-900">Hoạt chất:</strong>
                                        {{ $pesticide->active_ingredient }}
                                    </span>
                                </div>
                            @endif

                            <!-- Target / Crop -->
                            @if($pesticide->target)
                                <div class="text-xs text-gray-700 mb-2 flex items-start gap-1.5">
                                    <span class="text-emerald-600 shrink-0 mt-0.5">🎯</span>
                                    <span class="line-clamp-2 leading-relaxed font-normal">
                                        <strong class="font-semibold text-gray-900">Đối tượng:</strong> {{ $pesticide->target }}
                                    </span>
                                </div>
                            @endif

                            <!-- Usage Preview (Expanded to 6 lines to show more details) -->
                            @if($pesticide->usage)
                                <div class="mt-1.5 bg-gray-50/90 rounded-xl p-2.5 sm:p-3 border border-gray-100">
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold text-gray-800 mb-1">
                                        <span class="text-emerald-600">💡</span>
                                        <span>Công dụng & đặc tính:</span>
                                    </div>
                                    <div class="text-xs sm:text-[13px] text-gray-600 line-clamp-6 leading-relaxed">
                                        {{ $pesticide->usage }}
                                    </div>
                                </div>
                            @endif
                        </div>


                            <a href="{{ route('thuoc.xem', $pesticide) }}"
                                class="w-full inline-flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-800 hover:text-white py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-2xs transition-all duration-200 group-hover:bg-emerald-600 group-hover:text-white">
                                <span>Xem chi tiết & liều dùng</span>
                                <span>→</span>
                            </a>
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
                                data-concentration="{{ mb_strtolower($pesticide->concentration ?? '') }}">

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
            const chips = document.querySelectorAll('.category-chip');
            const purposeChips = document.querySelectorAll('.purpose-chip');
            const cardsContainer = document.getElementById('user-view-cards');
            const tableContainer = document.getElementById('user-view-table');
            const tableBody = document.getElementById('user-table-body');
            const btnGrid = document.getElementById('btn-view-grid');
            const btnTable = document.getElementById('btn-view-table');
            const emptyState = document.getElementById('user-empty-state');
            const visibleCountEl = document.getElementById('visible-count');
            const resetFiltersBtn = document.getElementById('btn-reset-filters');

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
                    const form = d.formType || '';
                    const conc = d.concentration || '';

                    const rawFull = [name, ing, target, usage, water, crops, catName, mfg, notes, form, conc].join(' ').toLowerCase();
                    const cleanFull = removeVietnameseTones(rawFull);

                    return {
                        el,
                        catId,
                        purposes,
                        originalIndex: idx,
                        nameRaw: name,
                        nameClean: removeVietnameseTones(name),
                        targetRaw: target,
                        targetClean: removeVietnameseTones(target),
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
            let currentView = localStorage.getItem('bvtv_user_view_mode') || 'grid';

            // Helper to build URL query
            const buildUrl = (slug, q, purpose) => {
                const params = new URLSearchParams();
                if (slug) params.set('category', slug);
                if (purpose) params.set('muc_dich', purpose);
                if (q) params.set('q', q);
                const qStr = params.toString();
                return window.location.pathname + (qStr ? '?' + qStr : '');
            };

            // Helper to update active chip classes
            const updateActiveChipUi = () => {
                // 1. Category chips
                chips.forEach(chip => {
                    const isMatch = (currentCategorySlug && chip.dataset.categorySlug === currentCategorySlug) ||
                        (currentCategoryId && chip.dataset.categoryId === currentCategoryId) ||
                        (!currentCategorySlug && !currentCategoryId && !chip.dataset.categoryId && !chip.dataset.categorySlug);

                    chip.className = 'category-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border ' +
                        (isMatch
                            ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs'
                            : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70');
                });

                // 2. Purpose chips
                purposeChips.forEach(chip => {
                    const chipPurp = chip.dataset.purpose || '';
                    const isMatch = (currentPurpose === chipPurp);

                    chip.className = 'purpose-chip cursor-pointer px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all border ' +
                        (isMatch
                            ? 'bg-emerald-700 text-white border-emerald-700 shadow-xs'
                            : 'bg-gray-100/80 text-gray-700 border-gray-200 hover:bg-gray-200/70');

                    const badge = chip.querySelector('.purpose-count-badge');
                    if (badge) {
                        badge.className = 'purpose-count-badge ml-1 px-1.5 py-0.2 rounded-full text-[10px] font-bold ' +
                            (isMatch ? 'bg-white/25 text-white' : 'bg-gray-200/90 text-gray-600');
                    }
                });
            };

            // Helper to check category and purpose match
            const matchesFilter = (item, catId, purpose) => {
                if (catId && item.catId !== catId) return false;
                if (purpose && !item.purposes.includes(purpose)) return false;
                return true;
            };

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
                filterProducts();
                if (shouldSaveState) {
                    saveCurrentState(false);
                }
            };

            btnGrid?.addEventListener('click', () => applyViewMode('grid'));
            btnTable?.addEventListener('click', () => applyViewMode('table'));

            // 2. Client-side instant filtering & relevance sorting
            const filterProducts = () => {
                const q = currentKeyword.trim();
                const catId = currentCategoryId;
                const purpose = currentPurpose;

                let visibleCount = 0;

                if (q) {
                    const qRaw = q.toLowerCase();
                    const qClean = removeVietnameseTones(qRaw);
                    const qWordsRaw = qRaw.split(/\s+/).filter(Boolean);
                    const qWordsClean = qClean.split(/\s+/).filter(Boolean);

                    // Process Cards
                    const cardMatches = [];
                    cardIndexed.forEach(item => {
                        if (!matchesFilter(item, catId, purpose)) {
                            item.el.classList.add('hidden');
                            return;
                        }
                        const { isMatch, score } = evaluateItem(item, qRaw, qClean, qWordsRaw, qWordsClean);
                        item.el.classList.toggle('hidden', !isMatch);
                        if (isMatch) {
                            visibleCount++;
                            cardMatches.push({ item, score });
                        }
                    });

                    // Sort matched cards by score descending, stable tie-breaker
                    cardMatches.sort((a, b) => b.score - a.score || a.item.originalIndex - b.item.originalIndex);
                    cardMatches.forEach(({ item }) => {
                        cardsContainer?.appendChild(item.el);
                    });

                    // Process Rows
                    const rowMatches = [];
                    rowIndexed.forEach(item => {
                        if (!matchesFilter(item, catId, purpose)) {
                            item.el.classList.add('hidden');
                            return;
                        }
                        const { isMatch, score } = evaluateItem(item, qRaw, qClean, qWordsRaw, qWordsClean);
                        item.el.classList.toggle('hidden', !isMatch);
                        if (isMatch) {
                            rowMatches.push({ item, score });
                        }
                    });

                    // Sort matched rows
                    rowMatches.sort((a, b) => b.score - a.score || a.item.originalIndex - b.item.originalIndex);
                    rowMatches.forEach(({ item }) => {
                        tableBody?.appendChild(item.el);
                    });

                } else {
                    // Category & Purpose filter without search query - restore original order
                    cardIndexed.sort((a, b) => a.originalIndex - b.originalIndex);
                    cardIndexed.forEach(item => {
                        const isMatch = matchesFilter(item, catId, purpose);
                        item.el.classList.toggle('hidden', !isMatch);
                        if (isMatch) visibleCount++;
                        cardsContainer?.appendChild(item.el);
                    });

                    rowIndexed.sort((a, b) => a.originalIndex - b.originalIndex);
                    rowIndexed.forEach(item => {
                        const isMatch = matchesFilter(item, catId, purpose);
                        item.el.classList.toggle('hidden', !isMatch);
                        tableBody?.appendChild(item.el);
                    });
                }

                if (visibleCountEl) {
                    visibleCountEl.textContent = visibleCount;
                }

                const isEmpty = visibleCount === 0;
                if (emptyState) emptyState.classList.toggle('hidden', !isEmpty);
                if (cardsContainer) cardsContainer.classList.toggle('hidden', isEmpty || currentView !== 'grid');
                if (tableContainer) tableContainer.classList.toggle('hidden', isEmpty || currentView !== 'table');

                if (clearBtn) {
                    clearBtn.classList.toggle('hidden', !q);
                }
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
                    scrollY: scrollY
                };

                const targetUrl = buildUrl(currentCategorySlug, currentKeyword, currentPurpose);

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
                    if (currentCategorySlug && !currentCategoryId) {
                        const matchedChip = Array.from(chips).find(c => c.dataset.categorySlug === currentCategorySlug);
                        if (matchedChip) currentCategoryId = matchedChip.dataset.categoryId;
                    } else if (currentCategoryId && !currentCategorySlug) {
                        const matchedChip = Array.from(chips).find(c => c.dataset.categoryId === currentCategoryId);
                        if (matchedChip) currentCategorySlug = matchedChip.dataset.categorySlug;
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

                if (state.view && state.view !== currentView) {
                    applyViewMode(state.view, false);
                } else {
                    filterProducts();
                }

                if (shouldRestoreScroll && state.scrollY) {
                    restoreScroll(state.scrollY);
                }
            };

            // 6. Category chip click handler (Use replaceState to avoid cluttering browser history)
            chips.forEach(chip => {
                chip.addEventListener('click', () => {
                    currentCategoryId = chip.dataset.categoryId || '';
                    currentCategorySlug = chip.dataset.categorySlug || '';

                    // Khi người dùng bấm duyệt danh mục, xóa từ khóa tìm kiếm nếu có
                    if (currentKeyword) {
                        currentKeyword = '';
                        if (searchInput) searchInput.value = '';
                    }

                    updateActiveChipUi();
                    filterProducts();

                    // When switching category chip directly, update URL without adding extra history steps
                    saveCurrentState(false, 0);
                });
            });

            // 6b. Purpose chip click handler
            purposeChips.forEach(chip => {
                chip.addEventListener('click', () => {
                    const p = chip.dataset.purpose || '';
                    // Toggle off if already active and clicked again
                    currentPurpose = (currentPurpose === p && p !== '') ? '' : p;

                    updateActiveChipUi();
                    filterProducts();
                    saveCurrentState(false, 0);
                });
            });

            // 7. Search input typing (Debounced replaceState)
            let searchDebounceTimer = null;
            searchInput?.addEventListener('input', (e) => {
                currentKeyword = e.target.value.trim().toLowerCase();

                // Khi tìm kiếm: tìm trên tất cả sản phẩm, reset danh mục về Tất cả
                if (currentKeyword && (currentCategoryId || currentCategorySlug)) {
                    currentCategoryId = '';
                    currentCategorySlug = '';
                    updateActiveChipUi();
                }

                filterProducts();

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
                filterProducts();
                saveCurrentState(false);
            });

            resetFiltersBtn?.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                currentKeyword = '';
                currentCategoryId = '';
                currentCategorySlug = '';
                currentPurpose = '';

                updateActiveChipUi();
                filterProducts();
                saveCurrentState(false, 0);
            });

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
                    state = {
                        categorySlug: slug,
                        categoryId: catId,
                        purpose: purpose,
                        q: q,
                        view: currentView,
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

                    initialState = {
                        categorySlug: initialSlug,
                        categoryId: initialId,
                        purpose: initialPurp,
                        q: initialQ,
                        view: currentView,
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