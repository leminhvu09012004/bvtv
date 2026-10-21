<x-layouts.engineer :title="$disease->name . ' — Phân Hệ Kỹ Sư BVTV'">
<div class="px-4 py-6 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

    <!-- 1. TOP NAV & BREADCRUMBS & ACTIONS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div class="flex items-center gap-2">
            <a href="{{ route('engineer.benh.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm border border-slate-200 shadow-2xs transition">
                <span>←</span>
                <span>Quay lại danh sách bệnh (Tất cả)</span>
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-xs font-semibold text-slate-500 truncate max-w-xs">{{ $disease->name }}</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('engineer.benh.edit', $disease->id) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-extrabold text-xs shadow-xs transition active:scale-95">
                <span>✏️</span>
                <span>Chỉnh Sửa Bệnh</span>
            </a>
            <button type="button"
                    onclick="xacNhanXoaBenhHienTai({{ $disease->id }}, '{{ addslashes($disease->name) }}')"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs border border-rose-200 transition">
                <span>🗑️</span>
                <span>Xóa Bệnh</span>
            </button>
        </div>
    </div>

    <!-- 2. HERO TITLE BANNER -->
    <div class="rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden border border-teal-700/50 relative"
         style="background: linear-gradient(135deg, #042f2e 0%, #064e3b 50%, #0f172a 100%) !important;">
        <div class="relative z-10 space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                @if($disease->folder_code)
                    <span class="px-3 py-1 rounded-xl text-xs font-black font-mono tracking-tight bg-teal-400/20 text-teal-200 border border-teal-300/40" title="Mã thư mục tra cứu">
                        📁 {{ $disease->folder_code }}
                    </span>
                @endif
                @if($disease->folder_name)
                    <span class="px-3 py-1 rounded-xl text-xs font-mono bg-white/10 text-slate-200 border border-white/20" title="Thư mục tài liệu máy tính">
                        📂 Thư mục: {{ $disease->folder_name }}
                    </span>
                @endif
                <span class="px-3 py-1 rounded-xl text-xs font-black uppercase tracking-wider border {{ $disease->pathogen_badge }}">
                    {{ $disease->pathogen_emoji }} {{ $disease->pathogen_label }}
                </span>
                @if($disease->crops && $disease->crops->isNotEmpty())
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="text-xs text-emerald-200/90 font-bold">CÂY MẪN CẢM:</span>
                        @foreach($disease->crops as $c)
                            <a href="{{ route('engineer.benh.index', ['crop' => $c->name]) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-extrabold bg-white/20 hover:bg-white/30 text-emerald-200 border border-white/25 transition">
                                <span>{{ $c->emoji }}</span> {{ $c->name }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-white/15 text-emerald-200 border border-white/20">
                        🌱 CÂY TRỒNG: {{ mb_strtoupper($disease->crop_name ?? 'Chanh dây') }}
                    </span>
                @endif
                <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-white/10 text-slate-200">
                    📸 {{ count($disease->images_urls) }} ảnh triệu chứng
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white drop-shadow-sm">
                {{ $disease->name }}
            </h1>

        </div>
    </div>

    <!-- 3. TOP ROW: THƯ VIỆN ẢNH & THÔNG TIN PHÒNG BỆNH CANH TÁC (2 CỘT CÂN ĐỐI) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- CỘT TRÁI (5 COLS - 42%): THƯ VIỆN HÌNH ẢNH MINH HỌA -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 flex-wrap gap-2">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                        <span>📸</span> THƯ VIỆN ẢNH TRIỆU CHỨNG ({{ count($disease->images_urls) }})
                    </h3>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('engineer.benh.edit', $disease->id) }}#cardQuanLyAnh" 
                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-800 font-extrabold text-[11px] border border-teal-200 transition"
                           title="Thêm hoặc xóa ảnh triệu chứng của bệnh này">
                            <span>⚙️</span> Quản lý ảnh (CRUD)
                        </a>
                        <span class="text-[11px] text-slate-400">Nhấp để phóng to</span>
                    </div>
                </div>

                <!-- Ảnh lớn hiển thị chính -->
                @php
                    $mainImage = $disease->images_urls[0] ?? null;
                @endphp
                <div class="relative w-full h-72 sm:h-80 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center group cursor-pointer shadow-inner"
                     id="mainDetailImageContainer"
                     onclick="moLightbox()">
                    @if($mainImage)
                        <img id="mainDetailImage" src="{{ $mainImage }}" alt="{{ $disease->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300 select-none">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-extrabold gap-1.5 backdrop-blur-2xs pointer-events-none">
                            <span>🔍 Phóng to toàn màn hình</span>
                        </div>
                        <button type="button" 
                                onclick="event.stopPropagation(); moLightbox()" 
                                class="absolute top-3 right-3 p-2 rounded-xl bg-black/60 hover:bg-black/80 text-white text-xs font-bold backdrop-blur-sm transition shadow-sm z-10"
                                title="Phóng to ảnh">
                            🔍
                        </button>
                    @else
                        <div class="text-center p-6 text-slate-400">
                            <span class="text-5xl block mb-2">{{ $disease->pathogen_emoji }}</span>
                            <span class="text-xs font-bold">Chưa có ảnh triệu chứng</span>
                        </div>
                    @endif
                </div>

                <!-- Lưới thumbnails ảnh phụ -->
                @if(count($disease->images_urls) > 1)
                    <div class="grid grid-cols-4 gap-2 pt-1" id="galleryThumbnailsContainer">
                        @foreach($disease->images_urls as $idx => $img)
                            <div class="thumbnail-item h-16 rounded-xl bg-slate-50 border overflow-hidden cursor-pointer hover:opacity-95 transition relative {{ $idx === 0 ? 'border-teal-500 ring-2 ring-teal-500 shadow-xs' : 'border-slate-200 hover:border-teal-400' }}"
                                 data-index="{{ $idx }}"
                                 onclick="chonAnhLon('{{ $img }}', {{ $idx }})">
                                <img src="{{ $img }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- GHI CHÚ KỸ THUẬT -->
            @if($disease->notes)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1 text-slate-600">
                    <div class="font-extrabold text-slate-800">📝 Ghi chú / Điều kiện phát sinh:</div>
                    <p class="leading-relaxed">{{ $disease->notes }}</p>
                </div>
            @endif
        </div>

        <!-- CỘT PHẢI (7 COLS - 58%): BIỆN PHÁP PHÒNG NGỪA & NGUYÊN TẮC ĐIỀU TRỊ CHUNG -->
        <div class="lg:col-span-7 space-y-6">
            <!-- BIỆN PHÁP PHÒNG BỆNH (SHIELD CARD) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-blue-200/80 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="text-xl">🛡️</span>
                    <h3 class="text-xs font-black uppercase tracking-wider text-blue-900">
                        BIỆN PHÁP PHÒNG NGỪA CANH TÁC & VỆ SINH VƯỜN
                    </h3>
                </div>
                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line font-medium pl-1">
                    {{ $disease->prevention ?: 'Chưa có thông tin phòng bệnh chi tiết.' }}
                </div>
            </div>

            <!-- NGUYÊN TẮC ĐIỀU TRỊ TỔNG QUAN -->
            @if($disease->treatment)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-emerald-200/80 space-y-3">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="text-xl">📋</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-emerald-900">
                            NGUYÊN TẮC & PHÁC ĐỒ ĐIỀU TRỊ TỔNG QUAN
                        </h3>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line font-medium pl-1">
                        {{ $disease->treatment }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- 4. LƯỚI HOẠT CHẤT & SẢN PHẨM THUỐC BVTV ĐẶC TRỊ TRONG KHO (FULL WIDTH RESPONSIVE GRID) -->
    @php
        $rawGroups = $disease->chemical_groups ? array_filter(array_map('trim', explode(',', $disease->chemical_groups))) : [];
        $allLinkedPesticides = $disease->pesticides;
        $matchedPesticideIds = [];
    @endphp

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-200/90 space-y-6">
        <!-- HEADER CỦA KHỐI LƯỚI ĐIỀU TRỊ -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl shadow-xs font-black shrink-0">
                    💊
                </span>
                <div>
                    <h3 class="text-sm sm:text-base font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <span>BIỆN PHÁP ĐIỀU TRỊ & THUỐC BVTV ĐẶC TRỊ</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        Phân loại theo cơ chế tác động FRAC — Hiển thị dạng lưới trực quan theo từng hoạt chất và sản phẩm trong kho
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <span class="px-3 py-1.5 rounded-xl bg-teal-50 text-teal-800 text-xs font-extrabold border border-teal-200">
                    {{ count($rawGroups) }} nhóm hoạt chất
                </span>
                <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200">
                    {{ $allLinkedPesticides->count() }} thuốc trong kho
                </span>
                <button type="button"
                        onclick="tuDongDongBoThuocChiTiet({{ $disease->id }})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-xs transition active:scale-95"
                        title="Tự động quét kho và gắn toàn bộ thuốc có cùng hoạt chất khuyến cáo">
                    <span>⚡ Quét & gắn thuốc</span>
                </button>
                <button type="button"
                        onclick="moModalGanThuocTuKho()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-extrabold text-xs border border-emerald-300 shadow-2xs transition active:scale-95"
                        title="Mở bảng tra cứu kho và chọn gắn thêm thuốc đặc trị vào bệnh này">
                    <span>➕ Gắn thuốc từ kho</span>
                </button>
                <a href="{{ route('phoi-tron.index') }}" 
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 transition">
                    <span>🧪 Tank-mix</span> ↗
                </a>
            </div>
        </div>

        <!-- THANH TÌM KIẾM & BỘ LỌC TỨC THÌ (REAL-TIME SEARCH & FILTER) -->
        <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 shadow-inner">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                    🔍
                </span>
                <input type="text"
                       id="searchTreatmentInput"
                       oninput="locThuocVaHoatChatDieuTri()"
                       placeholder="Tìm kiếm nhanh: tên thuốc (vd: Anvil, Validacin), hoạt chất (vd: Azoxystrobin), mã nhóm FRAC/IRAC..."
                       class="w-full pl-10 pr-9 py-2 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs placeholder:text-slate-400">
                <button type="button"
                        id="clearTreatmentSearchBtn"
                        onclick="xoaTimKiemDieuTri()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition hidden text-xs font-bold"
                        title="Xóa tìm kiếm">
                    ✕
                </button>
            </div>

            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                <button type="button"
                        id="btnFilterAll"
                        onclick="locTheoTrangThai('all')"
                        class="filter-chip px-3 py-1.5 rounded-xl text-xs font-bold transition bg-teal-600 text-white shadow-2xs">
                    Tất cả (<span id="countTotalItems">{{ count($rawGroups) }}</span>)
                </button>
                <button type="button"
                        id="btnFilterHasStock"
                        onclick="locTheoTrangThai('has_stock')"
                        class="filter-chip px-3 py-1.5 rounded-xl text-xs font-bold transition bg-white text-slate-600 border border-slate-200 hover:bg-slate-100">
                    🟢 Có thuốc trong kho (<span id="countHasStock">0</span>)
                </button>
                <button type="button"
                        id="btnFilterNoStock"
                        onclick="locTheoTrangThai('no_stock')"
                        class="filter-chip px-3 py-1.5 rounded-xl text-xs font-bold transition bg-white text-slate-600 border border-slate-200 hover:bg-slate-100">
                    ⚪ Chưa có thuốc (<span id="countNoStock">0</span>)
                </button>
            </div>
        </div>

        <!-- THÔNG BÁO KHÔNG TÌM THẤY KẾT QUẢ (EMPTY SEARCH STATE) -->
        <div id="emptySearchTreatmentState" class="hidden p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-300 space-y-3">
            <span class="text-3xl block">🔍</span>
            <div class="text-xs font-bold text-slate-700">
                Không tìm thấy hoạt chất hoặc thuốc nào khớp với từ khóa "<span id="txtSearchKeyword" class="text-teal-700"></span>"
            </div>
            <button type="button"
                    onclick="xoaTimKiemDieuTri()"
                    class="px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs transition shadow-2xs">
                Đặt lại bộ lọc
            </button>
        </div>

        @if(!empty($rawGroups))
            <!-- LƯỚI ĐA CỘT CHO CÁC NHÓM HOẠT CHẤT & SẢN PHẨM TRONG KHO (GRID RESPONSIVE 1/2/3 CỘT) -->
            <div class="space-y-3" id="blockGridHoatChat">
                <div class="text-xs font-black uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <span>⚗️</span> HOẠT CHẤT TRỊ BỆNH & SẢN PHẨM TƯƠNG ỨNG TRONG KHO:
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 items-stretch" id="gridHoatChatContainer">
                    @foreach($rawGroups as $groupItem)
                        @php
                            $hasTag = preg_match('/^(.*?)\s*\((.*?)\)$/', $groupItem, $matches);
                            $chemName = $hasTag ? trim($matches[1]) : $groupItem;
                            $chemTag = $hasTag ? trim($matches[2]) : null;
                            $searchKeyword = trim(explode('/', $chemName)[0]);

                            // Tách các từ khóa con (ví dụ "Metalaxyl-M / Mefenoxam" -> ["Metalaxyl-M", "Mefenoxam"])
                            $subKeywords = array_filter(array_map('trim', explode('/', $chemName)));

                            // Lọc các thuốc trong kho liên kết có chứa hoạt chất này
                            $matchedForThisChem = $allLinkedPesticides->filter(function($p) use ($subKeywords, $chemName) {
                                if (!$p->active_ingredient && !$p->name) return false;
                                $targetStr = ($p->active_ingredient . ' ' . $p->name);
                                foreach ($subKeywords as $kw) {
                                    $cleanKw = preg_replace('/[^a-zA-Z0-9]/', '', $kw);
                                    $cleanTarget = preg_replace('/[^a-zA-Z0-9]/', '', $targetStr);
                                    if (!empty($cleanKw) && stripos($cleanTarget, $cleanKw) !== false) {
                                        return true;
                                    }
                                    if (stripos($targetStr, $kw) !== false) {
                                        return true;
                                    }
                                }
                                return false;
                            });

                            foreach ($matchedForThisChem as $mp) {
                                $matchedPesticideIds[] = $mp->id;
                            }

                            $chemPesticidesStr = $matchedForThisChem->map(fn($p) => $p->name . ' ' . $p->active_ingredient . ' ' . ($p->category->name ?? ''))->implode(' ');
                        @endphp

                        <!-- CARD NHÓM HOẠT CHẤT TRONG LƯỚI -->
                        <div class="chem-group-card rounded-2xl border border-teal-200/90 bg-gradient-to-b from-teal-50/40 via-white to-slate-50/30 p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-teal-400 transition space-y-3"
                             data-chem-name="{{ mb_strtolower($chemName) }}"
                             data-chem-tag="{{ mb_strtolower($chemTag ?? '') }}"
                             data-has-stock="{{ $matchedForThisChem->isNotEmpty() ? '1' : '0' }}"
                             data-pesticides="{{ mb_strtolower($chemPesticidesStr) }}">
                            <div>
                                <!-- Header hoạt chất -->
                                <div class="flex items-start justify-between gap-3 pb-2.5 border-b border-teal-100">
                                    <div class="flex-1 min-w-0 space-y-1">
                                        <div class="flex items-start gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-teal-600 shadow-xs shrink-0 mt-1"></span>
                                            <div class="flex-1 min-w-0 space-y-1">
                                                <h4 class="text-sm font-black text-slate-900 tracking-tight leading-snug break-words">
                                                    {{ $chemName }}
                                                </h4>
                                                @if($chemTag)
                                                    <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-black font-mono tracking-tight bg-teal-100 text-teal-800 border border-teal-200">
                                                        {{ $chemTag }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="pl-4.5">
                                            <a href="{{ route('thuoc.tra-cuu', ['q' => $searchKeyword]) }}"
                                               target="_blank"
                                               class="text-[11px] font-bold text-teal-700 hover:text-teal-900 hover:underline inline-flex items-center gap-0.5"
                                               title="Tra cứu danh mục toàn quốc">
                                                Tra cứu thị trường ↗
                                            </a>
                                        </div>
                                    </div>

                                    <div class="shrink-0 whitespace-nowrap pt-0.5">
                                        @if($matchedForThisChem->isNotEmpty())
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs whitespace-nowrap">
                                                <span>✓</span> Có {{ $matchedForThisChem->count() }} SP
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap">
                                                Chưa có SP
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Danh sách các sản phẩm thuốc trong kho chứa hoạt chất này -->
                                <div class="pt-3 space-y-2">
                                    @if($matchedForThisChem->isNotEmpty())
                                        @foreach($matchedForThisChem as $p)
                                            <div class="chem-pesticide-item p-2.5 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-teal-400 hover:shadow-xs transition flex items-start gap-2.5"
                                                 data-pesticide-name="{{ mb_strtolower($p->name) }}"
                                                 data-pesticide-ingr="{{ mb_strtolower($p->active_ingredient ?: '') }}"
                                                 data-pesticide-cat="{{ mb_strtolower($p->category?->name ?? '') }}">
                                                <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 shrink-0 overflow-hidden flex items-center justify-center p-1">
                                                    @if($p->image_url)
                                                        <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="max-w-full max-h-full object-contain">
                                                    @else
                                                        <span class="text-base">💊</span>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0 space-y-0.5">
                                                    <div class="flex items-center gap-1 flex-wrap">
                                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-slate-100 text-slate-700">
                                                            {{ $p->category?->name ?? 'Thuốc BVTV' }}
                                                        </span>
                                                        @if($p->form_type)
                                                            <span class="text-[9px] font-black px-1.5 py-0.2 rounded bg-amber-100 text-amber-800">
                                                                {{ $p->form_type }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <h5 class="text-xs font-black text-slate-900 truncate" title="{{ $p->name }}">
                                                        {{ $p->name }}
                                                    </h5>
                                                    <div class="text-[11px] text-slate-500 truncate" title="{{ $p->active_ingredient }}">
                                                        <strong class="text-emerald-800 font-bold">{{ $p->active_ingredient ?: '—' }}</strong>
                                                    </div>
                                                    @if($p->water_volume)
                                                        <div class="text-[10px] text-teal-700 font-bold flex items-center gap-1">
                                                            <span>💧 Liều:</span> <span>{{ $p->water_volume }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="shrink-0 pt-0.5">
                                                    <a href="{{ route('phoi-tron.index', ['pesticide_id' => $p->id]) }}"
                                                       class="p-1 rounded-lg bg-slate-100 hover:bg-teal-600 hover:text-white text-slate-500 border border-slate-200 shadow-2xs transition inline-flex items-center justify-center text-xs"
                                                       title="Đưa vào bàn kiểm tra kỵ phối trộn">
                                                        🚫
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="chem-no-stock-notice p-3 rounded-xl bg-slate-50/80 border border-dashed border-slate-200 text-slate-500 text-[11px] space-y-1.5">
                                            <div>Kho hiện chưa có thuốc thương phẩm chứa hoạt chất này.</div>
                                            <a href="{{ route('thuoc.tra-cuu', ['q' => $searchKeyword]) }}"
                                               target="_blank"
                                               class="inline-block px-2 py-0.5 rounded-lg bg-white border border-teal-200 text-teal-700 font-bold hover:bg-teal-50 transition shadow-2xs text-[10px]">
                                                Tra cứu sản phẩm thị trường ↗
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @php
            $unmatchedPesticides = $allLinkedPesticides->whereNotIn('id', array_unique($matchedPesticideIds));
        @endphp

        <!-- Sản phẩm phối hợp hoặc đặc trị khác trong kho (nếu có) -->
        @if($unmatchedPesticides->isNotEmpty())
            <div class="pt-4 border-t border-slate-200 space-y-3" id="blockUnmatchedPesticides">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                        <span>📦</span> SẢN PHẨM ĐẶC TRỊ PHỐI HỢP KHÁC TRONG KHO ({{ $unmatchedPesticides->count() }})
                    </h4>
                    <span class="text-[11px] text-slate-500 font-medium">Đã gắn vào bệnh</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="gridUnmatchedContainer">
                    @foreach($unmatchedPesticides as $p)
                        <div class="unmatched-pesticide-card p-3 rounded-xl bg-white border border-slate-200/90 shadow-2xs hover:border-teal-400 hover:shadow-xs transition flex items-start gap-3"
                             data-pesticide-name="{{ mb_strtolower($p->name) }}"
                             data-pesticide-ingr="{{ mb_strtolower($p->active_ingredient ?: '') }}"
                             data-pesticide-cat="{{ mb_strtolower($p->category?->name ?? '') }}">
                            <div class="w-11 h-11 rounded-lg bg-slate-50 border border-slate-200 shrink-0 overflow-hidden flex items-center justify-center p-1">
                                @if($p->image_url)
                                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-lg">💊</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 space-y-0.5">
                                <div class="flex items-center gap-1 flex-wrap">
                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-slate-100 text-slate-700">
                                        {{ $p->category?->name ?? 'Thuốc BVTV' }}
                                    </span>
                                    @if($p->form_type)
                                        <span class="text-[9px] font-black px-1.5 py-0.2 rounded bg-amber-100 text-amber-800">
                                            {{ $p->form_type }}
                                        </span>
                                    @endif
                                </div>
                                <h5 class="text-xs font-black text-slate-900 truncate" title="{{ $p->name }}">
                                    {{ $p->name }}
                                </h5>
                                <div class="text-[11px] text-slate-500 truncate" title="{{ $p->active_ingredient }}">
                                    <strong class="text-emerald-800 font-bold">{{ $p->active_ingredient ?: '—' }}</strong>
                                </div>
                                @if($p->water_volume)
                                    <div class="text-[10px] text-teal-700 font-bold flex items-center gap-1">
                                        <span>💧 Liều:</span> <span>{{ $p->water_volume }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="shrink-0 pt-0.5">
                                <a href="{{ route('phoi-tron.index', ['pesticide_id' => $p->id]) }}"
                                   class="p-1.5 rounded-lg bg-slate-100 hover:bg-teal-600 hover:text-white text-slate-500 border border-slate-200 shadow-2xs transition inline-flex items-center justify-center text-xs"
                                   title="Đưa vào bàn kiểm tra kỵ phối trộn">
                                    🚫
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endif

        @if(empty($rawGroups) && $allLinkedPesticides->isEmpty())
            <div class="p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-300 text-slate-400 text-xs space-y-2">
                <div>Chưa có thông tin hoạt chất khuyến cáo hoặc thuốc BVTV trong kho cho bệnh này.</div>
                <a href="{{ route('engineer.benh.edit', $disease->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-teal-600 text-white font-bold text-xs hover:bg-teal-700 transition shadow-xs">
                    <span>✏️ Cập nhật hoạt chất & thuốc ngay</span>
                </a>
            </div>
        @endif

        <!-- Chú thích / Mẹo luân phiên FRAC -->
        <div class="p-4 rounded-2xl bg-teal-50/60 border border-teal-200/60 flex items-start gap-2.5 text-[11px] text-teal-900 font-medium">
            <span class="text-sm shrink-0">💡</span>
            <span>
                <strong>Mẹo luân phiên chuyên môn:</strong> Tuyệt đối không luân phiên các hoạt chất có cùng mã nhóm FRAC giữa các lần phun liên tiếp để chống hiện tượng kháng thuốc chéo. Bấm nút <strong>🚫</strong> để chuyển thuốc sang bàn kiểm tra kỵ phối trộn trước khi tank-mix.
            </span>
        </div>
    </div>

</div>

<!-- MODAL PHÓNG TO ẢNH (LIGHTBOX) -->
<div id="modalLightboxAnh" 
     class="fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/95 backdrop-blur-md hidden transition-opacity z-[9999]" 
     style="z-index: 99999;"
     onclick="if(event.target===this)dongLightbox()">
    <div class="relative max-w-5xl w-full max-h-[95vh] flex flex-col items-center select-none" onclick="event.stopPropagation()">
        <!-- Thanh điều khiển phía trên ảnh -->
        <div class="w-full flex items-center justify-between pb-2.5 text-white">
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-xs font-bold border border-white/20 tracking-wide" id="lightboxCounter">
                    Ảnh 1 / {{ count($disease->images_urls) }}
                </span>
                <span class="text-xs text-slate-300 font-semibold truncate max-w-xs sm:max-w-md">
                    {{ $disease->name }}
                </span>
            </div>
            <button type="button" 
                    onclick="dongLightbox()" 
                    class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-rose-600 text-white text-xs font-black transition flex items-center gap-1.5 border border-white/20 cursor-pointer shadow-sm">
                <span>✕</span> Đóng (Esc)
            </button>
        </div>

        <!-- Khung ảnh chính và các nút Previous / Next -->
        <div class="relative w-full flex items-center justify-center">
            @if(count($disease->images_urls) > 1)
                <!-- Nút Prev -->
                <button type="button" 
                        onclick="chuyenAnhLightbox(-1)" 
                        class="absolute left-2 sm:-left-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/75 hover:bg-teal-600 text-white font-black text-2xl flex items-center justify-center shadow-xl border border-white/25 transition z-30 cursor-pointer active:scale-95"
                        title="Ảnh trước (Mũi tên trái)">
                    ‹
                </button>
            @endif

            <img id="lightboxImg" 
                 src="" 
                 alt="{{ $disease->name }}" 
                 class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl object-contain border border-white/15 bg-slate-950/60 transition-all duration-200">

            @if(count($disease->images_urls) > 1)
                <!-- Nút Next -->
                <button type="button" 
                        onclick="chuyenAnhLightbox(1)" 
                        class="absolute right-2 sm:-right-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/75 hover:bg-teal-600 text-white font-black text-2xl flex items-center justify-center shadow-xl border border-white/25 transition z-30 cursor-pointer active:scale-95"
                        title="Ảnh tiếp theo (Mũi tên phải)">
                    ›
                </button>
            @endif
        </div>
    </div>

<!-- MODAL GẮN THUỐC TỪ KHO VÀO BỆNH LÝ -->
<div id="modalGanThuocTuKho"
     class="fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-slate-900/70 backdrop-blur-sm hidden transition-opacity z-[999]"
     style="z-index: 9999;"
     onclick="if(event.target===this)dongModalGanThuocTuKho()">
    <div class="relative max-w-2xl w-full max-h-[90vh] bg-white rounded-3xl shadow-2xl flex flex-col border border-slate-200 overflow-hidden"
         onclick="event.stopPropagation()">
        
        <!-- Header modal -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-teal-50/50 to-white">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-lg font-black shrink-0">
                    📦
                </span>
                <div>
                    <h3 class="text-sm sm:text-base font-black text-slate-900 tracking-tight">
                        Gắn Thuốc BVTV Từ Kho Vào Bệnh Lý
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        Chọn các thuốc thương phẩm trong kho để đưa vào phác đồ điều trị
                    </p>
                </div>
            </div>
            <button type="button"
                    onclick="dongModalGanThuocTuKho()"
                    class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition text-sm font-bold">
                ✕
            </button>
        </div>

        <!-- Ô tìm kiếm thuốc trong kho -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/70 space-y-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    🔍
                </span>
                <input type="text"
                       id="inputSearchModalGanThuoc"
                       oninput="locThuocTrongModalGan()"
                       placeholder="Tìm nhanh: tên thuốc (vd: Validacin, Anvil), hoạt chất..."
                       class="w-full pl-9 pr-9 py-2 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs">
                <button type="button"
                        id="btnClearSearchModalGan"
                        onclick="document.getElementById('inputSearchModalGanThuoc').value='';locThuocTrongModalGan();"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition hidden text-xs font-bold">
                    ✕
                </button>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500">
                <div>
                    Đã chọn: <strong class="text-teal-700 font-black" id="txtCountModalSelected">0</strong> / {{ count($warehousePesticides) }} sản phẩm
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="chonTatCaModalGan(true)" class="text-teal-700 hover:underline font-bold text-[11px]">Chọn tất cả</button>
                    <span>•</span>
                    <button type="button" onclick="chonTatCaModalGan(false)" class="text-rose-600 hover:underline font-bold text-[11px]">Bỏ chọn hết</button>
                </div>
            </div>
        </div>

        <!-- Danh sách checkbox thuốc trong kho (Scrollable) -->
        <div class="p-4 overflow-y-auto flex-1 space-y-2 max-h-[50vh] scrollbar-thin" id="listPesticidesModalContainer">
            @php
                $linkedPesticideIds = $disease->pesticides->pluck('id')->toArray();
            @endphp
            @foreach($warehousePesticides as $wp)
                <label class="modal-pesticide-item flex items-center gap-3 p-3 rounded-2xl border border-slate-200/90 bg-white hover:bg-teal-50/40 hover:border-teal-300 transition cursor-pointer select-none shadow-2xs"
                       data-search="{{ mb_strtolower($wp->name . ' ' . ($wp->active_ingredient ?? '') . ' ' . ($wp->category->name ?? '')) }}">
                    <input type="checkbox"
                           name="modal_pesticide_ids[]"
                           value="{{ $wp->id }}"
                           onchange="capNhatSoLuongModalChon()"
                           {{ in_array($wp->id, $linkedPesticideIds) ? 'checked' : '' }}
                           class="chk-modal-pesticide w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <div class="w-9 h-9 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden p-0.5">
                        @if($wp->image_url)
                            <img src="{{ $wp->image_url }}" alt="{{ $wp->name }}" class="max-w-full max-h-full object-contain">
                        @else
                            <span class="text-base">💊</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-xs font-black text-slate-900 truncate">{{ $wp->name }}</span>
                            @if($wp->category)
                                <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-slate-100 text-slate-600">
                                    {{ $wp->category->name }}
                                </span>
                            @endif
                            @if($wp->form_type)
                                <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-amber-100 text-amber-800">
                                    {{ $wp->form_type }}
                                </span>
                            @endif
                        </div>
                        <div class="text-[11px] text-teal-800 font-semibold truncate">
                            {{ $wp->active_ingredient ?: 'Chưa rõ hoạt chất' }}
                        </div>
                    </div>
                </label>
            @endforeach
            <div id="emptyModalSearchResult" class="hidden p-6 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                Không tìm thấy thuốc nào khớp với từ khóa tìm kiếm.
            </div>
        </div>

        <!-- Footer modal -->
        <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-3">
            <button type="button"
                    onclick="dongModalGanThuocTuKho()"
                    class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 transition">
                Hủy bỏ
            </button>
            <button type="button"
                    id="btnLuuGanThuocModal"
                    onclick="luuGanThuocTuKho({{ $disease->id }})"
                    class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-xs transition flex items-center gap-1.5">
                <span>💾</span> Lưu liên kết thuốc
            </button>
        </div>
    </div>
</div>

<script>
    // Hàm chuẩn hóa chuỗi tiếng Việt không dấu phục vụ tìm kiếm tức thì
    function xoaDauTiengViet(str) {
        if (!str) return '';
        return str.toString().toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[đĐ]/g, 'd')
            .trim();
    }
    // Dữ liệu ảnh phục vụ Gallery & Lightbox
    const danhSachAnhChiTiet = @json($disease->images_urls ?? []);
    let chiSoAnhHienTai = 0;

    function capNhatViTriAnh(idx) {
        if (!danhSachAnhChiTiet || danhSachAnhChiTiet.length === 0) return;
        if (idx < 0) idx = danhSachAnhChiTiet.length - 1;
        if (idx >= danhSachAnhChiTiet.length) idx = 0;
        chiSoAnhHienTai = idx;

        const targetUrl = danhSachAnhChiTiet[idx];

        // 1. Cập nhật ảnh chính
        const mainImg = document.getElementById('mainDetailImage');
        if (mainImg) mainImg.src = targetUrl;

        // 2. Cập nhật active ring trên danh sách thumbnails
        document.querySelectorAll('.thumbnail-item').forEach(el => {
            const elIdx = parseInt(el.dataset.index);
            if (elIdx === idx) {
                el.className = 'thumbnail-item h-16 rounded-xl bg-slate-50 border border-teal-500 ring-2 ring-teal-500 shadow-xs overflow-hidden cursor-pointer transition relative';
            } else {
                el.className = 'thumbnail-item h-16 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-400 overflow-hidden cursor-pointer transition relative';
            }
        });

        // 3. Cập nhật nếu Lightbox đang mở
        const lbImg = document.getElementById('lightboxImg');
        const lbCounter = document.getElementById('lightboxCounter');
        if (lbImg) lbImg.src = targetUrl;
        if (lbCounter) lbCounter.textContent = `Ảnh ${idx + 1} / ${danhSachAnhChiTiet.length}`;
    }

    function chonAnhLon(url, idx) {
        capNhatViTriAnh(typeof idx === 'number' ? idx : danhSachAnhChiTiet.indexOf(url));
    }

    function moLightbox(url) {
        if (danhSachAnhChiTiet && danhSachAnhChiTiet.length > 0) {
            let idx = chiSoAnhHienTai;
            if (url) {
                const foundIdx = danhSachAnhChiTiet.indexOf(url);
                if (foundIdx !== -1) idx = foundIdx;
            }
            capNhatViTriAnh(idx);
        } else {
            const mainImg = document.getElementById('mainDetailImage');
            const targetUrl = url || (mainImg ? mainImg.src : null);
            if (!targetUrl) return;
            const lbImg = document.getElementById('lightboxImg');
            if (lbImg) lbImg.src = targetUrl;
        }

        const lb = document.getElementById('modalLightboxAnh');
        if (lb) lb.classList.remove('hidden');
    }

    function dongLightbox() {
        const lb = document.getElementById('modalLightboxAnh');
        if (lb) lb.classList.add('hidden');
    }

    function chuyenAnhLightbox(huong) {
        capNhatViTriAnh(chiSoAnhHienTai + huong);
    }

    // Lắng nghe phím tắt bàn phím (Esc để đóng, Trái/Phải để chuyển ảnh)
    document.addEventListener('keydown', function(e) {
        const lb = document.getElementById('modalLightboxAnh');
        if (lb && !lb.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                dongLightbox();
            } else if (e.key === 'ArrowLeft') {
                chuyenAnhLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                chuyenAnhLightbox(1);
            }
        }
    });

    async function xacNhanXoaBenhHienTai(id, name) {
        if (!confirm(`Bạn có chắc chắn muốn xóa bệnh "${name}"? Thao tác này không thể hoàn tác.`)) return;

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
            window.location.href = '{{ route('engineer.benh.index') }}';
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }

    async function tuDongDongBoThuocChiTiet(id) {
        if (!confirm('Hệ thống sẽ quét kho và tự động gắn tất cả các loại thuốc có cùng hoạt chất gợi ý vào danh sách đặc trị của bệnh này. Tiếp tục?')) return;

        try {
            const resp = await fetch(`/ajax/ky-su/benh/${id}/auto-sync-thuoc`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            const data = await resp.json();
            if (!data.success) throw new Error(data.message);

            alert(data.message);
            window.location.reload();
        } catch (err) {
            alert('Lỗi: ' + err.message);
        }
    }

    /* ========================================================
     * BỘ LỌC TỨC THÌ (REAL-TIME LIVE SEARCH) CHO KHỐI ĐIỀU TRỊ
     * ======================================================== */
    let trangThaiDieuTriHienTai = 'all';

    function locTheoTrangThai(status) {
        trangThaiDieuTriHienTai = status;
        
        const btnAll = document.getElementById('btnFilterAll');
        const btnHas = document.getElementById('btnFilterHasStock');
        const btnNo = document.getElementById('btnFilterNoStock');
        
        const activeClasses = ['bg-teal-600', 'text-white', 'shadow-2xs'];
        const inactiveClasses = ['bg-white', 'text-slate-600', 'border', 'border-slate-200', 'hover:bg-slate-100'];

        [btnAll, btnHas, btnNo].forEach(btn => {
            if (!btn) return;
            btn.classList.remove(...activeClasses);
            btn.classList.add(...inactiveClasses);
        });

        const targetBtn = status === 'all' ? btnAll : (status === 'has_stock' ? btnHas : btnNo);
        if (targetBtn) {
            targetBtn.classList.remove(...inactiveClasses);
            targetBtn.classList.add(...activeClasses);
        }

        locThuocVaHoatChatDieuTri();
    }

    function locThuocVaHoatChatDieuTri() {
        const input = document.getElementById('searchTreatmentInput');
        const rawVal = input ? input.value.trim() : '';
        const q = xoaDauTiengViet(rawVal);

        const clearBtn = document.getElementById('clearTreatmentSearchBtn');
        if (clearBtn) clearBtn.classList.toggle('hidden', rawVal === '');

        let visibleChemCards = 0;
        let visibleUnmatchedCards = 0;

        // 1. Lọc các thẻ nhóm hoạt chất
        const chemCards = document.querySelectorAll('.chem-group-card');
        chemCards.forEach(card => {
            const hasStock = card.dataset.hasStock === '1';
            
            // Kiểm tra điều kiện tab trạng thái
            let passStatus = true;
            if (trangThaiDieuTriHienTai === 'has_stock' && !hasStock) passStatus = false;
            if (trangThaiDieuTriHienTai === 'no_stock' && hasStock) passStatus = false;

            if (!passStatus) {
                card.classList.add('hidden');
                return;
            }

            // Kiểm tra từ khóa tìm kiếm
            if (!q) {
                card.classList.remove('hidden');
                visibleChemCards++;
                card.querySelectorAll('.chem-pesticide-item').forEach(p => p.classList.remove('hidden'));
                return;
            }

            const chemName = xoaDauTiengViet(card.dataset.chemName || '');
            const chemTag = xoaDauTiengViet(card.dataset.chemTag || '');
            const chemPesticides = xoaDauTiengViet(card.dataset.pesticides || '');
            const allText = chemName + ' ' + chemTag + ' ' + chemPesticides;

            if (allText.includes(q)) {
                card.classList.remove('hidden');
                visibleChemCards++;

                // Lọc chi tiết các sản phẩm con bên trong
                card.querySelectorAll('.chem-pesticide-item').forEach(p => {
                    const pName = xoaDauTiengViet(p.dataset.pesticideName || '');
                    const pIngr = xoaDauTiengViet(p.dataset.pesticideIngr || '');
                    const pCat = xoaDauTiengViet(p.dataset.pesticideCat || '');
                    const pText = pName + ' ' + pIngr + ' ' + pCat;

                    if (chemName.includes(q) || chemTag.includes(q) || pText.includes(q)) {
                        p.classList.remove('hidden');
                    } else {
                        p.classList.add('hidden');
                    }
                });
            } else {
                card.classList.add('hidden');
            }
        });

        // 2. Lọc các thẻ thuốc unmatched (sản phẩm đặc trị khác)
        const unmatchedCards = document.querySelectorAll('.unmatched-pesticide-card');
        unmatchedCards.forEach(card => {
            if (trangThaiDieuTriHienTai === 'no_stock') {
                card.classList.add('hidden');
                return;
            }

            if (!q) {
                card.classList.remove('hidden');
                visibleUnmatchedCards++;
                return;
            }

            const pName = xoaDauTiengViet(card.dataset.pesticideName || '');
            const pIngr = xoaDauTiengViet(card.dataset.pesticideIngr || '');
            const pCat = xoaDauTiengViet(card.dataset.pesticideCat || '');
            const pText = pName + ' ' + pIngr + ' ' + pCat;

            if (pText.includes(q)) {
                card.classList.remove('hidden');
                visibleUnmatchedCards++;
            } else {
                card.classList.add('hidden');
            }
        });

        // 3. Ẩn/hiện khối container
        const blockGridHoatChat = document.getElementById('blockGridHoatChat');
        if (blockGridHoatChat) {
            blockGridHoatChat.classList.toggle('hidden', visibleChemCards === 0);
        }

        const blockUnmatched = document.getElementById('blockUnmatchedPesticides');
        if (blockUnmatched) {
            blockUnmatched.classList.toggle('hidden', visibleUnmatchedCards === 0);
        }

        // 4. Trạng thái rỗng
        const emptyState = document.getElementById('emptySearchTreatmentState');
        const txtKw = document.getElementById('txtSearchKeyword');
        const totalVisible = visibleChemCards + visibleUnmatchedCards;

        if (emptyState) {
            if (totalVisible === 0) {
                emptyState.classList.remove('hidden');
                if (txtKw) txtKw.textContent = rawVal || (trangThaiDieuTriHienTai === 'has_stock' ? 'Có thuốc trong kho' : 'Chưa có thuốc');
            } else {
                emptyState.classList.add('hidden');
            }
        }
    }

    function xoaTimKiemDieuTri() {
        const input = document.getElementById('searchTreatmentInput');
        if (input) {
            input.value = '';
            input.focus();
        }
        locTheoTrangThai('all');
    }

    function capNhatSoLuongLoc() {
        const chemCards = document.querySelectorAll('.chem-group-card');
        let hasStock = 0;
        let noStock = 0;
        chemCards.forEach(c => {
            if (c.dataset.hasStock === '1') hasStock++;
            else noStock++;
        });

        const elTotal = document.getElementById('countTotalItems');
        const elHas = document.getElementById('countHasStock');
        const elNo = document.getElementById('countNoStock');

        if (elTotal) elTotal.textContent = chemCards.length;
        if (elHas) elHas.textContent = hasStock;
        if (elNo) elNo.textContent = noStock;
    }

    /* ========================================================
     * QUẢN LÝ MODAL GẮN THUỐC TỪ KHO VÀO BỆNH LÝ
     * ======================================================== */
    function moModalGanThuocTuKho() {
        const m = document.getElementById('modalGanThuocTuKho');
        if (m) {
            m.classList.remove('hidden');
            capNhatSoLuongModalChon();
            setTimeout(() => {
                const inp = document.getElementById('inputSearchModalGanThuoc');
                if (inp) inp.focus();
            }, 60);
        }
    }

    function dongModalGanThuocTuKho() {
        const m = document.getElementById('modalGanThuocTuKho');
        if (m) m.classList.add('hidden');
    }

    function locThuocTrongModalGan() {
        const input = document.getElementById('inputSearchModalGanThuoc');
        const raw = input ? input.value.trim() : '';
        const q = xoaDauTiengViet(raw);
        const clearBtn = document.getElementById('btnClearSearchModalGan');
        if (clearBtn) clearBtn.classList.toggle('hidden', raw === '');

        let visibleCount = 0;
        document.querySelectorAll('.modal-pesticide-item').forEach(item => {
            const searchStr = xoaDauTiengViet(item.dataset.search || '');
            const match = !q || searchStr.includes(q);
            item.classList.toggle('hidden', !match);
            if (match) visibleCount++;
        });

        const emptyNotice = document.getElementById('emptyModalSearchResult');
        if (emptyNotice) emptyNotice.classList.toggle('hidden', visibleCount > 0);
    }

    function capNhatSoLuongModalChon() {
        const count = document.querySelectorAll('.chk-modal-pesticide:checked').length;
        const badge = document.getElementById('txtCountModalSelected');
        if (badge) badge.textContent = count;
    }

    function chonTatCaModalGan(status) {
        document.querySelectorAll('.modal-pesticide-item:not(.hidden) .chk-modal-pesticide').forEach(cb => {
            cb.checked = status;
        });
        capNhatSoLuongModalChon();
    }

    async function luuGanThuocTuKho(diseaseId) {
        const btn = document.getElementById('btnLuuGanThuocModal');
        const checked = Array.from(document.querySelectorAll('.chk-modal-pesticide:checked')).map(cb => parseInt(cb.value));
        
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>⏳</span> Đang lưu...';
        }

        try {
            const resp = await fetch(`/ajax/ky-su/benh/${diseaseId}/gan-thuoc`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ pesticide_ids: checked }),
            });

            const data = await resp.json();
            if (!data.success) throw new Error(data.message || 'Lỗi khi gắn thuốc');

            alert(data.message || 'Cập nhật thành công!');
            window.location.reload();
        } catch (err) {
            alert('Lỗi: ' + err.message);
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>💾</span> Lưu liên kết thuốc';
            }
        }
    }

    // Khởi chạy đếm số lượng khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        capNhatSoLuongLoc();
    });
</script>
</x-layouts.engineer>
