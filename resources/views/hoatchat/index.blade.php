<x-layouts.engineer title="Tra cứu Hoạt chất & Nhóm Hợp chất BVTV — Phân Hệ Kỹ Sư">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6">

        <!-- 0. ENGINEER WORKSPACE NAVIGATION TABS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
            <div class="flex items-center gap-2">
                <span class="text-xs font-black uppercase tracking-wider text-teal-800 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-xl flex items-center gap-1.5 shadow-2xs">
                    <span>🔬</span> PHÂN HỆ KỸ SƯ BVTV
                </span>
                <span class="text-xs text-slate-500 hidden md:inline">Không gian nghiên cứu & tra cứu chuyên sâu</span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('phoi-tron.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold bg-white text-slate-700 hover:text-teal-700 hover:bg-teal-50 border border-slate-200 shadow-2xs transition">
                    <span>🚫</span>
                    <span>Kiểm Tra Kỵ Phối Trộn</span>
                </a>
                <a href="{{ route('hoatchat.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold bg-teal-700 text-white shadow-xs transition">
                    <span>⚗️</span>
                    <span>Tra Cứu Hoạt Chất & Hợp Chất</span>
                </a>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-700 via-emerald-700 to-green-800 rounded-2xl text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none text-9xl">⚗️</div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-semibold text-emerald-100 mb-3 border border-white/20">
                            <span>🔬 PHÂN HỆ KỸ SƯ BVTV</span>
                            <span>•</span>
                            <span>TIÊU CHUẨN FRAC & IRAC</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                            <span>⚗️</span> Tra Cứu Hoạt Chất & Nhóm Hợp Chất
                        </h1>
                        <p class="text-emerald-100 text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
                            Hệ thống tra cứu các hoạt chất bảo vệ thực vật, phân loại theo nhóm hợp chất hóa học và danh sách các sản phẩm thuốc thương phẩm trực thuộc.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <a href="{{ route('phoi-tron.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-bold transition backdrop-blur border border-white/20">
                            <span>🚫</span> Kiểm Tra Phối Trộn
                        </a>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('admin.inventory.index') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-medium transition backdrop-blur border border-white/20">
                                <span>🏢</span> Quản Trị Kho
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Thống kê nhanh KPI -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-6 pt-6 border-t border-white/15">
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Tổng số hoạt chất</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5" id="kpi-total-ingredients">
                            {{ $statistics['total_ingredients'] }}
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Nhóm hợp chất / Hóa học</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5" id="kpi-total-groups">
                            {{ $statistics['total_groups'] }}
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Sản phẩm thương phẩm</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5" id="kpi-total-pesticides">
                            {{ $statistics['total_pesticides'] }}
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Phân loại tác động</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5">
                            FRAC & IRAC
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar tìm kiếm và bộ lọc -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-gray-100 space-y-4">
            <div class="flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
                <!-- Ô tìm kiếm tức thì -->
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none text-base">
                        🔍
                    </span>
                    <input type="text"
                        id="ingredientSearchInput"
                        placeholder="Tìm theo tên hoạt chất (vd: Mancozeb, Dimethomorph), nhóm hợp chất (vd: Triazole, Đồng), tên thuốc..."
                        value="{{ $searchQuery }}"
                        class="w-full pl-10 pr-10 py-2.5 bg-gray-50 hover:bg-white focus:bg-white text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    <button id="clearSearchBtn"
                        type="button"
                        class="hidden absolute inset-y-0 right-0 items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                        ✕
                    </button>
                </div>

                <!-- Chuyển đổi chế độ hiển thị: Theo Hoạt chất vs Theo Nhóm Hợp chất -->
                <div class="flex items-center gap-1.5 p-1 bg-gray-100 rounded-xl shrink-0 self-start md:self-auto">
                    <button type="button"
                        id="btnViewIngredient"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 bg-white text-emerald-700 shadow-sm">
                        <span>⚗️</span> Theo Hoạt chất
                    </button>
                    <button type="button"
                        id="btnViewGroup"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 text-gray-600 hover:text-gray-900">
                        <span>🧪</span> Theo Nhóm Hợp chất
                    </button>
                </div>
            </div>

            <!-- Bộ lọc loại tác động (Filter Chips) -->
            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
                <span class="text-xs font-medium text-gray-500 mr-1">Lọc theo:</span>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-emerald-600 text-white shadow-sm"
                    data-type="all" data-filter-mode="type">
                    Tất cả ({{ $ingredients->count() }})
                </button>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200"
                    data-type="Trừ bệnh" data-filter-mode="type">
                    🛡️ Trừ nấm & bệnh hại
                </button>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200"
                    data-type="Trừ sâu" data-filter-mode="type">
                    🐛 Trừ sâu & rầy rệp
                </button>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200"
                    data-type="Dinh dưỡng" data-filter-mode="type">
                    🌿 Dinh dưỡng & Kích kháng
                </button>
                <span class="text-gray-300 mx-1">|</span>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200"
                    data-type="Gốc Đồng" data-filter-mode="group">
                    🔵 Gốc Đồng
                </button>
                <button type="button"
                    class="filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200"
                    data-type="Nhôm" data-filter-mode="group">
                    ⚪ Gốc Nhôm
                </button>
            </div>
        </div>

        <!-- Thông tin số lượng hiển thị -->
        <div class="flex items-center justify-between text-xs text-gray-500 px-1">
            <span id="resultCountText">Đang hiển thị toàn bộ <strong>{{ $ingredients->count() }}</strong> hoạt chất</span>
            <span class="text-emerald-700 font-medium">Bấm vào sản phẩm để xem chi tiết liều dùng & kỹ thuật</span>
        </div>

        <!-- 1. GIAO DIỆN THEO TỪNG HOẠT CHẤT (Ingredient View) -->
        <div id="ingredientViewContainer" class="space-y-6">
            @foreach($ingredients as $ai)
                @php
                    $badgeBg = 'bg-blue-50 text-blue-700 border-blue-200';
                    if (str_contains($ai['type'], 'Trừ bệnh')) {
                        $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    } elseif (str_contains($ai['type'], 'Trừ sâu')) {
                        $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200';
                    } elseif (str_contains($ai['type'], 'Dinh dưỡng')) {
                        $badgeBg = 'bg-teal-50 text-teal-700 border-teal-200';
                    } elseif (str_contains($ai['type'], 'tuyến trùng')) {
                        $badgeBg = 'bg-purple-50 text-purple-700 border-purple-200';
                    }

                    $searchCorpus = mb_strtolower(
                        $ai['name'] . ' ' .
                        $ai['english_name'] . ' ' .
                        $ai['group'] . ' ' .
                        $ai['type'] . ' ' .
                        $ai['code'] . ' ' .
                        $ai['action'] . ' ' .
                        $ai['pesticides']->pluck('name')->implode(' ') . ' ' .
                        $ai['pesticides']->pluck('active_ingredient')->implode(' ')
                    );
                @endphp

                <div class="ingredient-card bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition space-y-4"
                     data-key="{{ $ai['key'] }}"
                     data-type="{{ $ai['type'] }}"
                     data-group="{{ $ai['group'] }}"
                     data-search="{{ $searchCorpus }}">

                    <!-- Card Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-gray-100">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $badgeBg }}">
                                    {{ $ai['type'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $ai['code'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $ai['group'] }}
                                </span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                <span>⚗️</span> {{ $ai['name'] }}
                                @if($ai['english_name'] && $ai['english_name'] !== $ai['name'])
                                    <span class="text-xs font-normal text-gray-400 italic">({{ $ai['english_name'] }})</span>
                                @endif
                            </h2>
                        </div>

                        <div class="shrink-0 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                <span>💊</span> <strong>{{ $ai['count'] }}</strong> sản phẩm
                            </span>
                        </div>
                    </div>

                    <!-- Đặc tính & Cơ chế tác động -->
                    <div class="bg-gradient-to-r from-emerald-50/50 via-teal-50/30 to-blue-50/30 rounded-xl p-3.5 border border-emerald-100/70 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <strong class="text-emerald-900 font-semibold flex items-center gap-1.5 mb-1">
                            <span>🔬</span> Cơ chế tác động & Đặc tính:
                        </strong>
                        <p class="text-gray-600">{{ $ai['action'] }}</p>
                    </div>

                    <!-- Danh sách sản phẩm thương phẩm thuộc hoạt chất -->
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 flex items-center gap-1.5">
                            <span>📦</span> Sản phẩm thương phẩm chứa hoạt chất này ({{ $ai['count'] }})
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                            @foreach($ai['pesticides'] as $pesticide)
                                <div onclick="moModalKyThuat(this)"
                                     data-id="{{ $pesticide->id }}"
                                     data-name="{{ $pesticide->name }}"
                                     data-cat="{{ $pesticide->category?->name ?? 'Thuốc BVTV' }}"
                                     data-active="{{ $pesticide->active_ingredient }}"
                                     data-form="{{ $pesticide->form_type ?? '—' }}"
                                     data-water="{{ $pesticide->water_volume ?? '—' }}"
                                     data-concentration="{{ $pesticide->concentration ?? '—' }}"
                                     data-target="{{ $pesticide->target ?? '—' }}"
                                     data-crops="{{ $pesticide->crops ?? '—' }}"
                                     data-usage="{{ $pesticide->usage ?? '—' }}"
                                     data-isolation="{{ $pesticide->isolation_period ? $pesticide->isolation_period . ' ngày' : '—' }}"
                                     data-stains="{{ $pesticide->stains_fruit ? 'Có thể dính màu trái' : 'An toàn / Không dính màu' }}"
                                     data-manufacturer="{{ $pesticide->manufacturer ?? '—' }}"
                                     data-frac="{{ $pesticide->frac_code ?? '—' }}"
                                     data-irac="{{ $pesticide->irac_code ?? '—' }}"
                                     data-img="{{ $pesticide->image_url ?? '' }}"
                                     data-mixing-url="{{ route('phoi-tron.index', ['pesticide_id' => $pesticide->id]) }}"
                                     class="pesticide-item group flex items-center gap-3.5 p-3 rounded-xl border border-gray-200/80 hover:border-emerald-500 hover:bg-emerald-50/20 bg-white transition shadow-sm hover:shadow cursor-pointer select-none">

                                    <!-- Ảnh thumbnail to rõ 64x64 -->
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center group-hover:scale-105 transition">
                                        @if($pesticide->image_url)
                                            <img src="{{ $pesticide->image_url }}"
                                                 alt="{{ $pesticide->name }}"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        @else
                                            <span class="text-2xl opacity-40">💊</span>
                                        @endif
                                    </div>

                                    <!-- Thông tin sản phẩm -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5 mb-0.5">
                                            @if($pesticide->category)
                                                <span class="text-[10px] font-semibold px-1.5 py-0.2 rounded bg-gray-100 text-gray-600 truncate max-w-[120px]">
                                                    {{ $pesticide->category->name }}
                                                </span>
                                            @endif
                                            @if($pesticide->form_type)
                                                <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                                    {{ $pesticide->form_type }}
                                                </span>
                                            @endif
                                        </div>

                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 truncate transition">
                                            {{ $pesticide->name }}
                                        </h4>

                                        <div class="text-xs text-gray-500 truncate mt-0.5">
                                            {{ $pesticide->active_ingredient }}
                                        </div>

                                        <!-- Badge Pha nước -->
                                        @if($pesticide->water_volume)
                                            <div class="mt-1 inline-flex items-center gap-1 text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">
                                                <span>💧</span>
                                                <span class="truncate max-w-[170px]">{{ $pesticide->water_volume }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="shrink-0 text-slate-400 group-hover:text-emerald-600 transition text-xs font-semibold pl-1 flex items-center gap-1">
                                        <span class="hidden sm:inline">Chi tiết</span>
                                        <span>🔍</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 2. GIAO DIỆN THEO NHÓM HỢP CHẤT (Group View) -->
        <div id="groupViewContainer" class="hidden space-y-6">
            @foreach($chemicalGroups as $group)
                @php
                    $groupSearchCorpus = mb_strtolower(
                        $group['group_name'] . ' ' .
                        $group['type'] . ' ' .
                        $group['code'] . ' ' .
                        $group['action'] . ' ' .
                        implode(' ', $group['ingredients']) . ' ' .
                        $group['pesticides']->pluck('name')->implode(' ') . ' ' .
                        $group['pesticides']->pluck('active_ingredient')->implode(' ')
                    );
                @endphp

                <div class="group-card bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition space-y-4"
                     data-group="{{ $group['group_name'] }}"
                     data-type="{{ $group['type'] }}"
                     data-search="{{ $groupSearchCorpus }}">

                    <!-- Header Nhóm Hợp chất -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-gray-100">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    🔬 NHÓM HÓA HỌC / HỢP CHẤT
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $group['code'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $group['type'] }}
                                </span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                                <span>🧪</span> {{ $group['group_name'] }}
                            </h2>

                            <!-- Các hoạt chất con trong nhóm -->
                            <div class="flex flex-wrap items-center gap-1.5 mt-2">
                                <span class="text-xs text-gray-500 font-medium">Hoạt chất trong nhóm:</span>
                                @foreach($group['ingredients'] as $ing)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-xs font-semibold border border-emerald-200">
                                        {{ $ing }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="shrink-0 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200">
                                <span>📦</span> <strong>{{ $group['pesticides']->count() }}</strong> sản phẩm
                            </span>
                        </div>
                    </div>

                    <!-- Mô tả chung của nhóm hợp chất -->
                    <div class="bg-indigo-50/40 rounded-xl p-3.5 border border-indigo-100 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <strong class="text-indigo-900 font-semibold flex items-center gap-1.5 mb-1">
                            <span>📌</span> Đặc tính nhóm hợp chất:
                        </strong>
                        <p class="text-gray-600">{{ $group['action'] }}</p>
                    </div>

                    <!-- Các sản phẩm trong nhóm hợp chất -->
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 flex items-center gap-1.5">
                            <span>💊</span> Danh sách thuốc thương phẩm thuộc nhóm này ({{ $group['pesticides']->count() }})
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                            @foreach($group['pesticides'] as $pesticide)
                                <div onclick="moModalKyThuat(this)"
                                     data-id="{{ $pesticide->id }}"
                                     data-name="{{ $pesticide->name }}"
                                     data-cat="{{ $pesticide->category?->name ?? 'Thuốc BVTV' }}"
                                     data-active="{{ $pesticide->active_ingredient }}"
                                     data-form="{{ $pesticide->form_type ?? '—' }}"
                                     data-water="{{ $pesticide->water_volume ?? '—' }}"
                                     data-concentration="{{ $pesticide->concentration ?? '—' }}"
                                     data-target="{{ $pesticide->target ?? '—' }}"
                                     data-crops="{{ $pesticide->crops ?? '—' }}"
                                     data-usage="{{ $pesticide->usage ?? '—' }}"
                                     data-isolation="{{ $pesticide->isolation_period ? $pesticide->isolation_period . ' ngày' : '—' }}"
                                     data-stains="{{ $pesticide->stains_fruit ? 'Có thể dính màu trái' : 'An toàn / Không dính màu' }}"
                                     data-manufacturer="{{ $pesticide->manufacturer ?? '—' }}"
                                     data-frac="{{ $pesticide->frac_code ?? '—' }}"
                                     data-irac="{{ $pesticide->irac_code ?? '—' }}"
                                     data-img="{{ $pesticide->image_url ?? '' }}"
                                     data-mixing-url="{{ route('phoi-tron.index', ['pesticide_id' => $pesticide->id]) }}"
                                     class="pesticide-item group flex items-center gap-3.5 p-3 rounded-xl border border-gray-200/80 hover:border-indigo-400 hover:bg-indigo-50/20 bg-white transition shadow-sm hover:shadow cursor-pointer select-none">

                                    <div class="w-16 h-16 rounded-xl bg-gray-100 shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center group-hover:scale-105 transition">
                                        @if($pesticide->image_url)
                                            <img src="{{ $pesticide->image_url }}"
                                                 alt="{{ $pesticide->name }}"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        @else
                                            <span class="text-2xl opacity-40">💊</span>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5 mb-0.5">
                                            @if($pesticide->category)
                                                <span class="text-[10px] font-semibold px-1.5 py-0.2 rounded bg-gray-100 text-gray-600 truncate max-w-[120px]">
                                                    {{ $pesticide->category->name }}
                                                </span>
                                            @endif
                                            @if($pesticide->form_type)
                                                <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                                    {{ $pesticide->form_type }}
                                                </span>
                                            @endif
                                        </div>

                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 truncate transition">
                                            {{ $pesticide->name }}
                                        </h4>

                                        <div class="text-xs text-gray-500 truncate mt-0.5">
                                            {{ $pesticide->active_ingredient }}
                                        </div>

                                        @if($pesticide->water_volume)
                                            <div class="mt-1 inline-flex items-center gap-1 text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">
                                                <span>💧</span>
                                                <span class="truncate max-w-[170px]">{{ $pesticide->water_volume }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="shrink-0 text-slate-400 group-hover:text-indigo-600 transition text-xs font-semibold pl-1 flex items-center gap-1">
                                        <span class="hidden sm:inline">Chi tiết</span>
                                        <span>🔍</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Trạng thái không tìm thấy kết quả -->
        <div id="noResultsState" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm space-y-4">
            <div class="text-5xl">🔬</div>
            <h3 class="text-lg font-bold text-gray-800">Không tìm thấy hoạt chất hoặc hợp chất phù hợp</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">
                Không có kết quả nào khớp với từ khóa của bạn. Thử tìm với tên hoạt chất thông dụng như <span class="font-semibold text-emerald-600">Mancozeb, Dimethomorph, Cartap, Gốc Đồng...</span>
            </p>
            <button type="button"
                id="resetSearchBtn"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow transition">
                Đặt lại tìm kiếm & bộ lọc
            </button>
        </div>

    </div>

    <!-- Script lọc thời gian thực và tương tác người dùng -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('ingredientSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            const resetBtn = document.getElementById('resetSearchBtn');
            const filterBtns = document.querySelectorAll('.filter-type-btn');
            const btnViewIngredient = document.getElementById('btnViewIngredient');
            const btnViewGroup = document.getElementById('btnViewGroup');
            const ingredientView = document.getElementById('ingredientViewContainer');
            const groupView = document.getElementById('groupViewContainer');
            const resultCountText = document.getElementById('resultCountText');
            const noResultsState = document.getElementById('noResultsState');

            const ingredientCards = document.querySelectorAll('.ingredient-card');
            const groupCards = document.querySelectorAll('.group-card');

            let currentView = 'ingredient'; // 'ingredient' or 'group'
            let currentType = 'all';
            let currentFilterMode = 'type'; // 'type' or 'group'

            // Switch view modes
            function setViewMode(mode) {
                currentView = mode;
                if (mode === 'ingredient') {
                    ingredientView.classList.remove('hidden');
                    groupView.classList.add('hidden');
                    btnViewIngredient.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 bg-white text-emerald-700 shadow-sm';
                    btnViewGroup.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 text-gray-600 hover:text-gray-900';
                } else {
                    ingredientView.classList.add('hidden');
                    groupView.classList.remove('hidden');
                    btnViewGroup.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 bg-white text-indigo-700 shadow-sm';
                    btnViewIngredient.className = 'px-3.5 py-1.5 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 text-gray-600 hover:text-gray-900';
                }
                applyFilter();
            }

            btnViewIngredient.addEventListener('click', () => setViewMode('ingredient'));
            btnViewGroup.addEventListener('click', () => setViewMode('group'));

            // Filter by Type or Group
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => {
                        b.className = 'filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200';
                    });
                    this.className = 'filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-emerald-600 text-white shadow-sm';
                    currentType = this.dataset.type;
                    currentFilterMode = this.dataset.filterMode || 'type';
                    applyFilter();
                });
            });

            // Live search
            function applyFilter() {
                const query = searchInput.value.trim().toLowerCase();
                clearBtn.classList.toggle('hidden', query.length === 0);

                let visibleCount = 0;

                if (currentView === 'ingredient') {
                    ingredientCards.forEach(card => {
                        const searchCorpus = card.dataset.search || '';
                        const cardType = card.dataset.type || '';
                        const cardGroup = card.dataset.group || '';

                        const matchesQuery = query === '' || searchCorpus.includes(query);
                        let matchesFilter = true;
                        if (currentType !== 'all') {
                            if (currentFilterMode === 'group') {
                                matchesFilter = cardGroup.toLowerCase().includes(currentType.toLowerCase());
                            } else {
                                matchesFilter = cardType.includes(currentType);
                            }
                        }

                        if (matchesQuery && matchesFilter) {
                            card.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                    resultCountText.innerHTML = `Đang hiển thị <strong>${visibleCount}</strong> hoạt chất`;
                } else {
                    groupCards.forEach(card => {
                        const searchCorpus = card.dataset.search || '';
                        const cardType = card.dataset.type || '';
                        const cardGroup = card.dataset.group || '';

                        const matchesQuery = query === '' || searchCorpus.includes(query);
                        let matchesFilter = true;
                        if (currentType !== 'all') {
                            if (currentFilterMode === 'group') {
                                matchesFilter = cardGroup.toLowerCase().includes(currentType.toLowerCase());
                            } else {
                                matchesFilter = cardType.includes(currentType);
                            }
                        }

                        if (matchesQuery && matchesFilter) {
                            card.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                    resultCountText.innerHTML = `Đang hiển thị <strong>${visibleCount}</strong> nhóm hợp chất`;
                }

                if (visibleCount === 0) {
                    noResultsState.classList.remove('hidden');
                } else {
                    noResultsState.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', applyFilter);

            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchInput.focus();
                applyFilter();
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    currentType = 'all';
                    currentFilterMode = 'type';
                    filterBtns.forEach((b, idx) => {
                        if (idx === 0) {
                            b.className = 'filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-emerald-600 text-white shadow-sm';
                        } else {
                            b.className = 'filter-type-btn px-3 py-1 rounded-full text-xs font-semibold transition bg-gray-100 text-gray-700 hover:bg-gray-200';
                        }
                    });
                    applyFilter();
                });
            }

            // Run initial filter if query present
            if (searchInput.value.trim() !== '') {
                applyFilter();
            }
        });

        // ENGINEER TECHNICAL SPECIFICATION MODAL HANDLER
        function moModalKyThuat(el) {
            const ds = el.dataset;
            document.getElementById('mName').textContent = ds.name || '—';
            document.getElementById('mCat').textContent = ds.cat || 'Thuốc BVTV';
            document.getElementById('mForm').textContent = ds.form || '—';
            document.getElementById('mActive').textContent = ds.active || '—';
            document.getElementById('mWater').textContent = ds.water || '—';
            document.getElementById('mConcentration').textContent = ds.concentration || '—';
            document.getElementById('mTarget').textContent = ds.target || '—';
            document.getElementById('mCrops').textContent = ds.crops || '—';
            document.getElementById('mIsolation').textContent = ds.isolation || '—';
            document.getElementById('mStains').textContent = ds.stains || '—';
            document.getElementById('mManufacturer').textContent = ds.manufacturer || '—';
            document.getElementById('mUsage').textContent = ds.usage || 'Tuân thủ nghiêm ngặt nguyên tắc 4 đúng khi pha trộn và xử lý trên vườn.';

            const fracEl = document.getElementById('mFrac');
            if (ds.frac && ds.frac !== '—') {
                fracEl.textContent = 'FRAC: ' + ds.frac;
                fracEl.classList.remove('hidden');
            } else if (ds.irac && ds.irac !== '—') {
                fracEl.textContent = 'IRAC: ' + ds.irac;
                fracEl.classList.remove('hidden');
            } else {
                fracEl.classList.add('hidden');
            }

            const imgEl = document.getElementById('mImg');
            const phEl = document.getElementById('mPlaceholder');
            if (ds.img && ds.img !== '') {
                imgEl.src = ds.img;
                imgEl.classList.remove('hidden');
                phEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                phEl.classList.remove('hidden');
            }

            document.getElementById('mMixingBtn').href = ds.mixingUrl || '{{ route('phoi-tron.index') }}';
            document.getElementById('modalKyThuat').classList.remove('hidden');
        }

        function dongModalKyThuat() {
            document.getElementById('modalKyThuat')?.classList.add('hidden');
        }

        document.getElementById('modalKyThuat')?.addEventListener('click', function(e) {
            if (e.target === this) dongModalKyThuat();
        });
    </script>

    <!-- ENGINEER TECHNICAL SPECIFICATION MODAL -->
    <div id="modalKyThuat" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/70 backdrop-blur-xs hidden transition-opacity">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-150">
            <!-- Modal Header -->
            <div class="px-5 py-4 bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white flex items-center justify-between border-b border-teal-800/40">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">🔬</span>
                    <div>
                        <h3 class="text-sm font-black tracking-wide uppercase text-teal-300">THÔNG SỐ KỸ THUẬT & DỮ LIỆU NÔNG HỌC</h3>
                        <p class="text-[11px] text-slate-400">Phân Hệ Kỹ Sư BVTV • Không chuyển hướng cửa hàng</p>
                    </div>
                </div>
                <button type="button" onclick="dongModalKyThuat()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition">
                    ✕
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="p-5 sm:p-6 overflow-y-auto space-y-4 text-xs">
                <!-- Top info: Image + Name + Category -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 pb-4 border-b border-slate-100">
                    <div class="w-24 h-24 rounded-2xl bg-slate-50 border border-slate-200 p-1.5 shrink-0 flex items-center justify-center overflow-hidden">
                        <img id="mImg" src="" alt="" class="max-w-full max-h-full object-contain hidden">
                        <span id="mPlaceholder" class="text-3xl">💊</span>
                    </div>
                    <div class="flex-1 text-center sm:text-left min-w-0">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-1.5 mb-1.5">
                            <span id="mCat" class="px-2 py-0.5 rounded-md bg-teal-50 text-teal-800 font-bold border border-teal-200"></span>
                            <span id="mForm" class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 font-black border border-amber-200"></span>
                            <span id="mFrac" class="px-2 py-0.5 rounded-md bg-purple-50 text-purple-800 font-bold border border-purple-200"></span>
                        </div>
                        <h2 id="mName" class="text-lg sm:text-xl font-extrabold text-slate-900 leading-snug"></h2>
                        <div class="text-xs text-slate-600 mt-1">
                            Hàm lượng / Quy chuẩn: <strong id="mConcentration" class="text-slate-900"></strong>
                        </div>
                    </div>
                </div>

                <!-- Technical Grid Specs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hoạt chất chính</div>
                        <div id="mActive" class="text-xs font-extrabold text-emerald-800"></div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">💧 Lượng nước pha khuyến nghị</div>
                        <div id="mWater" class="text-xs font-extrabold text-teal-800"></div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">🎯 Đối tượng phòng trừ</div>
                        <div id="mTarget" class="text-xs font-semibold text-slate-800"></div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">🌳 Cây trồng đăng ký</div>
                        <div id="mCrops" class="text-xs font-semibold text-slate-800"></div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">⏱️ Thời gian cách ly (PHI)</div>
                        <div id="mIsolation" class="text-xs font-bold text-slate-800"></div>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">🎨 Dính màu trái non</div>
                        <div id="mStains" class="text-xs font-bold text-slate-800"></div>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">🏢 Nhà sản xuất / Đăng ký</div>
                    <div id="mManufacturer" class="text-xs font-semibold text-slate-800"></div>
                </div>

                <!-- Usage Notes -->
                <div class="p-3 rounded-xl bg-teal-50/50 border border-teal-200/60 space-y-1">
                    <div class="text-[11px] font-bold text-teal-800 uppercase tracking-wider">📋 Hướng dẫn kỹ thuật & Lưu ý phối trộn</div>
                    <p id="mUsage" class="text-xs text-slate-700 leading-relaxed"></p>
                </div>
            </div>

            <!-- Modal Footer with Engineer Actions -->
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <button type="button" onclick="dongModalKyThuat()" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition">
                    Đóng
                </button>
                <div class="flex items-center gap-2">
                    <a id="mMixingBtn" href="#" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs transition shadow-xs">
                        <span>🚫</span>
                        <span>Kiểm tra kỵ phối trộn thuốc này</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.engineer>
