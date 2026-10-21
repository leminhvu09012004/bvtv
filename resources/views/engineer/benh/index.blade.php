<x-layouts.engineer title="Bệnh Hại & Phác Đồ Cây Trồng — Phân Hệ Kỹ Sư">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto space-y-6">

    <!-- 1. HEADER SECTION & KPI -->
    <div class="relative bg-gradient-to-r from-teal-900 via-emerald-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-xl overflow-hidden border border-teal-700/50"
         style="background: linear-gradient(135deg, #042f2e 0%, #064e3b 50%, #0f172a 100%) !important; color: #ffffff !important;">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-20 top-0 w-56 h-56 bg-teal-400/15 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-emerald-200 text-xs font-bold mb-3 border border-white/20 backdrop-blur-xs">
                    <span>🔬 PHÂN HỆ KỸ SƯ BVTV</span>
                    <span>•</span>
                    <span>CẨM NANG NÔNG HỌC & BỆNH HẠI</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-2.5 drop-shadow-sm">
                    <span>🌿</span> Bệnh Hại Cây Trồng & Phác Đồ Điều Trị
                </h1>
                <p class="text-emerald-100 text-xs sm:text-sm mt-2 leading-relaxed">
                    Hệ thống chẩn đoán triệu chứng theo từng bộ phận (Lá • Thân • Rễ • Quả), phân loại theo tác nhân sinh học (Nấm • Virus • Tuyến trùng) và kết nối phác đồ thuốc bảo vệ thực vật chính hãng trong kho.
                </p>
            </div>

            <!-- Action: Thêm bệnh mới -->
            <div class="flex items-center gap-2.5 shrink-0">
                <button type="button"
                        onclick="moModalThemBenh()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs sm:text-sm shadow-lg shadow-emerald-950/50 transition active:scale-95 border border-emerald-400/30 cursor-pointer">
                    <span>➕</span>
                    <span>Thêm Bệnh Mới</span>
                </button>
            </div>
        </div>

        <!-- KPI Thống kê tác nhân -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mt-6 pt-6 border-t border-white/15">
            <div class="p-3.5 rounded-2xl border border-white/15 backdrop-blur-xs transition" style="background: rgba(255, 255, 255, 0.08);">
                <div class="text-[11px] text-emerald-200 font-semibold">Tổng đối tượng</div>
                <div id="kpiStatTotal" class="text-xl sm:text-2xl font-black text-white mt-0.5">{{ $stats['total'] }}</div>
            </div>
            <div class="p-3.5 rounded-2xl border border-amber-400/30 backdrop-blur-xs transition" style="background: rgba(245, 158, 11, 0.15);">
                <div class="text-[11px] text-amber-200 font-bold flex items-center gap-1">
                    <span>🍄</span> Nấm bệnh
                </div>
                <div id="kpiStatNam" class="text-xl sm:text-2xl font-black text-amber-100 mt-0.5">{{ $stats['nam'] }}</div>
            </div>
            <div class="p-3.5 rounded-2xl border border-emerald-400/30 backdrop-blur-xs transition" style="background: rgba(16, 185, 129, 0.15);">
                <div class="text-[11px] text-emerald-200 font-bold flex items-center gap-1">
                    <span>🐛</span> Sâu hại & Nhện
                </div>
                <div id="kpiStatSauHai" class="text-xl sm:text-2xl font-black text-emerald-100 mt-0.5">{{ $stats['sau_hai'] ?? 0 }}</div>
            </div>
            <div class="p-3.5 rounded-2xl border border-purple-400/30 backdrop-blur-xs transition" style="background: rgba(168, 85, 247, 0.15);">
                <div class="text-[11px] text-purple-200 font-bold flex items-center gap-1">
                    <span>🦠</span> Virus hại
                </div>
                <div id="kpiStatVirus" class="text-xl sm:text-2xl font-black text-purple-100 mt-0.5">{{ $stats['virus'] }}</div>
            </div>
            <div class="p-3.5 rounded-2xl border border-rose-400/30 backdrop-blur-xs transition" style="background: rgba(244, 63, 94, 0.15);">
                <div class="text-[11px] text-rose-200 font-bold flex items-center gap-1">
                    <span>🪱</span> Tuyến trùng
                </div>
                <div id="kpiStatTuyenTrung" class="text-xl sm:text-2xl font-black text-rose-100 mt-0.5">{{ $stats['tuyen_trung'] }}</div>
            </div>
            <div class="p-3.5 rounded-2xl border border-blue-400/30 backdrop-blur-xs transition" style="background: rgba(59, 130, 246, 0.15);">
                <div class="text-[11px] text-blue-200 font-bold flex items-center gap-1">
                    <span>🧪</span> Vi khuẩn & Tảo
                </div>
                <div id="kpiStatViKhuan" class="text-xl sm:text-2xl font-black text-blue-100 mt-0.5">{{ $stats['vi_khuan'] }}</div>
            </div>
        </div>
    </div>

    <!-- 2. BẢNG ĐIỀU KHIỂN TRA CỨU & BỘ LỌC DẠNG DROPDOWN (FILTER & SEARCH HUB) -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-slate-200/90 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-end">
            <!-- DROPDOWN 1: CHỌN CÂY TRỒNG (LỌC TRANG) -->
            <div class="sm:col-span-1 lg:col-span-4 space-y-1.5">
                <label for="selectCropFilter" class="block text-xs font-black uppercase tracking-wider text-slate-600 flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span>🌱</span> CÂY TRỒNG KHẢO SÁT:</span>
                    <span id="lblSelectedCropBadge" class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">
                        {{ $selectedCrop === 'all' ? 'Tất cả' : $selectedCrop }}
                    </span>
                </label>
                <div class="relative">
                    <select id="selectCropFilter"
                            onchange="thayDoiCayTrong(this.value)"
                            class="w-full appearance-none pl-3.5 pr-9 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-300 rounded-2xl text-xs sm:text-sm font-extrabold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition cursor-pointer shadow-2xs">
                        <option value="all" {{ $selectedCrop === 'all' ? 'selected' : '' }}>
                            🌐 Tất cả cây trồng ({{ $totalAllDiseasesCount }} đối tượng)
                        </option>
                        @foreach($crops as $cropKey => $cropInfo)
                            <option value="{{ $cropKey }}" {{ $selectedCrop === $cropKey ? 'selected' : '' }}>
                                {{ $cropInfo['emoji'] }} {{ $cropInfo['name'] }} ({{ $cropCounts[$cropKey] ?? 0 }} đối tượng)
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 text-xs font-black">
                        ▼
                    </span>
                </div>
            </div>

            <!-- DROPDOWN 2: PHÂN LOẠI DỊCH HẠI (LỌC REALTIME THEO SỔ TAY & TÁC NHÂN) -->
            <div class="sm:col-span-1 lg:col-span-4 space-y-1.5">
                <label for="selectDichHaiFilter" class="block text-xs font-black uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                    <span>📁</span> PHÂN LOẠI DỊCH HẠI:
                </label>
                <div class="relative">
                    <select id="selectDichHaiFilter"
                            onchange="locDichHai(this.value)"
                            class="w-full appearance-none pl-3.5 pr-9 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-300 rounded-2xl text-xs sm:text-sm font-extrabold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition cursor-pointer shadow-2xs">
                        <option value="all" data-filter="all">🌐 Toàn bộ dịch hại ({{ $groupCounts['all'] ?? 0 }})</option>
                        <option value="nam_benh" data-filter="nam_benh">🍄 I. Nấm & Bệnh hại ({{ $groupCounts['nam_benh'] ?? 0 }})</option>
                        <option value="chich_hut" data-filter="chich_hut">🦟 II. Côn trùng chích hút ({{ $groupCounts['chich_hut'] ?? 0 }})</option>
                        <option value="sau_hai" data-filter="sau_hai">🐛 III. Sâu cắn phá & Ruồi ({{ $groupCounts['sau_hai'] ?? 0 }})</option>
                        <option value="nhen_tuyen_trung" data-filter="nhen_tuyen_trung">🕷️ IV. Nhện & Tuyến trùng ({{ $groupCounts['nhen_tuyen_trung'] ?? 0 }})</option>
                        <option value="pathogen:virus" data-filter="pathogen:virus">🦠 Tác nhân Virus ({{ $groupCounts['virus'] ?? 0 }})</option>
                        <option value="pathogen:vi_khuan" data-filter="pathogen:vi_khuan">🧪 Tác nhân Vi khuẩn & Tảo ({{ $groupCounts['vi_khuan'] ?? 0 }})</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 text-xs font-black">
                        ▼
                    </span>
                </div>
            </div>

            <!-- THANH TÌM KIẾM NHANH REALTIME -->
            <div class="sm:col-span-2 lg:col-span-4 space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="inputSearchDisease" class="block text-xs font-black uppercase tracking-wider text-slate-600 flex items-center gap-1.5">
                        <span>🔍</span> TÌM KIẾM REALTIME:
                    </label>
                    <span class="text-[11px] font-bold text-slate-500">
                        Hiển thị: <b id="countDisplay" class="text-teal-700 font-black">{{ $diseases->count() }}</b> / <span id="totalDisplay">{{ $diseases->count() }}</span>
                    </span>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                        🔍
                    </span>
                    <input type="text"
                           id="inputSearchDisease"
                           value="{{ $searchQuery }}"
                           placeholder="Tìm theo tên bệnh, mã (B-01, S-01...), triệu chứng..."
                           class="w-full pl-9 pr-9 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500 transition shadow-2xs font-medium placeholder:text-slate-400">
                    <button type="button"
                            id="btnClearSearch"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer {{ $searchQuery ? '' : 'hidden' }}">
                        ✕
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. DANH SÁCH THẺ BỆNH HẠI (DISEASE CARDS GRID) -->
    <div id="diseaseCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($diseases as $disease)
            <div class="disease-card bg-white rounded-3xl p-5 shadow-sm border border-slate-200/90 hover:border-teal-400 hover:shadow-md transition flex flex-col justify-between space-y-4"
                 id="card-disease-{{ $disease->id }}"
                 data-id="{{ $disease->id }}"
                 data-name="{{ mb_strtolower($disease->name) }}"
                 data-crop="{{ mb_strtolower($disease->crops->pluck('name')->implode(' ') . ' ' . ($disease->crop_name ?? '')) }}"
                 data-pathogen="{{ $disease->pathogen_type ?? 'nam' }}"
                 data-folder-group="{{ $disease->folder_group ?? '' }}"
                 data-folder-code="{{ mb_strtolower($disease->folder_code ?? '') }}"
                 data-search="{{ mb_strtolower(($disease->folder_code ?? '') . ' ' . ($disease->folder_name ?? '') . ' ' . $disease->name . ' ' . $disease->caunho . ' ' . $disease->symptoms . ' ' . $disease->chemical_groups . ' ' . $disease->crops->pluck('name')->implode(' ')) }}">

                <div class="space-y-3">
                    <!-- Top row: Mã thư mục + Badge Tác nhân + Số ảnh -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            @if($disease->folder_code)
                                <span class="px-2 py-0.5 rounded-lg text-[11px] font-black font-mono tracking-tight bg-teal-100 text-teal-900 border border-teal-300" title="Mã sổ tra cứu: {{ $disease->folder_code }}">
                                    📁 {{ $disease->folder_code }}
                                </span>
                            @endif
                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $disease->pathogen_badge }}">
                                {{ $disease->pathogen_emoji }} {{ $disease->pathogen_label }}
                            </span>
                            @if($disease->crops && $disease->crops->isNotEmpty())
                                @foreach($disease->crops as $c)
                                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200" title="Cây mẫn cảm: {{ $c->name }}">
                                        {{ $c->emoji }} {{ $c->name }}
                                    </span>
                                @endforeach
                            @elseif($disease->crop_name)
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    🌱 {{ $disease->crop_name }}
                                </span>
                            @endif
                        </div>
                        <span class="text-[11px] font-bold text-slate-400 flex items-center gap-1 shrink-0">
                            <span>📸</span> {{ count($disease->images_urls) }} ảnh
                        </span>
                    </div>

                    @if($disease->folder_name)
                        <div class="text-[10px] text-slate-500 font-mono bg-slate-50 px-2 py-1 rounded-md border border-slate-200/60 truncate" title="Thư mục máy tính: {{ $disease->folder_name }}">
                            📂 {{ $disease->folder_name }}
                        </div>
                    @endif

                    <!-- Tên bệnh & Ảnh minh họa (nếu có) -->
                    <div class="flex items-start gap-3">
                        <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}"
                           class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 shrink-0 overflow-hidden flex items-center justify-center cursor-pointer hover:opacity-90 transition"
                           title="Xem trang chi tiết {{ $disease->name }}">
                            @if($disease->image_url)
                                <img src="{{ $disease->image_url }}" alt="{{ $disease->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl opacity-60">{{ $disease->pathogen_emoji }}</span>
                            @endif
                        </a>
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}" class="block group">
                                <h3 class="text-base font-extrabold text-slate-900 leading-snug group-hover:text-teal-700 transition">
                                    {{ $disease->name }}
                                </h3>
                            </a>
                            @if($disease->caunho)
                                <div class="mt-1 text-[11px] text-teal-800 font-bold bg-teal-50 border border-teal-200/80 px-2.5 py-1 rounded-xl">
                                    🧠 {{ $disease->caunho }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Hoạt chất cần tra cứu (Chuẩn chuyên môn & thị trường - kể cả chưa có trong kho) -->
                    @if($disease->chemical_groups)
                        @php
                            $cardGroups = array_filter(array_map('trim', explode(',', $disease->chemical_groups)));
                        @endphp
                        <div class="pt-1 space-y-1.5">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-wider flex items-center justify-between">
                                <span class="flex items-center gap-1">⚗️ Hoạt chất khuyến cáo (FRAC):</span>
                                <span class="text-teal-700 font-bold">{{ count($cardGroups) }} hoạt chất</span>
                            </div>
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($cardGroups, 0, 5) as $cg)
                                    @php
                                        $hasTag = preg_match('/^(.*?)\s*\((.*?)\)$/', $cg, $m);
                                        $cName = $hasTag ? trim($m[1]) : $cg;
                                        $cTag = $hasTag ? trim($m[2]) : null;
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-teal-50/80 border border-teal-200/80 text-[10.5px] font-extrabold text-teal-900 shadow-2xs">
                                        {{ $cName }}
                                        @if($cTag)
                                            <span class="text-[9px] font-mono text-teal-800 bg-teal-100/90 px-1 rounded">{{ $cTag }}</span>
                                        @endif
                                    </span>
                                @endforeach
                                @if(count($cardGroups) > 5)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-bold border border-slate-200">
                                        +{{ count($cardGroups) - 5 }} hoạt chất
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Thuốc liên kết trong kho -->
                    <div class="pt-1 space-y-1">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-between">
                            <span>💊 Thuốc sẵn trong kho ({{ $disease->pesticides->count() }})</span>
                        </div>
                        @if($disease->pesticides->isNotEmpty())
                            <div class="flex flex-wrap items-center gap-1.5">
                                @foreach($disease->pesticides->take(3) as $p)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">
                                        {{ $p->name }}
                                    </span>
                                @endforeach
                                @if($disease->pesticides->count() > 3)
                                    <span class="text-[10px] text-slate-400 font-bold">+{{ $disease->pesticides->count() - 3 }} loại</span>
                                @endif
                            </div>
                        @else
                            <div class="text-[11px] text-slate-400 italic">
                                Kho chưa có hàng — tra cứu theo hoạt chất trên để nhập/tìm thêm
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Bottom Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs transition shadow-xs">
                        <span>📖</span> Xem chi tiết phác đồ
                    </a>
                    <div class="flex items-center gap-1">
                        <button type="button"
                                onclick="moModalSuaBenh({{ $disease->id }})"
                                class="p-1.5 rounded-lg text-slate-500 hover:text-teal-700 hover:bg-slate-100 transition"
                                title="Chỉnh sửa thông tin bệnh">
                            ✏️
                        </button>
                        <button type="button"
                                onclick="xacNhanXoaBenh({{ $disease->id }}, '{{ addslashes($disease->name) }}')"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                title="Xóa bệnh">
                            🗑️
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-dashed border-slate-300">
                <span class="text-4xl block mb-2">🌿</span>
                <p class="text-sm font-bold text-slate-700">Chưa có dữ liệu bệnh hại cho tiêu chí đã chọn.</p>
                <p class="text-xs text-slate-400 mt-1">Hãy nhấn "Thêm Bệnh Mới" để bắt đầu bổ sung vào cẩm nang.</p>
            </div>
        @endforelse
    </div>

    <!-- Empty state for search filter -->
    <div id="noSearchResults" class="hidden py-12 text-center bg-white rounded-3xl border border-dashed border-slate-300">
        <span class="text-4xl block mb-2">🔍</span>
        <p class="text-sm font-bold text-slate-700">Không tìm thấy bệnh hại phù hợp với từ khóa.</p>
        <p class="text-xs text-slate-400 mt-1">Thử đổi từ khóa hoặc bấm nút "Tất cả tác nhân".</p>
    </div>

</div>



<!-- ========================================================================= -->
<!-- 7. MODAL THÊM / SỬA BỆNH (AJAX CRUD FORM) -->
<!-- ========================================================================= -->
<div id="modalFormBenh" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/70 backdrop-blur-xs hidden transition-opacity">
    <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-3xl overflow-hidden flex flex-col max-h-[92vh] animate-in fade-in zoom-in-95 duration-150">
        <!-- Form Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white flex items-center justify-between border-b border-teal-800/40">
            <div class="flex items-center gap-2">
                <span class="text-xl">🌿</span>
                <h2 id="modalFormTitle" class="text-base font-black tracking-wide text-white">Thêm Bệnh Cây Trồng Mới</h2>
            </div>
            <button type="button" onclick="dongModalForm()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition">
                ✕
            </button>
        </div>

        <!-- Form Body -->
        <form id="formDiseaseAjax" class="flex flex-col flex-1 overflow-hidden" onsubmit="xuLyLuuBenh(event)">
            @csrf
            <input type="hidden" id="formDiseaseId" name="disease_id" value="">

            <div class="p-6 overflow-y-auto space-y-4 text-xs">
                <!-- Row 1: Tên bệnh & Cây trồng & Tác nhân -->
                <!-- Row 1: Tên bệnh & Tác nhân -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="font-extrabold text-slate-700">Tên bệnh hại <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="name"
                               id="formName"
                               required
                               placeholder="Ví dụ: Bệnh Đốm Nâu — Alternaria"
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 font-bold text-slate-900">
                    </div>

                    <div class="space-y-1">
                        <label class="font-extrabold text-slate-700">Tác nhân gây bệnh <span class="text-rose-500">*</span></label>
                        <select name="pathogen_type" id="formPathogenType" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 font-bold text-slate-900">
                            <option value="nam">🍄 Nấm bệnh</option>
                            <option value="virus">🦠 Virus hại</option>
                            <option value="tuyen_trung">🪱 Tuyến trùng</option>
                            <option value="vi_khuan">🧪 Vi khuẩn & Tảo</option>
                            <option value="sau_hai">🐛 Sâu hại & Nhện</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Chọn nhiều cây trồng có thể bị bệnh -->
                <div class="space-y-1.5 p-3 rounded-2xl bg-teal-50/40 border border-teal-100">
                    <div class="flex items-center justify-between">
                        <label class="font-black text-slate-800 uppercase tracking-wide flex items-center gap-1.5 text-xs">
                            <span>🌱</span> Cây trồng có thể bị bệnh (Chọn một hoặc nhiều cây): <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] text-teal-700 font-semibold">1 bệnh có thể ở nhiều cây</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 pt-1" id="wrapCropCheckboxes">
                        @foreach($crops as $cKey => $cInfo)
                            <label class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 bg-white hover:bg-teal-50 hover:border-teal-300 transition cursor-pointer text-xs select-none shadow-2xs">
                                <input type="checkbox" 
                                       name="crop_ids[]" 
                                       value="{{ $cInfo['id'] ?? '' }}" 
                                       data-crop-name="{{ $cKey }}" 
                                       class="chk-crop rounded text-teal-600 focus:ring-teal-500">
                                <span class="font-bold text-slate-800">{{ $cInfo['emoji'] }} {{ $cKey }}</span>
                            </label>
                        @endforeach
                    </div>
                    <input type="hidden" name="crop_name" id="formCropName" value="">
                </div>

                <!-- Row 3: Câu nhớ nằm lòng -->
                <div class="space-y-1">
                    <label class="font-extrabold text-slate-700">Câu nhớ nằm lòng (Kỹ sư)</label>
                    <input type="text"
                           name="caunho"
                           id="formCaunho"
                           placeholder="Ví dụ: Alternaria → ĐỐM NÂU → lá + cành + quả"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 text-slate-900">
                </div>

                <!-- Biện pháp phòng & trị -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-slate-200">
                    <div class="space-y-1">
                        <label class="font-extrabold text-blue-900">🛡️ Biện pháp phòng bệnh</label>
                        <textarea name="prevention" id="formPrevention" rows="3" placeholder="Tỉa giàn thông thoáng, làm rãnh thoát nước..." class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs"></textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="font-extrabold text-emerald-900">💊 Biện pháp điều trị</label>
                        <textarea name="treatment" id="formTreatment" rows="3" placeholder="Phun luân phiên các hoạt chất khi mới chớm bệnh..." class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs"></textarea>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-extrabold text-slate-700">⚗️ Nhóm hoạt chất cần nhớ</label>
                    <input type="text"
                           name="chemical_groups"
                           id="formChemicalGroups"
                           placeholder="Ví dụ: Mancozeb, Azoxystrobin, Difenoconazole, Tebuconazole"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900">
                </div>

                <!-- Gắn thuốc trong kho -->
                <div class="space-y-2 pt-2 border-t border-slate-200">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <label class="font-black text-slate-800 uppercase tracking-wide">📦 Gắn thuốc trong kho đặc trị bệnh này:</label>
                        <button type="button"
                                onclick="tuDongChonThuocTheoHoatChat('formChemicalGroups')"
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 font-extrabold text-[11px] border border-teal-200 transition">
                            <span>⚡</span> Tự động chọn theo hoạt chất
                        </button>
                    </div>
                    <div class="max-h-40 overflow-y-auto border border-slate-200 rounded-2xl p-2 bg-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-1.5 scrollbar-thin">
                        @foreach($warehousePesticides as $wp)
                            <label class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-white transition cursor-pointer text-xs">
                                <input type="checkbox"
                                       name="pesticide_ids[]"
                                       value="{{ $wp->id }}"
                                       class="chk-pesticide rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-800 truncate">{{ $wp->name }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">{{ $wp->active_ingredient }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Quản lý hình ảnh (Upload nhiều ảnh) -->
                <div class="space-y-2 pt-2 border-t border-slate-200">
                    <label class="font-black text-slate-800 uppercase tracking-wide flex items-center justify-between">
                        <span>📸 Thư viện ảnh triệu chứng (Upload nhiều ảnh)</span>
                        <span class="text-[11px] text-slate-400 font-normal">Tối đa 5MB / ảnh (JPG, PNG, WebP)</span>
                    </label>
                    <input type="file"
                           name="images[]"
                           id="formImagesInput"
                           multiple
                           accept="image/*"
                           class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">

                    <!-- Danh sách ảnh cũ (để xóa nếu đang sửa) -->
                    <div id="formCurrentImagesWrap" class="hidden space-y-1.5 pt-2">
                        <span class="text-[11px] font-bold text-slate-500">Ảnh hiện có:</span>
                        <div id="formCurrentImagesList" class="flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                <button type="button" onclick="dongModalForm()" class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition">
                    Hủy bỏ
                </button>
                <button type="submit" id="btnSubmitForm" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-black text-xs transition shadow-sm active:scale-95">
                    <span>💾</span>
                    <span id="btnSubmitFormText">Lưu Bệnh Hại</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 8. MODAL PHÓNG TO ẢNH (IMAGE LIGHTBOX) -->
<!-- ========================================================================= -->
<div id="modalLightboxAnh" class="fixed inset-0 z-60 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md hidden transition-opacity" onclick="if(event.target===this)dongLightbox()">
    <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center">
        <button type="button" onclick="dongLightbox()" class="absolute -top-10 right-0 text-white hover:text-rose-400 text-2xl font-bold p-1">
            ✕ Đóng
        </button>
        <img id="lightboxImg" src="" alt="" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain border border-white/20">
    </div>
</div>

<!-- JAVASCRIPT LOGIC AJAX CHO PHÂN HỆ BỆNH HẠI -->
<script>
    let currentEditingId = null;

    // Lọc theo từ khóa ô tìm kiếm realtime
    const inputSearch = document.getElementById('inputSearchDisease');
    const btnClearSearch = document.getElementById('btnClearSearch');

    inputSearch?.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        btnClearSearch.classList.toggle('hidden', query.length === 0);
        locDanhSachCards();
    });

    btnClearSearch?.addEventListener('click', function() {
        inputSearch.value = '';
        this.classList.add('hidden');
        locDanhSachCards();
        inputSearch.focus();
    });

    let activeFilter = 'all';
    let currentSelectedCrop = '{{ $selectedCrop ?? "all" }}';

    function thayDoiCayTrong(cropValue) {
        currentSelectedCrop = cropValue || 'all';

        // Cập nhật badge hiển thị cây đang chọn
        const lbl = document.getElementById('lblSelectedCropBadge');
        if (lbl) {
            lbl.textContent = (currentSelectedCrop === 'all') ? 'Tất cả' : currentSelectedCrop;
        }

        // Đồng bộ URL êm ái không reload trang
        const url = new URL(window.location);
        if (currentSelectedCrop === 'all') {
            url.searchParams.set('crop', 'all');
        } else {
            url.searchParams.set('crop', currentSelectedCrop);
        }
        window.history.replaceState({}, '', url);

        locDanhSachCards();
    }

    function locDichHai(filterKey) {
        activeFilter = filterKey || 'all';
        const sel = document.getElementById('selectDichHaiFilter');
        if (sel && sel.value !== activeFilter) {
            sel.value = activeFilter;
        }
        locDanhSachCards();
    }

    // Tương thích ngược nếu còn lời gọi cũ
    function locNhomThuMuc(group) {
        locDichHai(group);
    }
    function locTacNhan(type) {
        locDichHai(type === 'all' ? 'all' : 'pathogen:' + type);
    }

    // Lọc danh sách thẻ theo cả Cây Trồng + Nhóm Dịch Hại + Từ khóa tìm kiếm (Instant 0ms, không reload)
    function locDanhSachCards() {
        const query = inputSearch ? inputSearch.value.trim().toLowerCase() : '';
        const cards = document.querySelectorAll('.disease-card');
        let visibleCount = 0;

        // Bộ đếm thống kê theo cây trồng hiện tại
        let cropTotal = 0;
        let cropNam = 0;
        let cropSauHai = 0;
        let cropVirus = 0;
        let cropTuyenTrung = 0;
        let cropViKhuan = 0;

        let cropNamBenh = 0;
        let cropChichHut = 0;
        let cropSauHaiGroup = 0;
        let cropNhenTuyenTrung = 0;

        cards.forEach(card => {
            const cardCrop = (card.dataset.crop || '').toLowerCase();
            const cardPathogen = card.dataset.pathogen || '';
            const cardFolderGroup = card.dataset.folderGroup || '';
            const searchCorpus = card.dataset.search || '';

            // 1. Kiểm tra cây trồng
            let matchesCrop = false;
            if (currentSelectedCrop === 'all') {
                matchesCrop = true;
            } else {
                matchesCrop = cardCrop.includes(currentSelectedCrop.toLowerCase());
            }

            if (matchesCrop) {
                cropTotal++;
                if (cardPathogen === 'nam') cropNam++;
                else if (cardPathogen === 'sau_hai') cropSauHai++;
                else if (cardPathogen === 'virus') cropVirus++;
                else if (cardPathogen === 'tuyen_trung') cropTuyenTrung++;
                else if (cardPathogen === 'vi_khuan') cropViKhuan++;

                if (cardFolderGroup === 'nam_benh') cropNamBenh++;
                else if (cardFolderGroup === 'chich_hut') cropChichHut++;
                else if (cardFolderGroup === 'sau_hai') cropSauHaiGroup++;
                else if (cardFolderGroup === 'nhen_tuyen_trung') cropNhenTuyenTrung++;
            }

            // 2. Kiểm tra phân loại dịch hại
            let matchesCategory = true;
            if (activeFilter === 'all') {
                matchesCategory = true;
            } else if (activeFilter.startsWith('pathogen:')) {
                const targetPathogen = activeFilter.replace('pathogen:', '');
                matchesCategory = (cardPathogen === targetPathogen);
            } else {
                matchesCategory = (cardFolderGroup === activeFilter);
            }

            // 3. Kiểm tra từ khóa tìm kiếm
            const matchesText = query === '' || searchCorpus.includes(query);

            if (matchesCrop && matchesCategory && matchesText) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Cập nhật 6 thẻ KPI trên banner theo cây trồng đang chọn
        const elTotal = document.getElementById('kpiStatTotal');
        if (elTotal) elTotal.textContent = cropTotal;
        const elNam = document.getElementById('kpiStatNam');
        if (elNam) elNam.textContent = cropNam;
        const elSauHai = document.getElementById('kpiStatSauHai');
        if (elSauHai) elSauHai.textContent = cropSauHai;
        const elVirus = document.getElementById('kpiStatVirus');
        if (elVirus) elVirus.textContent = cropVirus;
        const elTuyenTrung = document.getElementById('kpiStatTuyenTrung');
        if (elTuyenTrung) elTuyenTrung.textContent = cropTuyenTrung;
        const elViKhuan = document.getElementById('kpiStatViKhuan');
        if (elViKhuan) elViKhuan.textContent = cropViKhuan;

        // Cập nhật số đếm trong các option của dropdown phân loại dịch hại
        const sel = document.getElementById('selectDichHaiFilter');
        if (sel) {
            const optAll = sel.querySelector('option[value="all"]');
            if (optAll) optAll.textContent = `🌐 Toàn bộ dịch hại (${cropTotal})`;

            const optNam = sel.querySelector('option[value="nam_benh"]');
            if (optNam) optNam.textContent = `🍄 I. Nấm & Bệnh hại (${cropNamBenh})`;

            const optChichHut = sel.querySelector('option[value="chich_hut"]');
            if (optChichHut) optChichHut.textContent = `🦟 II. Côn trùng chích hút (${cropChichHut})`;

            const optSauHai = sel.querySelector('option[value="sau_hai"]');
            if (optSauHai) optSauHai.textContent = `🐛 III. Sâu cắn phá & Ruồi (${cropSauHaiGroup})`;

            const optNhen = sel.querySelector('option[value="nhen_tuyen_trung"]');
            if (optNhen) optNhen.textContent = `🕷️ IV. Nhện & Tuyến trùng (${cropNhenTuyenTrung})`;

            const optVirus = sel.querySelector('option[value="pathogen:virus"]');
            if (optVirus) optVirus.textContent = `🦠 Tác nhân Virus (${cropVirus})`;

            const optViKhuan = sel.querySelector('option[value="pathogen:vi_khuan"]');
            if (optViKhuan) optViKhuan.textContent = `🧪 Tác nhân Vi khuẩn & Tảo (${cropViKhuan})`;
        }

        const countDisplay = document.getElementById('countDisplay');
        if (countDisplay) {
            countDisplay.textContent = visibleCount;
        }

        const totalDisplay = document.getElementById('totalDisplay');
        if (totalDisplay) {
            totalDisplay.textContent = cropTotal;
        }

        const noRes = document.getElementById('noSearchResults');
        if (noRes) {
            noRes.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function capNhatSoLuongDropdown() {
        locDanhSachCards();
    }

    // Tự động khởi chạy lọc ngay khi trang tải xong
    document.addEventListener('DOMContentLoaded', function() {
        locDanhSachCards();
    });

    // Điều hướng trang to xem chi tiết bệnh toàn màn hình (Full page view)
    function xemChiTietBenh(id) {
        window.location.href = `/ky-su/benh-hai/${id}`;
    }

    // Modal Form (Thêm / Sửa)
    function moModalThemBenh() {
        document.getElementById('formDiseaseAjax').reset();
        document.getElementById('formDiseaseId').value = '';
        document.getElementById('modalFormTitle').textContent = '➕ Thêm Bệnh Cây Trồng Mới';
        document.getElementById('btnSubmitFormText').textContent = 'Lưu Bệnh Hại';
        document.getElementById('formCurrentImagesWrap').classList.add('hidden');
        document.getElementById('formCurrentImagesList').innerHTML = '';

        // Uncheck all pesticides & crops
        document.querySelectorAll('.chk-pesticide').forEach(c => c.checked = false);
        document.querySelectorAll('.chk-crop').forEach(c => c.checked = false);

        // Mặc định chọn cây hiện tại nếu đang chọn 1 cây cụ thể
        const curCrop = '{{ $selectedCrop }}';
        if (curCrop && curCrop !== 'all') {
            document.querySelectorAll('.chk-crop').forEach(c => {
                if (c.dataset.cropName === curCrop) c.checked = true;
            });
        }

        document.getElementById('modalFormBenh').classList.remove('hidden');
    }

    async function moModalSuaBenh(id) {
        try {
            const resp = await fetch(`/ajax/ky-su/benh/${id}`);
            const data = await resp.json();
            if (!data.success) throw new Error('Không tải được thông tin');

            const d = data.disease;
            document.getElementById('formDiseaseAjax').reset();
            document.getElementById('formDiseaseId').value = d.id;
            document.getElementById('modalFormTitle').textContent = `✏️ Chỉnh Sửa: ${d.name}`;
            document.getElementById('btnSubmitFormText').textContent = 'Cập Nhật Thay Đổi';

            document.getElementById('formName').value = d.name;
            document.getElementById('formCropName').value = d.crop_name || '';
            document.getElementById('formPathogenType').value = d.pathogen_type || 'nam';
            document.getElementById('formCaunho').value = d.caunho || '';

            // Check linked crops
            const cIds = d.crop_ids || [];
            document.querySelectorAll('.chk-crop').forEach(c => {
                const val = parseInt(c.value);
                c.checked = cIds.includes(val) || (d.crop_name && d.crop_name.includes(c.dataset.cropName));
            });

            document.getElementById('formPrevention').value = d.prevention || '';
            document.getElementById('formTreatment').value = d.treatment || '';
            document.getElementById('formChemicalGroups').value = d.chemical_groups || '';

            // Check linked pesticides
            const pIds = d.pesticide_ids || [];
            document.querySelectorAll('.chk-pesticide').forEach(c => {
                c.checked = pIds.includes(parseInt(c.value));
            });

            // Images list
            const imgWrap = document.getElementById('formCurrentImagesWrap');
            const imgList = document.getElementById('formCurrentImagesList');
            imgList.innerHTML = '';

            if (d.images && d.images.length > 0) {
                imgWrap.classList.remove('hidden');
                d.images.forEach(imgUrl => {
                    const wrap = document.createElement('div');
                    wrap.className = 'relative w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden group';
                    wrap.innerHTML = `
                        <img src="${imgUrl}" class="w-full h-full object-cover">
                        <button type="button"
                                onclick="xoaAnhBenh(${d.id}, '${imgUrl}', this)"
                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-90 hover:opacity-100"
                                title="Xóa ảnh này">✕</button>
                    `;
                    imgList.appendChild(wrap);
                });
            } else {
                imgWrap.classList.add('hidden');
            }

            document.getElementById('modalFormBenh').classList.remove('hidden');
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }

    function dongModalForm() {
        document.getElementById('modalFormBenh')?.classList.add('hidden');
    }

    // Xử lý gửi Form AJAX Thêm/Sửa
    async function xuLyLuuBenh(e) {
        e.preventDefault();
        const form = document.getElementById('formDiseaseAjax');
        const submitBtn = document.getElementById('btnSubmitForm');
        const diseaseId = document.getElementById('formDiseaseId').value;

        const checkedCrops = form.querySelectorAll('input[name="crop_ids[]"]:checked');
        if (checkedCrops.length === 0) {
            alert('Vui lòng chọn ít nhất 1 loại cây trồng có thể bị bệnh này gây hại!');
            return;
        }

        const formData = new FormData(form);
        const url = diseaseId ? `/ajax/ky-su/benh/${diseaseId}` : '/ajax/ky-su/benh';

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50');

        try {
            const resp = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const resData = await resp.json();
            if (!resp.ok) {
                const errMsg = resData.message || (resData.errors ? Object.values(resData.errors).flat().join('\n') : 'Lỗi xử lý');
                throw new Error(errMsg);
            }

            alert(resData.message || 'Thao tác thành công!');
            dongModalForm();
            window.location.reload(); // Tải lại để cập nhật thẻ cards
        } catch (err) {
            alert('Lỗi: ' + err.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50');
        }
    }

    // Xóa từng ảnh qua AJAX
    async function xoaAnhBenh(diseaseId, imgUrl, btnEl) {
        if (!confirm('Bạn có chắc muốn xóa ảnh này?')) return;

        try {
            const resp = await fetch(`/ajax/ky-su/benh/${diseaseId}/xoa-anh`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ image_url: imgUrl }),
            });

            const data = await resp.json();
            if (!data.success) throw new Error(data.message);

            btnEl.parentElement.remove();
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }

    // Xóa hoàn toàn một bệnh
    async function xacNhanXoaBenh(id, name) {
        if (!confirm(`Bạn có chắc chắn muốn xóa bệnh "${name}" khỏi cẩm nang?`)) return;

        try {
            const resp = await fetch(`/ajax/ky-su/benh/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await resp.json();
            if (!data.success) throw new Error(data.message);

            alert(data.message);
            const card = document.getElementById(`card-disease-${id}`);
            if (card) card.remove();
            capNhatSoLuongDropdown();
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }

    // Lightbox phóng to ảnh
    function moLightbox(url) {
        const lb = document.getElementById('modalLightboxAnh');
        const img = document.getElementById('lightboxImg');
        img.src = url;
        lb.classList.remove('hidden');
    }

    function dongLightbox() {
        document.getElementById('modalLightboxAnh')?.classList.add('hidden');
    }

    async function tuDongChonThuocTheoHoatChat(inputId) {
        const chemInput = document.getElementById(inputId);
        const chemText = chemInput ? chemInput.value.trim() : '';

        if (!chemText) {
            alert('Vui lòng nhập nhóm hoạt chất trước khi tự động tìm thuốc.');
            return;
        }

        try {
            const resp = await fetch('{{ route('engineer.benh.tim-thuoc-hoat-chat') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ chemical_groups: chemText }),
            });

            const data = await resp.json();
            if (!data.success) throw new Error('Không thể tìm kiếm thuốc.');

            const ids = data.pesticide_ids || [];
            let checkedCount = 0;

            document.querySelectorAll('#modalFormBenh .chk-pesticide').forEach(chk => {
                const val = parseInt(chk.value);
                if (ids.includes(val)) {
                    chk.checked = true;
                    checkedCount++;
                }
            });

            alert(`Đã tìm thấy và tự động tích chọn ${checkedCount} loại thuốc trong kho có cùng hoạt chất!`);
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }
</script>
</x-layouts.engineer>
