<x-layouts.app title="Các bài thuốc trị bệnh — Sổ Tay Thuốc BVTV">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6">

        <!-- Header Người dùng (Chỉ xem) -->
        <div class="bg-gradient-to-r from-emerald-800 via-green-700 to-teal-800 rounded-2xl text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none text-9xl">🌿</div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-xs font-semibold text-emerald-100 mb-3 border border-white/20">
                            <span>🌿 CẨM NANG NÔNG NGHIỆP</span>
                            <span>•</span>
                            <span>CHẾ ĐỘ TRA CỨU (CHỈ XEM)</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                            <span>🌿</span> Các Bài Thuốc & Phác Đồ Trị Bệnh
                        </h1>
                        <p class="text-emerald-100 text-sm sm:text-base mt-2 max-w-2xl leading-relaxed">
                            Tra cứu toa thuốc phối hợp và phác đồ điều trị hiệu quả cho từng loại sâu bệnh hại cây trồng. Nhấp vào thuốc để xem liều dùng chi tiết.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <a href="{{ route('thuoc.tra-cuu') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-medium transition backdrop-blur border border-white/20">
                            <span>🔍</span> Tra cứu thuốc
                        </a>
                        <a href="{{ route('hoatchat.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white text-sm font-medium transition backdrop-blur border border-white/20">
                            <span>⚗️</span> Tra cứu hoạt chất
                        </a>
                        <a href="{{ route('benh.quan-ly') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/90 hover:bg-amber-600 text-white text-sm font-semibold transition shadow-sm border border-amber-400">
                            <span>⚙️</span> Quản lý bài thuốc (Admin)
                        </a>
                    </div>
                </div>

                <!-- Thống kê nhanh -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 mt-6 pt-6 border-t border-white/15 max-w-xl">
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Tổng số bài thuốc / bệnh</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5" id="tong-so-benh-text">
                            {{ $diseases->count() }}
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10">
                        <div class="text-xs text-emerald-200">Tổng thuốc được phối toa</div>
                        <div class="text-xl sm:text-2xl font-bold text-white mt-0.5">
                            {{ $diseases->sum(fn($d) => $d->pesticides->count()) }}
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 backdrop-blur border border-white/10 col-span-2 sm:col-span-1">
                        <div class="text-xs text-emerald-200">Trạng thái</div>
                        <div class="text-xl sm:text-2xl font-bold text-emerald-300 mt-0.5">
                            Sẵn sàng
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar tìm kiếm & Lọc nhanh Nấm Sầu Riêng -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-gray-100 space-y-3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none text-base">
                    🔍
                </span>
                <input type="text"
                    id="diseaseSearchInput"
                    placeholder="Tìm bài thuốc theo tên bệnh (vd: xì mủ, thán thư, rầy xanh, sương mai...), triệu chứng, hoặc tên thuốc phối hợp..."
                    class="w-full pl-10 pr-10 py-2.5 bg-gray-50 hover:bg-white focus:bg-white text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                <button id="clearDiseaseSearchBtn"
                    type="button"
                    class="hidden absolute inset-y-0 right-0 items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                    ✕
                </button>
            </div>

            <!-- Bộ lọc chuyên sâu Nấm trên sầu riêng -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-2 border-t border-gray-100 text-xs scrollbar-none">
                <span class="text-gray-400 font-semibold shrink-0 flex items-center gap-1">
                    <span>🍄</span> Nấm sầu riêng:
                </span>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-emerald-700 text-white font-semibold shrink-0 transition cursor-pointer" data-filter="">
                    Tất cả ({{ $diseases->count() }})
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 font-medium shrink-0 transition cursor-pointer" data-filter="sầu riêng">
                    🌳 Tất cả nấm sầu riêng
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-medium shrink-0 transition cursor-pointer" data-filter="phytophthora">
                    🔴 Phytophthora
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-amber-50 text-gray-700 hover:text-amber-700 font-medium shrink-0 transition cursor-pointer" data-filter="fusarium">
                    🟤 Fusarium
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-orange-50 text-gray-700 hover:text-orange-700 font-medium shrink-0 transition cursor-pointer" data-filter="colletotrichum">
                    🟠 Colletotrichum (Thán thư)
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-medium shrink-0 transition cursor-pointer" data-filter="rhizoctonia">
                    🔥 Rhizoctonia (Cháy lá)
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-yellow-50 text-gray-700 hover:text-yellow-700 font-medium shrink-0 transition cursor-pointer" data-filter="pythium">
                    🟡 Pythium (Thối rễ non)
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-purple-50 text-gray-700 hover:text-purple-700 font-medium shrink-0 transition cursor-pointer" data-filter="lasiodiplodia">
                    🟣 Lasiodiplodia (Khô cành)
                </button>
                <button type="button" class="durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-pink-50 text-gray-700 hover:text-pink-700 font-medium shrink-0 transition cursor-pointer" data-filter="nấm hồng">
                    🩷 Nấm hồng
                </button>
            </div>
        </div>

        <!-- Thông tin số lượng hiển thị & Nút Mở rộng / Thu gọn tất cả -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-gray-500 px-1">
            <div class="flex items-center gap-2 flex-wrap">
                <span id="diseaseResultCountText">Đang hiển thị toàn bộ <strong>{{ $diseases->count() }}</strong> bài thuốc điều trị</span>
                <span class="text-gray-300 hidden sm:inline">•</span>
                <span class="text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200">
                    👉 Nhấn vào bài thuốc để xem chi tiết
                </span>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="moTatCaBaiThuoc()" class="px-3 py-1.5 rounded-lg border border-gray-300 hover:border-emerald-500 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-800 font-bold text-xs transition flex items-center gap-1.5 cursor-pointer shadow-2xs">
                    <span>📖</span> Mở rộng tất cả
                </button>
                <button type="button" onclick="thuGonTatCaBaiThuoc()" class="px-3 py-1.5 rounded-lg border border-gray-300 hover:border-emerald-500 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-800 font-bold text-xs transition flex items-center gap-1.5 cursor-pointer shadow-2xs">
                    <span>📕</span> Thu gọn tất cả
                </button>
            </div>
        </div>

        <!-- Danh sách bài thuốc (Dạng danh sách thu gọn, click để mở chi tiết) -->
        <div id="diseaseCardsContainer" class="space-y-4">
            @forelse($diseases as $benh)
                @php
                    $imgsUrls = $benh->images_urls;
                    $plansText = '';
                    if (!empty($benh->treatment_plans)) {
                        foreach ($benh->treatment_plans as $pl) {
                            $plansText .= ' ' . ($pl['title'] ?? '') . ' ' . ($pl['stage'] ?? '') . ' ' . ($pl['dosage_guide'] ?? '') . ' ' . ($pl['safety_note'] ?? '');
                        }
                    }
                    $searchCorpus = mb_strtolower(
                        $benh->name . ' ' .
                        ($benh->notes ?? '') . ' ' .
                        ($benh->symptoms ?? '') . ' ' .
                        ($benh->prevention ?? '') . ' ' .
                        ($benh->treatment ?? '') . ' ' .
                        $plansText . ' ' .
                        $benh->pesticides->pluck('name')->implode(' ') . ' ' .
                        $benh->pesticides->pluck('active_ingredient')->implode(' ')
                    );
                    $planCount = count($benh->hydrated_treatment_plans ?? []);
                    $briefSnippet = $benh->notes ?: ($benh->symptoms ?: 'Nhấn để xem chi tiết các triệu chứng và phác đồ điều trị.');
                @endphp

                <div class="disease-card bg-white rounded-2xl border-2 border-gray-200/80 hover:border-emerald-400 transition-all duration-200 shadow-2xs overflow-hidden"
                     data-id="{{ $benh->id }}"
                     data-search="{{ $searchCorpus }}">

                    <!-- HEADER TÓM TẮT DẠNG DANH SÁCH (CLICK ĐỂ MỞ/ĐÓNG CHI TIẾT) -->
                    <div class="disease-card-header p-4 sm:p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4 cursor-pointer hover:bg-emerald-50/30 transition-colors select-none group/hdr"
                         onclick="toggleDiseaseCard(this.closest('.disease-card'))">

                        <div class="flex items-start sm:items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                            <!-- Khung ảnh bệnh (Hỗ trợ 1 hoặc nhiều ảnh) -->
                            <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gray-100 overflow-hidden border border-gray-200 shadow-2xs shrink-0 group/img"
                                 onclick='event.stopPropagation(); moGalleryTraCuu(@json($imgsUrls), @json($benh->name))'
                                 title="Bấm phóng to ảnh bệnh">
                                @if(!empty($imgsUrls))
                                    <img src="{{ $imgsUrls[0] }}" alt="{{ $benh->name }}" class="w-full h-full object-cover group-hover/img:scale-105 transition duration-300">
                                    @if(count($imgsUrls) > 1)
                                        <span class="absolute bottom-1 right-1 bg-black/75 backdrop-blur-xs text-white text-[9px] font-bold px-1.5 py-0.2 rounded flex items-center gap-0.5 shadow">
                                            <span>📷</span> {{ count($imgsUrls) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="w-full h-full flex items-center justify-center text-2xl opacity-40">🌿</span>
                                @endif
                            </div>

                            <!-- Tên bệnh & tóm tắt nhanh -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span>🛡️</span> Bệnh hại & Bài thuốc
                                    </span>
                                    @if($planCount > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-900 border border-emerald-300">
                                            <span>🧪</span> {{ $planCount }} phác đồ phối hợp
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-800 border border-green-200">
                                        <span>💊</span> {{ $benh->pesticides->count() }} thuốc
                                    </span>
                                    @if(count($imgsUrls) > 1)
                                        <button type="button"
                                                onclick='event.stopPropagation(); moGalleryTraCuu(@json($imgsUrls), @json($benh->name))'
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 hover:bg-emerald-50 text-gray-600 hover:text-emerald-700 transition">
                                            <span>🖼️</span> {{ count($imgsUrls) }} ảnh
                                        </button>
                                    @endif
                                </div>

                                <h2 class="text-base sm:text-lg font-black text-gray-900 group-hover/hdr:text-emerald-700 transition leading-snug">
                                    {{ $benh->name }}
                                </h2>

                                <p class="text-xs text-gray-500 line-clamp-1 sm:line-clamp-2 mt-1 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($briefSnippet), 130) }}
                                </p>
                            </div>
                        </div>

                        <!-- Nút xem / thu gọn bên phải -->
                        <div class="flex items-center justify-between sm:justify-end gap-3 pt-2 lg:pt-0 border-t border-gray-100 lg:border-t-0 shrink-0">
                            <span class="lg:hidden text-[11px] font-semibold text-gray-400">Nhấn để mở chi tiết</span>
                            <button type="button" class="btn-toggle-badge px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 transition shadow-2xs pointer-events-none">
                                <span class="btn-toggle-text">Xem chi tiết bài thuốc</span>
                                <svg class="icon-toggle-arrow w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- NỘI DUNG CHI TIẾT ĐẦY ĐỦ (MẶC ĐỊNH ẨN, NHẤN VÀO MỚI HIỆN) -->
                    <div class="disease-detail-content hidden p-5 sm:p-6 border-t border-gray-200 bg-gray-50/40 space-y-6">
                        @if($benh->notes)
                            <div class="text-xs sm:text-sm text-gray-700 leading-relaxed bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                <span class="font-bold text-emerald-800">📌 Ghi chú thêm:</span> {{ $benh->notes }}
                            </div>
                        @endif

                        <!-- KHỐI NỘI DUNG CHI TIẾT: 1.1 Triệu chứng, 1.2 Cách phòng bệnh, 1.3 Cách điều trị -->
                        @if($benh->symptoms || $benh->prevention || $benh->treatment)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- 1.1. Triệu chứng -->
                            <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-200/70 space-y-2">
                                <div class="flex items-center gap-2 text-xs font-bold text-amber-900 uppercase tracking-wider">
                                    <span>🔍</span>
                                    <span>1.1. Triệu chứng</span>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                                    {{ $benh->symptoms ?: 'Chưa có thông tin mô tả triệu chứng.' }}
                                </div>
                            </div>

                            <!-- 1.2. Cách phòng bệnh -->
                            <div class="bg-sky-50/50 rounded-xl p-4 border border-sky-200/70 space-y-2">
                                <div class="flex items-center gap-2 text-xs font-bold text-sky-900 uppercase tracking-wider">
                                    <span>🛡️</span>
                                    <span>1.2. Cách phòng bệnh</span>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                                    {{ $benh->prevention ?: 'Chưa có thông tin biện pháp phòng ngừa.' }}
                                </div>
                            </div>

                            <!-- 1.3. Cách điều trị -->
                            <div class="bg-emerald-50/50 rounded-xl p-4 border border-emerald-200/70 space-y-2">
                                <div class="flex items-center gap-2 text-xs font-bold text-emerald-900 uppercase tracking-wider">
                                    <span>💉</span>
                                    <span>1.3. Cách điều trị</span>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-800 leading-relaxed whitespace-pre-line">
                                    {{ $benh->treatment ?: 'Chưa có thông tin hướng dẫn điều trị.' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- KHỐI PHÁC ĐỒ PHỐI HỢP CHI TIẾT & TOA THUỐC -->
                    <div class="pt-3 space-y-6">
                        @if(!empty($benh->hydrated_treatment_plans) && count($benh->hydrated_treatment_plans) > 0)
                            <!-- TIÊU ĐỀ KHỐI PHÁC ĐỒ -->
                            <div class="flex items-center justify-between flex-wrap gap-2 pb-1 border-b border-gray-100">
                                <div class="text-xs font-black uppercase tracking-wider text-emerald-900 flex items-center gap-2">
                                    <span class="text-base">🧪</span>
                                    <span>Phác đồ phối hợp chi tiết — Cái nào đi với cái nào ({{ count($benh->hydrated_treatment_plans) }} phác đồ chuẩn)</span>
                                </div>
                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    ✓ Đã kiểm chứng chống kết tủa & an toàn cây trồng
                                </span>
                            </div>

                            <!-- DANH SÁCH CÁC PHÁC ĐỒ -->
                            <div class="space-y-5">
                                @foreach($benh->hydrated_treatment_plans as $planIdx => $plan)
                                    <div class="bg-gradient-to-br from-emerald-50/30 via-white to-sky-50/20 rounded-2xl border-2 border-emerald-400/40 p-4 sm:p-5 shadow-sm space-y-4 hover:border-emerald-500 transition-all">
                                        <!-- Header phác đồ -->
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-emerald-100/70">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black tracking-wide uppercase bg-emerald-700 text-white shadow-xs">
                                                        {{ !empty(trim($plan['badge'] ?? '')) ? $plan['badge'] : ('Phác đồ ' . ($planIdx + 1)) }}
                                                    </span>
                                                    <h3 class="text-base sm:text-lg font-black text-gray-900 leading-snug">
                                                        {{ !empty(trim($plan['title'] ?? '')) ? $plan['title'] : ('Phác đồ điều trị phối hợp ' . ($planIdx + 1)) }}
                                                    </h3>
                                                </div>
                                                @if(!empty($plan['stage']))
                                                    <div class="text-xs text-gray-700 font-medium flex items-center gap-1.5 pt-0.5">
                                                        <span class="text-emerald-700 font-bold">🌱 Giai đoạn sử dụng:</span>
                                                        <span class="text-gray-900 font-semibold">{{ $plan['stage'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- SƠ ĐỒ TRỰC QUAN: CÁC THUỐC TRONG PHÁC ĐỒ PHỐI TRỘN -->
                                        <div>
                                            <!-- BĂNG CÔNG THỨC PHỐI TRỘN TỔNG QUAN -->
                                            <div class="bg-white/80 border border-emerald-200/90 rounded-xl p-3 shadow-2xs flex items-center gap-2.5 flex-wrap mb-3.5">
                                                <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-800 flex items-center gap-1.5 shrink-0">
                                                    <span class="text-base">🧪</span>
                                                    <span>Công thức phối trộn ({{ count($plan['groups']) }} sản phẩm):</span>
                                                </span>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @foreach($plan['groups'] as $grpIdx => $grp)
                                                        @if($grpIdx > 0)
                                                             <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-2xs shrink-0" title="Phối hợp cùng">+</span>
                                                        @endif
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-950 border border-emerald-200/80 font-bold text-xs shadow-2xs">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                                                            <span>{{ $grp['primary_pesticide']->name ?? ($grp['label'] ?: ('Thuốc ' . ($grpIdx + 1))) }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @php
                                                $grpCount = count($plan['groups'] ?? []);
                                                $gridColsClass = match(true) {
                                                    $grpCount === 1 => 'grid-cols-1 max-w-xl',
                                                    $grpCount === 2 => 'grid-cols-1 md:grid-cols-2',
                                                    $grpCount === 3 => 'grid-cols-1 md:grid-cols-2 xl:grid-cols-3',
                                                    default => 'grid-cols-1 md:grid-cols-2',
                                                };
                                            @endphp

                                            <div class="grid {{ $gridColsClass }} gap-4 items-stretch">
                                                @foreach($plan['groups'] as $grpIdx => $grp)
                                                    <!-- KHỐI THUỐC TRONG PHÁC ĐỒ -->
                                                    <div class="bg-white rounded-2xl p-4 border border-emerald-200/80 shadow-xs flex flex-col justify-between space-y-3 hover:border-emerald-400 transition min-w-0">
                                                        <!-- Header vai trò của thuốc trong phác đồ -->
                                                        <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-gray-100">
                                                            @if($grpIdx === 0)
                                                                <div class="flex items-center gap-1.5 min-w-0 flex-1">
                                                                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white text-[10px] font-black flex items-center justify-center shadow-2xs shrink-0">1</span>
                                                                    <span class="text-xs font-black text-emerald-900 uppercase tracking-wide line-clamp-1 break-words">
                                                                        {{ !empty(trim($grp['label'] ?? '')) ? $grp['label'] : 'Thuốc chính (Món 1)' }}
                                                                    </span>
                                                                </div>
                                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                                                    Chủ lực
                                                                </span>
                                                            @else
                                                                <div class="flex items-center gap-1.5 min-w-0 flex-1">
                                                                    <span class="w-5 h-5 rounded-full bg-teal-600 text-white text-[10px] font-black flex items-center justify-center shadow-2xs shrink-0">+</span>
                                                                    <span class="text-xs font-black text-teal-900 uppercase tracking-wide line-clamp-1 break-words">
                                                                        {{ !empty(trim($grp['label'] ?? '')) ? $grp['label'] : ('Thuốc phối hợp ' . ($grpIdx + 1)) }}
                                                                    </span>
                                                                </div>
                                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-teal-100 text-teal-800 border border-teal-300 shrink-0">
                                                                    + Phối hợp
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <!-- Thẻ thuốc chính -->
                                                        @if(!empty($grp['primary_pesticide']))
                                                            @php $p = $grp['primary_pesticide']; @endphp
                                                            <a href="{{ route('thuoc.xem', $p->id) }}"
                                                               class="group/p flex items-start gap-3 p-3 rounded-xl bg-gray-50/80 hover:bg-emerald-50/60 border border-gray-200/80 hover:border-emerald-300 transition shadow-2xs">
                                                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-white shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center group-hover/p:scale-105 transition shadow-2xs p-1">
                                                                    @if($p->image_url)
                                                                        <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-contain">
                                                                    @else
                                                                        <span class="text-2xl">💊</span>
                                                                    @endif
                                                                </div>
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                                                                        @if($p->category)
                                                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-gray-200/80 text-gray-700">
                                                                                {{ $p->category->name }}
                                                                            </span>
                                                                        @endif
                                                                        @if($p->form_type)
                                                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-900">
                                                                                {{ $p->form_type }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover/p:text-emerald-700 line-clamp-2 leading-tight">
                                                                        {{ $p->name }}
                                                                    </h4>
                                                                    @if($p->active_ingredient)
                                                                        <div class="text-[11px] text-gray-600 line-clamp-2 mt-1 leading-tight">
                                                                            ⚗️ {{ $p->active_ingredient }}
                                                                        </div>
                                                                    @endif
                                                                    @if($p->water_volume)
                                                                        <div class="mt-1.5 inline-flex items-center gap-1 text-[10px] font-bold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200/80">
                                                                            <span>💧</span> <span>{{ $p->water_volume }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <span class="text-xs text-gray-300 group-hover/p:text-emerald-600 transition pl-1 self-center">→</span>
                                                            </a>
                                                        @endif

                                                        <!-- CÁC LỰA CHỌN THAY THẾ (NẾU CÓ) -->
                                                        @if(!empty($grp['substitutes']) && count($grp['substitutes']) > 0)
                                                            <div class="pt-2.5 border-t border-dashed border-amber-200 bg-amber-50/40 p-2.5 rounded-xl space-y-1.5 mt-auto">
                                                                <div class="text-[10px] font-bold text-amber-900 uppercase tracking-wide flex items-center gap-1">
                                                                    <span>🔄</span>
                                                                    <span>{{ $grp['substitute_label'] ?? 'Hoặc có thể chọn thay thế bằng:' }}</span>
                                                                </div>
                                                                <div class="space-y-1.5">
                                                                    @foreach($grp['substitutes'] as $sub)
                                                                        <a href="{{ route('thuoc.xem', $sub->id) }}"
                                                                           class="group/sub flex items-center justify-between gap-2.5 p-2 rounded-lg bg-white hover:bg-amber-50/80 border border-amber-200/80 hover:border-amber-400 transition text-xs shadow-2xs">
                                                                            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                                                                <div class="w-8 h-8 rounded-md bg-gray-100 shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center p-0.5">
                                                                                    @if($sub->image_url)
                                                                                        <img src="{{ $sub->image_url }}" alt="{{ $sub->name }}" class="w-full h-full object-contain">
                                                                                    @else
                                                                                        <span class="text-xs">💊</span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="min-w-0 flex-1">
                                                                                    <span class="font-bold text-gray-900 group-hover/sub:text-amber-800 text-[11px] truncate block">{{ $sub->name }}</span>
                                                                                    <span class="text-[10px] text-gray-500 truncate block">{{ $sub->active_ingredient ?? '' }}</span>
                                                                                </div>
                                                                            </div>
                                                                            @if($sub->water_volume)
                                                                                <div class="shrink-0 text-right">
                                                                                    <span class="text-[9px] font-bold text-teal-800 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-md inline-block max-w-[130px] truncate" title="{{ $sub->water_volume }}">
                                                                                        💧 {{ \Illuminate\Support\Str::limit($sub->water_volume, 18) }}
                                                                                    </span>
                                                                                </div>
                                                                            @endif
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- HƯỚNG DẪN LIỀU LƯỢNG PHA CHUNG -->
                                        @if(!empty($plan['dosage_guide']))
                                            <div class="bg-emerald-50 border border-emerald-300/80 rounded-xl p-3.5 flex items-start gap-3 text-xs sm:text-sm text-emerald-950 leading-relaxed shadow-2xs">
                                                <span class="text-xl shrink-0 leading-none">💧</span>
                                                <div>
                                                    <strong class="font-black text-emerald-900 block mb-0.5 uppercase tracking-wide text-xs">
                                                        Cách pha & Liều lượng phối trộn chung:
                                                    </strong>
                                                    <span>{{ $plan['dosage_guide'] }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- CẢNH BÁO AN TOÀN & CHỐNG KẾT TỦA -->
                                        @if(!empty($plan['safety_note']))
                                            <div class="bg-amber-50 border border-amber-300/80 rounded-xl p-3.5 flex items-start gap-3 text-xs sm:text-sm text-amber-950 leading-relaxed shadow-2xs">
                                                <span class="text-xl shrink-0 leading-none">⚠️</span>
                                                <div>
                                                    <strong class="font-black text-amber-900 block mb-0.5 uppercase tracking-wide text-xs">
                                                        Lưu ý phối trộn an toàn & Chống kết tủa:
                                                    </strong>
                                                    <span>{{ $plan['safety_note'] }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- DANH MỤC TẤT CẢ SẢN PHẨM TRONG BỆNH (DẠNG THU GỌN / XEM THÊM) -->
                            <details class="group bg-gray-50 rounded-2xl border border-gray-200 p-3.5 sm:p-4">
                                <summary class="cursor-pointer text-xs font-bold text-gray-700 uppercase tracking-wide flex items-center justify-between select-none">
                                    <span class="flex items-center gap-2">
                                        <span>📦</span>
                                        <span>Xem toàn bộ danh mục sản phẩm thuốc liên quan ({{ $benh->pesticides->count() }})</span>
                                    </span>
                                    <span class="text-gray-400 group-open:rotate-180 transition-transform font-bold text-sm">▼</span>
                                </summary>
                                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 pt-3.5">
                                    @foreach($benh->pesticides as $pesticide)
                                        <a href="{{ route('thuoc.xem', $pesticide->id) }}"
                                           class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-200 bg-white hover:border-emerald-400 hover:bg-emerald-50/20 transition shadow-2xs">
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center">
                                                @if($pesticide->image_url)
                                                    <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xl opacity-40">💊</span>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-xs font-bold text-gray-900 truncate">{{ $pesticide->name }}</h4>
                                                <div class="text-[11px] text-gray-500 truncate">{{ $pesticide->active_ingredient ?? '—' }}</div>
                                                @if($pesticide->water_volume)
                                                    <div class="text-[10px] text-teal-700 font-semibold">💧 {{ $pesticide->water_volume }}</div>
                                                @endif
                                            </div>
                                            <span class="text-xs text-gray-300">→</span>
                                        </a>
                                    @endforeach
                                </div>
                            </details>
                        @elseif($benh->pesticides->isNotEmpty())
                            <!-- Trường hợp bệnh chưa có phác đồ cấu hình cụ thể: hiển thị lưới thuốc mặc định -->
                            <div class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 flex items-center gap-2">
                                <span>📦</span>
                                <span>Đơn thuốc khuyến cáo ({{ $benh->pesticides->count() }})</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                                @foreach($benh->pesticides as $pesticide)
                                    <a href="{{ route('thuoc.xem', $pesticide->id) }}"
                                       class="group flex items-center gap-3.5 p-3 rounded-xl border border-gray-200/80 hover:border-emerald-400 hover:bg-emerald-50/20 bg-white transition shadow-sm hover:shadow">
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-gray-100 shrink-0 overflow-hidden border border-gray-200 flex items-center justify-center group-hover:scale-105 transition">
                                            @if($pesticide->image_url)
                                                <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-cover" loading="lazy">
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
                                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 truncate transition">
                                                {{ $pesticide->name }}
                                            </h4>
                                            <div class="text-xs text-gray-500 truncate mt-0.5">
                                                {{ $pesticide->active_ingredient ?? '—' }}
                                            </div>
                                            @if($pesticide->water_volume)
                                                <div class="mt-1 inline-flex items-center gap-1 text-[11px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">
                                                    <span>💧</span>
                                                    <span class="truncate max-w-[170px]">{{ $pesticide->water_volume }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="shrink-0 text-gray-300 group-hover:text-emerald-600 transition pl-1">→</div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-gray-50 border border-dashed border-gray-200 text-center text-xs text-gray-400">
                                Chưa gán thuốc cụ thể cho bài thuốc này.
                            </div>
                        @endif

                        <!-- Nút thu gọn ở đáy bài thuốc -->
                        <div class="pt-3 border-t border-gray-200 flex items-center justify-between gap-3 flex-wrap">
                            <span class="text-xs text-gray-400">Đã xem hết nội dung bài thuốc <strong>{{ $benh->name }}</strong></span>
                            <button type="button" onclick="thuGonCard(this)" class="px-3.5 py-1.5 rounded-xl border border-gray-300 hover:border-emerald-500 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-800 font-bold text-xs transition flex items-center gap-1.5 cursor-pointer shadow-2xs ml-auto">
                                <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                <span>Thu gọn bài thuốc</span>
                            </button>
                        </div>

                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm space-y-3">
                    <div class="text-5xl">🌿</div>
                    <h3 class="text-lg font-bold text-gray-800">Chưa có bài thuốc nào</h3>
                    <p class="text-sm text-gray-500">Hệ thống đang được cập nhật các phác đồ điều trị mới.</p>
                </div>
            @endforelse
        </div>

        <!-- Trạng thái không tìm thấy khi lọc -->
        <div id="noDiseaseResultsState" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-200 shadow-sm space-y-4">
            <div class="text-5xl">🔍</div>
            <h3 class="text-lg font-bold text-gray-800">Không tìm thấy bài thuốc phù hợp</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">
                Thử tìm với tên sâu bệnh hại khác như <span class="font-semibold text-emerald-600">xì mủ, thán thư, rầy xanh, sương mai...</span> hoặc triệu chứng, thuốc phối hợp.
            </p>
            <button type="button"
                id="resetDiseaseSearchBtn"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow transition">
                Xóa tìm kiếm
            </button>
        </div>

    </div>

    <!-- Modal Xem Album Ảnh Bệnh (Gallery Lightbox) -->
    <div id="modal-gallery-tra-cuu" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/85 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl max-w-3xl w-full overflow-hidden shadow-2xl space-y-3 p-4 sm:p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 id="gallery-tra-cuu-title" class="font-bold text-gray-900 text-base sm:text-lg flex items-center gap-2">
                    <span>🖼️</span> Album ảnh bệnh
                </h3>
                <button type="button" onclick="dongGalleryTraCuu()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition">
                    ✕
                </button>
            </div>

            <!-- Ảnh lớn chính -->
            <div class="w-full h-80 sm:h-96 bg-gray-900 rounded-xl overflow-hidden flex items-center justify-center">
                <img id="gallery-tra-cuu-main-img" src="" class="max-w-full max-h-full object-contain">
            </div>

            <!-- Hàng thumbnail chọn ảnh -->
            <div id="gallery-tra-cuu-thumbs" class="flex items-center gap-2 overflow-x-auto py-2">
                <!-- Thumbs injected via JS -->
            </div>
        </div>
    </div>

    <!-- Script tìm kiếm, toggle danh sách và Gallery Lightbox cho Người dùng -->
    <script>
        function setCardExpanded(card, expand) {
            if (!card) return;
            const detail = card.querySelector('.disease-detail-content');
            const textEl = card.querySelector('.btn-toggle-text');
            const arrowEl = card.querySelector('.icon-toggle-arrow');
            const badgeBtn = card.querySelector('.btn-toggle-badge');
            if (!detail) return;

            if (expand) {
                detail.classList.remove('hidden');
                if (textEl) textEl.textContent = 'Thu gọn';
                if (arrowEl) arrowEl.classList.add('rotate-180');
                if (badgeBtn) {
                    badgeBtn.className = 'btn-toggle-badge px-3.5 py-1.5 sm:py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs sm:text-sm flex items-center gap-1.5 transition shadow-2xs pointer-events-none';
                }
                card.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-200/60', 'shadow-md');
                card.classList.remove('border-gray-200/80');
            } else {
                detail.classList.add('hidden');
                if (textEl) textEl.textContent = 'Xem chi tiết bài thuốc';
                if (arrowEl) arrowEl.classList.remove('rotate-180');
                if (badgeBtn) {
                    badgeBtn.className = 'btn-toggle-badge px-3.5 py-1.5 sm:py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 transition shadow-2xs pointer-events-none';
                }
                card.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-200/60', 'shadow-md');
                card.classList.add('border-gray-200/80');
            }
        }

        function toggleDiseaseCard(card) {
            if (!card) return;
            const detail = card.querySelector('.disease-detail-content');
            if (!detail) return;
            const isHidden = detail.classList.contains('hidden');
            setCardExpanded(card, isHidden);
        }

        function thuGonCard(btn) {
            const card = btn.closest('.disease-card');
            if (card) {
                setCardExpanded(card, false);
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function moTatCaBaiThuoc() {
            document.querySelectorAll('.disease-card:not(.hidden)').forEach(card => {
                setCardExpanded(card, true);
            });
        }

        function thuGonTatCaBaiThuoc() {
            document.querySelectorAll('.disease-card').forEach(card => {
                setCardExpanded(card, false);
            });
        }

        function moGalleryTraCuu(urls, title, startIndex = 0) {
            if (!urls || urls.length === 0) return;
            const modal = document.getElementById('modal-gallery-tra-cuu');
            const titleEl = document.getElementById('gallery-tra-cuu-title');
            const mainImg = document.getElementById('gallery-tra-cuu-main-img');
            const thumbs = document.getElementById('gallery-tra-cuu-thumbs');
            if (!modal) return;

            const idx = (startIndex >= 0 && startIndex < urls.length) ? startIndex : 0;

            if (titleEl) {
                titleEl.innerHTML = `<span>🖼️</span> Hình ảnh: <strong>${title}</strong> (${urls.length} ảnh)`;
            }
            if (mainImg) {
                mainImg.src = urls[idx];
            }

            if (thumbs) {
                thumbs.innerHTML = urls.map((u, i) => `
                    <img src="${u}"
                         onclick="chuyenAnhGallery('${u}', this)"
                         class="gallery-tc-thumb w-14 h-14 object-cover rounded-lg border-2 cursor-pointer hover:opacity-90 transition ${i === idx ? 'border-emerald-600 ring-2 ring-emerald-400' : 'border-gray-200'}">
                `).join('');
            }

            modal.classList.remove('hidden');
        }

        function chuyenAnhGallery(src, thumbEl) {
            const mainImg = document.getElementById('gallery-tra-cuu-main-img');
            if (mainImg) mainImg.src = src;
            document.querySelectorAll('.gallery-tc-thumb').forEach(t => {
                t.classList.remove('border-emerald-600', 'ring-2', 'ring-emerald-400');
                t.classList.add('border-gray-200');
            });
            if (thumbEl) {
                thumbEl.classList.remove('border-gray-200');
                thumbEl.classList.add('border-emerald-600', 'ring-2', 'ring-emerald-400');
            }
        }

        function dongGalleryTraCuu() {
            document.getElementById('modal-gallery-tra-cuu')?.classList.add('hidden');
        }

        document.getElementById('modal-gallery-tra-cuu')?.addEventListener('click', function(e) {
            if (e.target === this) dongGalleryTraCuu();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') dongGalleryTraCuu();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('diseaseSearchInput');
            const clearBtn = document.getElementById('clearDiseaseSearchBtn');
            const resetBtn = document.getElementById('resetDiseaseSearchBtn');
            const filterBtns = document.querySelectorAll('.durian-filter-btn');
            const cards = document.querySelectorAll('.disease-card');
            const countText = document.getElementById('diseaseResultCountText');
            const noResults = document.getElementById('noDiseaseResultsState');

            function updateFilterButtonStyles(activeVal) {
                filterBtns.forEach(btn => {
                    const val = (btn.dataset.filter || '').trim().toLowerCase();
                    const isActive = (val === activeVal.trim().toLowerCase()) || (val === '' && activeVal.trim() === '');
                    if (isActive) {
                        btn.className = 'durian-filter-btn px-2.5 py-1 rounded-lg bg-emerald-700 text-white font-semibold shrink-0 transition cursor-pointer shadow-xs';
                    } else {
                        btn.className = 'durian-filter-btn px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 font-medium shrink-0 transition cursor-pointer';
                    }
                });
            }

            function applySearch() {
                const query = searchInput.value.trim().toLowerCase();
                clearBtn.classList.toggle('hidden', query.length === 0);

                let visibleCount = 0;
                cards.forEach(card => {
                    const corpus = card.dataset.search || '';
                    if (query === '' || corpus.includes(query)) {
                        card.classList.remove('hidden');
                        visibleCount++;
                        // Nếu đang có từ khóa tìm kiếm, tự động mở chi tiết bài thuốc khớp
                        if (query.length > 0) {
                            setCardExpanded(card, true);
                        }
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Nếu xóa trắng ô tìm kiếm, thu gọn lại danh sách cho gọn gàng
                if (query.length === 0) {
                    thuGonTatCaBaiThuoc();
                }

                countText.innerHTML = `Đang hiển thị <strong>${visibleCount}</strong> bài thuốc điều trị`;
                noResults.classList.toggle('hidden', visibleCount > 0);
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const filterVal = this.dataset.filter || '';
                    searchInput.value = filterVal;
                    updateFilterButtonStyles(filterVal);
                    applySearch();
                });
            });

            searchInput.addEventListener('input', function() {
                updateFilterButtonStyles(searchInput.value);
                applySearch();
            });

            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.focus();
                updateFilterButtonStyles('');
                applySearch();
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    updateFilterButtonStyles('');
                    applySearch();
                });
            }
        });
    </script>
</x-layouts.app>
