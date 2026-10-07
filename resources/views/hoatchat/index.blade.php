<x-layouts.app title="Tra cứu Hoạt chất & Nhóm Hợp chất BVTV — Sổ Tay Thuốc BVTV">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-700 via-emerald-700 to-green-800 rounded-2xl text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none text-9xl">⚗️</div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-semibold text-emerald-100 mb-3 border border-white/20">
                            <span>🧪 CƠ SỞ DỮ LIỆU KHOA HỌC</span>
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
                        <a href="{{ route('thuoc.tra-cuu') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-medium transition backdrop-blur border border-white/20">
                            <span>🔍</span> Tra cứu thuốc
                        </a>
                        <a href="{{ route('phoi-tron.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500/30 hover:bg-red-500/40 text-white text-sm font-semibold transition backdrop-blur border border-red-300/30">
                            <span>🚫</span> Kỵ phối trộn
                        </a>
                        <a href="{{ route('benh.tra-cuu') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-medium transition backdrop-blur border border-white/20">
                            <span>🌿</span> Các bài thuốc
                        </a>
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
                                <a href="{{ route('thuoc.xem', $pesticide->id) }}"
                                   class="pesticide-item group flex items-center gap-3.5 p-3 rounded-xl border border-gray-200/80 hover:border-emerald-400 hover:bg-emerald-50/20 bg-white transition shadow-sm hover:shadow">

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

                                    <div class="shrink-0 text-gray-300 group-hover:text-emerald-600 transition pl-1">
                                        →
                                    </div>
                                </a>
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
                                <a href="{{ route('thuoc.xem', $pesticide->id) }}"
                                   class="pesticide-item group flex items-center gap-3.5 p-3 rounded-xl border border-gray-200/80 hover:border-indigo-400 hover:bg-indigo-50/20 bg-white transition shadow-sm hover:shadow">

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

                                    <div class="shrink-0 text-gray-300 group-hover:text-indigo-600 transition pl-1">
                                        →
                                    </div>
                                </a>
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
    </script>
</x-layouts.app>
