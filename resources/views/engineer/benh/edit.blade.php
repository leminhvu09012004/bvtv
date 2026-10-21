<x-layouts.engineer :title="'Chỉnh Sửa ' . $disease->name . ' — Phân Hệ Kỹ Sư BVTV'">
<div class="max-w-5xl mx-auto space-y-6 pb-16">

    <!-- 1. THANH ĐIỀU HƯỚNG BREADCRUMB & HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div class="space-y-1">
            <nav class="flex items-center gap-2 text-xs font-bold text-slate-500">
                <a href="{{ route('engineer.benh.index') }}" class="hover:text-teal-700 transition">🌿 Cẩm nang bệnh hại</a>
                <span>/</span>
                <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}" class="hover:text-teal-700 transition truncate max-w-xs">{{ $disease->name }}</a>
                <span>/</span>
                <span class="text-teal-800 font-extrabold">✏️ Chỉnh sửa</span>
            </nav>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>✏️</span> Chỉnh Sửa Thông Tin Bệnh & Phác Đồ
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium">
                Cập nhật kiến thức chuyên môn, cây trồng mẫn cảm và danh mục thuốc BVTV đặc trị trong kho.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}"
               class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 shadow-2xs transition inline-flex items-center gap-1.5">
                <span>←</span> Quay lại chi tiết
            </a>
        </div>
    </div>

    <!-- 2. FORM CHỈNH SỬA CHÍNH (KHÔNG CÓ CHỈNH SỬA ẢNH) -->
    <form id="formEditDiseasePage" onsubmit="xuLyLuuTrangChinhSua(event)" class="space-y-6">
        @csrf
        @php
            $linkedCropIds = $disease->crops->pluck('id')->toArray();
            $linkedPesticideIds = $disease->pesticides->pluck('id')->toArray();
        @endphp

        <!-- CARD 1: THÔNG TIN CỐT LÕI (TÊN BỆNH & TÁC NHÂN) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="text-lg">📌</span>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                    1. Thông tin định danh & Tác nhân gây hại
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2 space-y-1.5">
                    <label class="font-extrabold text-slate-800 text-xs">
                        Tên bệnh hại <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="formName"
                           required
                           value="{{ $disease->name }}"
                           placeholder="Ví dụ: Bệnh Sương Mai — Oomycetes"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl font-black text-slate-900 text-sm focus:bg-white focus:ring-2 focus:ring-teal-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="font-extrabold text-slate-800 text-xs">
                        Tác nhân gây bệnh <span class="text-rose-500">*</span>
                    </label>
                    <select name="pathogen_type"
                            id="formPathogenType"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl font-bold text-slate-900 text-sm focus:bg-white focus:ring-2 focus:ring-teal-500 transition">
                        <option value="nam" {{ ($disease->pathogen_type ?? '') === 'nam' ? 'selected' : '' }}>🍄 Nấm & Oomycetes</option>
                        <option value="virus" {{ ($disease->pathogen_type ?? '') === 'virus' ? 'selected' : '' }}>🦠 Virus hại</option>
                        <option value="tuyen_trung" {{ ($disease->pathogen_type ?? '') === 'tuyen_trung' ? 'selected' : '' }}>🪱 Tuyến trùng hại</option>
                        <option value="vi_khuan" {{ ($disease->pathogen_type ?? '') === 'vi_khuan' ? 'selected' : '' }}>🧪 Vi khuẩn & Tảo</option>
                        <option value="sau_hai" {{ ($disease->pathogen_type ?? '') === 'sau_hai' ? 'selected' : '' }}>🐛 Sâu hại & Côn trùng, Nhện</option>
                    </select>
                </div>
            </div>

            <!-- CHỌN NHIỀU CÂY TRỒNG MẪN CẢM -->
            <div class="space-y-2 p-4 rounded-2xl bg-teal-50/50 border border-teal-100">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <label class="font-black text-slate-800 uppercase tracking-wide flex items-center gap-1.5 text-xs">
                        <span>🌱</span> Cây trồng có thể bị bệnh (Chọn một hoặc nhiều cây): <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[11px] text-teal-700 font-semibold">1 bệnh có thể gây hại trên nhiều cây</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-2.5 pt-1">
                    @foreach($crops as $cKey => $cInfo)
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 bg-white hover:bg-teal-50 hover:border-teal-300 transition cursor-pointer text-xs select-none shadow-2xs">
                            <input type="checkbox"
                                   name="crop_ids[]"
                                   value="{{ $cInfo['id'] ?? '' }}"
                                   {{ in_array($cInfo['id'] ?? 0, $linkedCropIds) || (str_contains($disease->crop_name ?? '', $cKey)) ? 'checked' : '' }}
                                   class="chk-crop rounded text-teal-600 focus:ring-teal-500">
                            <span class="font-extrabold text-slate-800">{{ $cInfo['emoji'] }} {{ $cKey }}</span>
                        </label>
                    @endforeach
                </div>
                <input type="hidden" name="crop_name" value="{{ $disease->crop_name }}">
            </div>

            <!-- CÂU NHỚ NẰM LÒNG -->
            <div class="space-y-1.5">
                <label class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                    <span>🧠</span> Câu nhớ nằm lòng (Mẹo nhận diện & hành động nhanh của Kỹ Sư)
                </label>
                <input type="text"
                       name="caunho"
                       id="formCaunho"
                       value="{{ $disease->caunho }}"
                       placeholder="Ví dụ: Alternaria → ĐỐM NÂU; Phytophthora → NƯỚC + XÌ MỦ"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl font-bold text-teal-900 text-sm focus:bg-white focus:ring-2 focus:ring-teal-500 transition">
            </div>
        </div>

        <!-- CARD 2: PHÁC ĐỒ PHÒNG BỆNH & ĐIỀU TRỊ -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="text-lg">📋</span>
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                    2. Phác đồ kỹ thuật & Biện pháp xử lý
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Phòng bệnh -->
                <div class="space-y-1.5">
                    <label class="font-black text-blue-900 text-xs flex items-center gap-1.5">
                        <span>🛡️</span> Biện pháp phòng bệnh & Canh tác
                    </label>
                    <textarea name="prevention"
                              id="formPrevention"
                              rows="6"
                              placeholder="Tỉa cành, làm giàn thông thoáng, nâng pH đất, thoát nước..."
                              class="w-full p-3.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs sm:text-sm font-medium leading-relaxed focus:bg-white focus:ring-2 focus:ring-blue-500 transition">{{ $disease->prevention }}</textarea>
                </div>

                <!-- Điều trị -->
                <div class="space-y-1.5">
                    <label class="font-black text-emerald-900 text-xs flex items-center gap-1.5">
                        <span>💊</span> Biện pháp điều trị & Quản lý
                    </label>
                    <textarea name="treatment"
                              id="formTreatment"
                              rows="6"
                              placeholder="Phun luân phiên hoạt chất, xử lý vết xì mủ, liều lượng..."
                              class="w-full p-3.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs sm:text-sm font-medium leading-relaxed focus:bg-white focus:ring-2 focus:ring-emerald-500 transition">{{ $disease->treatment }}</textarea>
                </div>
            </div>

            <!-- Ghi chú bổ sung -->
            <div class="space-y-1.5">
                <label class="font-extrabold text-slate-700 text-xs flex items-center gap-1.5">
                    <span>📝</span> Ghi chú / Điều kiện thời tiết phát sinh bệnh
                </label>
                <textarea name="notes"
                          rows="3"
                          placeholder="Bệnh phát triển mạnh vào mùa mưa ẩm, nhiệt độ từ 20-28°C..."
                          class="w-full p-3 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-medium leading-relaxed focus:bg-white focus:ring-2 focus:ring-teal-500 transition">{{ $disease->notes }}</textarea>
            </div>
        </div>

        <!-- CARD 3: HOẠT CHẤT ĐẶC TRỊ & SẢN PHẨM TRONG KHO -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-lg">⚗️</span>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                        3. Nhóm hoạt chất khuyến cáo & Liên kết thuốc trong kho
                    </h3>
                </div>
                <button type="button"
                        onclick="tuDongChonThuocTheoHoatChat('editChemicalGroups')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 font-extrabold text-xs border border-teal-200 shadow-2xs transition">
                    <span>⚡</span> Tự động chọn theo hoạt chất
                </button>
            </div>

            <!-- KHỐI TÍCH CHỌN NHÓM HOẠT CHẤT (CHECKBOX SELECTOR) -->
            <div class="space-y-3 p-4 sm:p-5 rounded-2xl bg-teal-50/40 border border-teal-200/80">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <label class="font-black text-slate-800 text-xs sm:text-sm flex items-center gap-1.5 uppercase tracking-wide">
                            <span>⚗️</span> Tích chọn nhóm hoạt chất khuyến cáo điều trị:
                        </label>
                        <p class="text-[11px] text-slate-500 font-medium">
                            💡 Chọn một hoặc nhiều hoạt chất tiêu chuẩn theo mã nhóm FRAC/IRAC để cảnh báo luân phiên chống kháng.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full text-xs font-black bg-teal-100 text-teal-800 border border-teal-200 shadow-2xs">
                            Đã chọn: <strong id="txtCountSelectedChemGroups">0</strong> nhóm
                        </span>
                        <button type="button"
                                onclick="chonTatCaNhomHoatChat(false)"
                                class="text-[11px] text-rose-600 hover:underline font-bold">
                            Bỏ chọn hết
                        </button>
                    </div>
                </div>

                <!-- THANH TÌM KIẾM NHANH HOẠT CHẤT & BỘ LỌC DANH MỤC -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">🔍</span>
                        <input type="text"
                               id="inputFilterChemCatalog"
                               oninput="locDanhSachNhomHoatChat()"
                               placeholder="Lọc nhanh: tên hoạt chất (vd: Azoxystrobin, Cypermethrin), mã FRAC/IRAC..."
                               class="w-full pl-8 pr-8 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs">
                        <button type="button"
                                id="btnClearFilterChemCatalog"
                                onclick="document.getElementById('inputFilterChemCatalog').value='';locDanhSachNhomHoatChat();"
                                class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600 transition hidden text-xs font-bold">
                            ✕
                        </button>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0 overflow-x-auto pb-1 sm:pb-0 text-xs">
                        <button type="button"
                                onclick="locTabNhomHoatChat('all', this)"
                                class="btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-teal-600 text-white shadow-2xs transition">
                            Tất cả
                        </button>
                        <button type="button"
                                onclick="locTabNhomHoatChat('nam', this)"
                                class="btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 transition">
                            🍄 Nấm (FRAC)
                        </button>
                        <button type="button"
                                onclick="locTabNhomHoatChat('sau', this)"
                                class="btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 transition">
                            🐛 Sâu/Ruồi (IRAC)
                        </button>
                        <button type="button"
                                onclick="locTabNhomHoatChat('tuyen_trung_ba', this)"
                                class="btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 transition">
                            🪤 Tuyến trùng & Bả
                        </button>
                    </div>
                </div>

                <!-- DANH SÁCH CHECKBOX CÁC NHÓM HOẠT CHẤT (SCROLLABLE CONTAINER) -->
                <div class="max-h-72 overflow-y-auto border border-teal-200/80 rounded-2xl p-3 bg-white space-y-3.5 scrollbar-thin" id="containerChemicalCatalog">
                    @php
                        $standardChemicalCatalog = [
                            'nam' => [
                                'title' => '🍄 NHÓM TRỪ NẤM BỆNH & KHUẨN (FUNGICIDES - FRAC)',
                                'items' => [
                                    'Hexaconazole / Difenoconazole / Tebuconazole (Triazole - FRAC 3)' => ['code' => 'FRAC 3', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Azoxystrobin / Pyraclostrobin (Strobilurin - FRAC 11)' => ['code' => 'FRAC 11', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Mancozeb / Propineb (Dithiocarbamate - FRAC M03)' => ['code' => 'FRAC M03', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Cuprous Oxide / Đồng Oxychloride / Đồng Nano (Gốc Đồng - FRAC M01)' => ['code' => 'FRAC M01', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Metalaxyl / Metalaxyl-M (Phenylamide - FRAC 4)' => ['code' => 'FRAC 4', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Dimethomorph / Mandipropamid (CAA - FRAC 40)' => ['code' => 'FRAC 40', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Oxathiapiprolin (Piperidinyl thiazole isoxazoline - FRAC 49)' => ['code' => 'FRAC 49', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Fosetyl-Aluminium / Phosphonate (FRAC P07)' => ['code' => 'FRAC P07', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Kasugamycin / Streptomyces (Kháng sinh trừ khuẩn - FRAC 24)' => ['code' => 'FRAC 24', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Validamycin A (Kháng sinh sinh học - FRAC 26)' => ['code' => 'FRAC 26', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Fludioxonil (Phenylpyrrole - FRAC 12)' => ['code' => 'FRAC 12', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Pencycuron (Phenylurea - FRAC 20)' => ['code' => 'FRAC 20', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Chlorothalonil (Chloronitrile - FRAC M05)' => ['code' => 'FRAC M05', 'badge' => 'bg-emerald-100 text-emerald-800'],
                                    'Trichoderma spp. (Chế phẩm sinh học đối kháng)' => ['code' => 'Sinh học', 'badge' => 'bg-teal-100 text-teal-800'],
                                ]
                            ],
                            'sau' => [
                                'title' => '🐛 NHÓM TRỪ SÂU HẠI, CÔN TRÙNG & RUỒI (INSECTICIDES - IRAC)',
                                'items' => [
                                    'Alpha-cypermethrin / Lambda-cyhalothrin / Beta-cypermethrin / Cypermethrin (Cúc tổng hợp Pyrethroid - IRAC 3A)' => ['code' => 'IRAC 3A', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Thiamethoxam / Imidacloprid (Neonicotinoid lưu dẫn - IRAC 4A)' => ['code' => 'IRAC 4A', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Profenofos / Phoxim (Lân hữu cơ Organophosphate - IRAC 1B)' => ['code' => 'IRAC 1B', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Fipronil (Phenylpyrazole làm bả - IRAC 2B)' => ['code' => 'IRAC 2B', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Spinosad (Spinosyn sinh học - IRAC 5)' => ['code' => 'IRAC 5', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Emamectin benzoate / Abamectin (Avermectin - IRAC 6)' => ['code' => 'IRAC 6', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Chlorantraniliprole / Flubendiamide (Diamide - IRAC 28)' => ['code' => 'IRAC 28', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Chlorfenapyr (Pyrrole - IRAC 13)' => ['code' => 'IRAC 13', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Buprofezin (Thiadiazine - IRAC 16)' => ['code' => 'IRAC 16', 'badge' => 'bg-amber-100 text-amber-800'],
                                    'Pyriproxyfen (Điều hòa sinh trưởng côn trùng - IRAC 7C)' => ['code' => 'IRAC 7C', 'badge' => 'bg-amber-100 text-amber-800'],
                                ]
                            ],
                            'tuyen_trung_ba' => [
                                'title' => '🪤 NHÓM TUYẾN TRÙNG, BẪY & BẢ DẪN DỤ SINH HỌC',
                                'items' => [
                                    'Fluopyram (Pyridinyl-ethyl-benzamide - Nematicide)' => ['code' => 'Nematicide', 'badge' => 'bg-purple-100 text-purple-800'],
                                    'Tuyến trùng sinh học / Tinh dầu thực vật' => ['code' => 'Sinh học', 'badge' => 'bg-teal-100 text-teal-800'],
                                    'Protein thủy phân (Bả dẫn dụ đực và cái)' => ['code' => 'Bả mồi', 'badge' => 'bg-sky-100 text-sky-800'],
                                    'Methyl Eugenol (Pheromone dẫn dụ ruồi đực cây ăn quả)' => ['code' => 'Pheromone', 'badge' => 'bg-sky-100 text-sky-800'],
                                    'Cue-lure (Pheromone dẫn dụ ruồi đực bầu bí)' => ['code' => 'Pheromone', 'badge' => 'bg-sky-100 text-sky-800'],
                                ]
                            ],
                        ];

                        $currentSavedGroups = array_filter(array_map('trim', explode(',', $disease->chemical_groups ?? '')));
                        
                        $allCatalogItemKeys = [];
                        foreach ($standardChemicalCatalog as $cSec) {
                            foreach (array_keys($cSec['items']) as $k) {
                                $allCatalogItemKeys[] = $k;
                            }
                        }

                        // Những mục đã lưu của bệnh hiện tại nhưng không nằm trong danh mục chuẩn mẫu
                        $customSavedGroups = array_values(array_filter($currentSavedGroups, function($item) use ($allCatalogItemKeys) {
                            foreach ($allCatalogItemKeys as $ck) {
                                if (strcasecmp($item, $ck) === 0) return false;
                            }
                            return true;
                        }));
                    @endphp

                    @foreach($standardChemicalCatalog as $secKey => $secData)
                        <div class="chem-catalog-section space-y-2" data-section="{{ $secKey }}">
                            <div class="text-[11px] font-black tracking-wide text-slate-700 uppercase flex items-center gap-1.5 pb-1 border-b border-slate-100">
                                <span>{{ $secData['title'] }}</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($secData['items'] as $chemName => $chemMeta)
                                    @php
                                        $isChecked = false;
                                        foreach ($currentSavedGroups as $savedItem) {
                                            if (strcasecmp($savedItem, $chemName) === 0 || stripos($savedItem, explode(' (', $chemName)[0]) !== false) {
                                                $isChecked = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <label class="chem-checkbox-item flex items-start gap-2.5 p-2.5 rounded-xl border border-slate-200 bg-slate-50/70 hover:bg-teal-50/50 hover:border-teal-300 transition cursor-pointer select-none text-xs"
                                           data-section="{{ $secKey }}"
                                           data-search="{{ mb_strtolower($chemName . ' ' . $chemMeta['code']) }}">
                                        <input type="checkbox"
                                               value="{{ $chemName }}"
                                               onchange="dongBoNhomHoatChat()"
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="chk-chem-group rounded border-slate-300 text-teal-600 focus:ring-teal-500 mt-0.5 w-4 h-4 shrink-0">
                                        <div class="flex-1 min-w-0 space-y-0.5">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-black {{ $chemMeta['badge'] }}">
                                                    {{ $chemMeta['code'] }}
                                                </span>
                                            </div>
                                            <div class="font-bold text-slate-900 leading-snug">
                                                {{ $chemName }}
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- KHỐI CÁC MỤC TÙY CHỈNH ĐÃ LƯU / VỪA THÊM -->
                    <div id="sectionCustomChemGroups" class="space-y-2 {{ empty($customSavedGroups) ? 'hidden' : '' }}" data-section="custom">
                        <div class="text-[11px] font-black tracking-wide text-slate-700 uppercase flex items-center gap-1.5 pb-1 border-b border-slate-100">
                            <span>⭐ HOẠT CHẤT BỔ SUNG KHÁC ĐÃ LƯU</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="gridCustomChemItems">
                            @foreach($customSavedGroups as $customItem)
                                <label class="chem-checkbox-item flex items-start gap-2.5 p-2.5 rounded-xl border border-teal-200 bg-teal-50/40 hover:bg-teal-50 transition cursor-pointer select-none text-xs"
                                       data-section="custom"
                                       data-search="{{ mb_strtolower($customItem) }}">
                                    <input type="checkbox"
                                           value="{{ $customItem }}"
                                           onchange="dongBoNhomHoatChat()"
                                           checked
                                           class="chk-chem-group rounded border-slate-300 text-teal-600 focus:ring-teal-500 mt-0.5 w-4 h-4 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-teal-100 text-teal-800">Tự nhập</span>
                                        <div class="font-bold text-slate-900 leading-snug">{{ $customItem }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div id="noChemCatalogMatchNotice" class="hidden p-4 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        Không tìm thấy hoạt chất nào khớp với từ khóa tìm kiếm.
                    </div>
                </div>

                <!-- THÊM NHANH HOẠT CHẤT MỚI TÙY CHỈNH NGOÀI DANH MỤC -->
                <div class="flex items-center gap-2 pt-1">
                    <input type="text"
                           id="inputNewCustomChemName"
                           onkeydown="if(event.key==='Enter'){event.preventDefault();themNhanhHoatChatTuyChinh();}"
                           placeholder="Nhập tên hoạt chất hoặc nhóm mới (nếu chưa có ở trên)..."
                           class="flex-1 px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-teal-500 transition shadow-2xs">
                    <button type="button"
                            onclick="themNhanhHoatChatTuyChinh()"
                            class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-2xs transition shrink-0 active:scale-95 flex items-center gap-1">
                        <span>➕</span> Thêm hoạt chất
                    </button>
                </div>

                <!-- CHUỖI GIÁ TRỊ ĐỒNG BỘ ĐỂ GỬI LÊN SERVER (HIDDEN INPUT) -->
                <input type="hidden"
                       name="chemical_groups"
                       id="editChemicalGroups"
                       value="{{ $disease->chemical_groups }}">
            </div>

            <!-- GẮN THUỐC TRONG KHO -->
            <div class="space-y-2 pt-2">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <label class="font-black text-slate-800 uppercase tracking-wide text-xs">
                        📦 Tích chọn thuốc BVTV trong kho đặc trị bệnh này ({{ count($warehousePesticides) }} sản phẩm):
                    </label>
                    <button type="button"
                            onclick="tuDongChonThuocTheoHoatChat('editChemicalGroups')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-800 font-extrabold text-[11px] border border-teal-200 transition shadow-2xs">
                        <span>⚡</span> Tự động chọn theo hoạt chất
                    </button>
                </div>

                <!-- Ô TÌM KIẾM NHANH THUỐC TRONG DANH SÁCH EDIT -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">🔍</span>
                    <input type="text"
                           id="filterEditPesticidesInput"
                           oninput="locDanhSachThuocEdit()"
                           placeholder="🔍 Lọc nhanh thuốc theo tên, hoạt chất (vd: Validacin, Anvil...)..."
                           class="w-full pl-9 pr-9 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition shadow-2xs placeholder:text-slate-400">
                    <button type="button"
                            id="btnClearFilterEditBtn"
                            onclick="xoaLocThuocEdit()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition hidden text-xs font-bold"
                            title="Xóa tìm kiếm">
                        ✕
                    </button>
                </div>

                <div class="max-h-64 overflow-y-auto border border-slate-200 rounded-2xl p-3 bg-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-2 scrollbar-thin" id="editPesticidesListContainer">
                    @foreach($warehousePesticides as $wp)
                        <label class="edit-pesticide-item flex items-start gap-2.5 p-2 rounded-xl bg-white hover:bg-teal-50/50 border border-slate-200/80 transition cursor-pointer text-xs select-none"
                               data-search="{{ mb_strtolower($wp->name . ' ' . ($wp->active_ingredient ?? '')) }}">
                            <input type="checkbox"
                                   name="pesticide_ids[]"
                                   value="{{ $wp->id }}"
                                   {{ in_array($wp->id, $linkedPesticideIds) ? 'checked' : '' }}
                                   class="chk-pesticide rounded border-slate-300 text-teal-600 focus:ring-teal-500 mt-0.5">
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-slate-900 truncate">{{ $wp->name }}</div>
                                <div class="text-[11px] text-teal-800 font-medium truncate">{{ $wp->active_ingredient ?: 'Chưa rõ hoạt chất' }}</div>
                            </div>
                        </label>
                    @endforeach
                    <div id="noEditPesticideMatchNotice" class="col-span-full hidden p-4 text-center text-xs text-slate-400 bg-white rounded-xl border border-dashed border-slate-200">
                        Không tìm thấy loại thuốc nào phù hợp với từ khóa tìm kiếm.
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 4: QUẢN LÝ HÌNH ẢNH TRIỆU CHỨNG (CRUD ẢNH) -->
        <div id="cardQuanLyAnh" class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📸</span>
                    <div>
                        <h3 class="text-xs sm:text-sm font-black uppercase tracking-wider text-slate-900">
                            4. Quản lý thư viện hình ảnh triệu chứng (CRUD Ảnh)
                        </h3>
                        <p class="text-[11px] text-slate-500 font-medium">
                            Xem trực tiếp, tải ảnh mới từ máy tính, dán link hoặc xóa ảnh thừa tức thì để tối ưu cẩm nang nhận diện.
                        </p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-black bg-teal-50 text-teal-800 border border-teal-200 shadow-2xs" id="currentImageCountBadge">
                    {{ count($disease->images_urls) }} ảnh hiện có
                </span>
            </div>

            <!-- DANH SÁCH ẢNH HIỆN CÓ VỚI NÚT XÓA TỨC THÌ VÀ ĐẶT ẢNH CHÍNH -->
            <div class="space-y-3">
                <div class="flex items-center justify-between flex-wrap gap-1">
                    <label class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                        <span>🖼️</span> Ảnh triệu chứng hiện có trong cơ sở dữ liệu:
                    </label>
                    <span class="text-[11px] text-slate-400">
                        Bấm nút <span class="text-rose-600 font-bold">✕</span> ở góc ảnh để xóa ngay lập tức
                    </span>
                </div>

                @php
                    $rawImagesList = is_array($disease->images) ? $disease->images : ($disease->image ? [$disease->image] : []);
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5" id="existingImagesGrid">
                    @forelse($disease->images_urls as $idx => $imgUrl)
                        @php
                            $rawPath = $rawImagesList[$idx] ?? '';
                        @endphp
                        <div class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 aspect-square shadow-2xs existing-image-card transition duration-200 hover:shadow-md hover:border-teal-400"
                             data-url="{{ $imgUrl }}"
                             data-raw="{{ $rawPath }}"
                             data-index="{{ $idx }}"
                             id="imgCard-{{ $idx }}">
                            <img src="{{ $imgUrl }}" alt="Ảnh bệnh {{ $idx + 1 }}" class="w-full h-full object-cover select-none">
                            
                            <!-- HUY HIỆU ẢNH CHÍNH HOẶC NÚT ĐẶT LÀM ẢNH CHÍNH -->
                            @if($idx === 0)
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-lg bg-teal-600 text-white font-black text-[9px] shadow-sm z-10 flex items-center gap-1">
                                    <span>⭐</span> Ảnh chính
                                </span>
                            @else
                                <button type="button"
                                        onclick="datLamAnhChinh({{ $idx }}, '{{ addslashes($imgUrl) }}')"
                                        class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 px-2 py-0.5 rounded-lg bg-slate-900/80 hover:bg-teal-600 text-white font-extrabold text-[9px] backdrop-blur-xs transition shadow-sm z-10"
                                        title="Đặt ảnh này làm ảnh đại diện chính của bệnh">
                                    ⭐ Đặt chính
                                </button>
                            @endif

                            <!-- NÚT XÓA ẢNH (LUÔN HIỂN THỊ RÕ RÀNG Ở GÓC TRÊN BÊN PHẢI) -->
                            <button type="button"
                                    onclick="xoaAnhHienTai(this, '{{ addslashes($imgUrl) }}', '{{ addslashes($rawPath) }}', {{ $idx }}, 'imgCard-{{ $idx }}')"
                                    class="btn-delete-single-img absolute top-2 right-2 w-7 h-7 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black shadow-md flex items-center justify-center transition transform hover:scale-110 active:scale-90 z-20 cursor-pointer"
                                    title="Xóa ảnh này ngay">
                                ✕
                            </button>

                            <!-- OVERLAY THAO TÁC KHI HOVER -->
                            <div class="absolute inset-0 bg-slate-900/50 opacity-0 group-hover:opacity-100 transition flex items-end justify-center p-2 z-10 pointer-events-none">
                                <span class="text-[10px] text-white font-bold bg-black/60 px-2 py-0.5 rounded-md backdrop-blur-xs">
                                    Ảnh #{{ $idx + 1 }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-300 text-slate-400 text-xs" id="noExistingImagesNotice">
                            Bệnh này hiện chưa có ảnh triệu chứng nào. Bạn có thể chọn file từ máy hoặc dán link bên dưới.
                        </div>
                    @endforelse
                </div>
                <input type="hidden" name="deleted_images" id="inputDeletedImages" value="[]">
            </div>

            <!-- TẢI THÊM ẢNH MỚI TỪ THIẾT BỊ -->
            <div class="space-y-3 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <label class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                        <span>📤</span> Tải thêm ảnh mới từ thiết bị (chọn nhiều ảnh):
                    </label>
                    <span class="text-[11px] text-slate-400 font-normal">Hỗ trợ JPG, PNG, WEBP (Tối đa 5MB/ảnh)</span>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="flex-1 border-2 border-dashed border-teal-200 hover:border-teal-400 rounded-2xl p-3 bg-teal-50/20 text-center transition">
                        <input type="file" 
                               name="images[]" 
                               id="fileInputNewImages" 
                               multiple 
                               accept="image/*" 
                               onchange="hienThiPreviewAnhMoi(this)"
                               class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-teal-600 file:text-white hover:file:bg-teal-700 file:cursor-pointer cursor-pointer">
                    </div>

                    <button type="button"
                            id="btnUploadNow"
                            onclick="taiAnhNgay()"
                            class="px-5 py-3 rounded-2xl bg-teal-600 hover:bg-teal-700 active:scale-95 text-white font-extrabold text-xs shadow-sm transition flex items-center justify-center gap-2 shrink-0 cursor-pointer"
                            title="Tải ảnh lên ngay lập tức mà không cần bấm lưu toàn bộ biểu mẫu">
                        <span>⚡</span>
                        <span>Tải Lên Ngay</span>
                    </button>
                </div>

                <!-- PREVIEW XEM TRƯỚC ẢNH VỪA CHỌN -->
                <div id="previewNewImagesGrid" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 hidden pt-1">
                </div>
            </div>

            <!-- THÊM ẢNH BẰNG ĐƯỜNG DẪN URL TRỰC TIẾP -->
            <div class="space-y-3 pt-4 border-t border-slate-100">
                <label class="font-extrabold text-slate-800 text-xs flex items-center gap-1.5">
                    <span>🔗</span> Hoặc thêm ảnh bằng đường dẫn URL trực tiếp:
                </label>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <input type="url" 
                           id="inputNewUrlDirect"
                           name="new_image_urls" 
                           placeholder="Dán link ảnh trực tuyến (vd: https://example.com/anh-trieu-chung.jpg)" 
                           class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-mono text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-teal-500 transition">

                    <button type="button"
                            id="btnAddUrlNow"
                            onclick="themLinkAnhNgay()"
                            class="px-5 py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-900 active:scale-95 text-white font-extrabold text-xs shadow-sm transition flex items-center justify-center gap-2 shrink-0 cursor-pointer"
                            title="Thêm link ảnh ngay vào thư viện">
                        <span>➕</span>
                        <span>Thêm Link Ngay</span>
                    </button>
                </div>
                <p class="text-[11px] text-slate-500">
                    💡 Hữu ích khi sưu tầm tài liệu hình ảnh trực tuyến từ các viện bảo vệ thực vật hoặc khuyến nông.
                </p>
            </div>
        </div>

        <!-- STICKY ACTION BAR DƯỚI CÙNG -->
        <div class="sticky bottom-4 z-40 bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200/90 shadow-xl flex items-center justify-between flex-wrap gap-3">
            <a href="{{ route('engineer.benh.chi-tiet', $disease->id) }}"
               class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                Hủy bỏ / Quay lại
            </a>

            <div class="flex items-center gap-2">
                <button type="submit"
                        id="btnSubmitEditPage"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-black text-xs transition shadow-md hover:shadow-lg cursor-pointer">
                    <span>💾</span>
                    <span>Lưu Cập Nhật Bệnh Hại</span>
                </button>
            </div>
        </div>

    </form>

</div>

<script>
    // TOAST THÔNG BÁO HIỆN ĐẠI (KHÔNG DÙNG ALERT GÂY CHẶN TRÌNH DUYỆT)
    function showToast(msg, type = 'success') {
        let container = document.getElementById('toastNotificationContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastNotificationContainer';
            container.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 pointer-events-none max-w-sm';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        const bgClass = type === 'error' ? 'bg-rose-600 text-white' : (type === 'warning' ? 'bg-amber-600 text-white' : 'bg-slate-900 text-white border border-slate-700');
        const icon = type === 'error' ? '❌' : (type === 'warning' ? '⚠️' : '✅');

        toast.className = `px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-2.5 text-xs font-bold pointer-events-auto transition-all duration-300 transform translate-y-4 opacity-0 ${bgClass}`;
        toast.innerHTML = `<span class="text-base">${icon}</span> <span class="leading-snug">${msg}</span>`;

        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 350);
        }, 3200);
    }

    // LƯU CẬP NHẬT BIỂU MẪU CHỈNH SỬA
    async function xuLyLuuTrangChinhSua(e) {
        e.preventDefault();
        const form = document.getElementById('formEditDiseasePage');
        const submitBtn = document.getElementById('btnSubmitEditPage');

        const checkedCrops = form.querySelectorAll('input[name="crop_ids[]"]:checked');
        if (checkedCrops.length === 0) {
            showToast('Vui lòng chọn ít nhất 1 loại cây trồng có thể bị bệnh này gây hại!', 'warning');
            return;
        }

        const formData = new FormData(form);
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50');

        try {
            const resp = await fetch('{{ route('engineer.benh.update', $disease->id) }}', {
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

            showToast(resData.message || 'Cập nhật thông tin bệnh thành công!', 'success');
            setTimeout(() => {
                window.location.href = '{{ route('engineer.benh.chi-tiet', $disease->id) }}';
            }, 800);
        } catch (err) {
            showToast('Lỗi: ' + err.message, 'error');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50');
        }
    }

    // TỰ ĐỘNG CHỌN THUỐC TRONG KHO THEO HOẠT CHẤT
    async function tuDongChonThuocTheoHoatChat(inputId) {
        const chemInput = document.getElementById(inputId);
        const chemText = chemInput ? chemInput.value.trim() : '';

        if (!chemText) {
            showToast('Vui lòng nhập nhóm hoạt chất trước khi tìm thuốc!', 'warning');
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

            document.querySelectorAll('#formEditDiseasePage .chk-pesticide').forEach(chk => {
                const val = parseInt(chk.value);
                if (ids.includes(val)) {
                    chk.checked = true;
                    checkedCount++;
                }
            });

            showToast(`Đã tự động tích chọn ${checkedCount} loại thuốc có cùng hoạt chất!`, 'success');
        } catch (err) {
            showToast('Lỗi: ' + err.message, 'error');
        }
    }

    // XÓA ẢNH TỨC THÌ (KHÔNG DÙNG NATIVE CONFIRM / ALERT GÂY NGHẼN BROWSER)
    async function xoaAnhHienTai(btnEl, imgUrl, rawPath, index, cardId) {
        const card = document.getElementById(cardId);
        if (!card) return;

        // Trạng thái chờ trên nút bấm
        btnEl.disabled = true;
        btnEl.innerHTML = '⏳';
        card.classList.add('opacity-50', 'pointer-events-none');

        try {
            const resp = await fetch('{{ route('engineer.benh.delete-image', $disease->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    image_url: imgUrl,
                    raw_path: rawPath,
                    image_index: index,
                }),
            });

            const data = await resp.json();
            if (!resp.ok || !data.success) {
                throw new Error(data.message || 'Lỗi khi xóa ảnh.');
            }

            // Ghi nhận vào mảng deleted_images trong form để đồng bộ khi submit form
            const delInput = document.getElementById('inputDeletedImages');
            let currentDeleted = [];
            try {
                currentDeleted = JSON.parse(delInput.value) || [];
            } catch (e) { currentDeleted = []; }
            currentDeleted.push(imgUrl);
            if (rawPath) currentDeleted.push(rawPath);
            delInput.value = JSON.stringify(currentDeleted);

            // Hiệu ứng xóa mượt mà
            card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.transform = 'scale(0.8)';
            card.style.opacity = '0';

            setTimeout(() => {
                card.remove();
                capNhatSoLuongAnh();
            }, 300);

            showToast('Đã xóa ảnh thành công!', 'success');
        } catch (err) {
            btnEl.disabled = false;
            btnEl.innerHTML = '✕';
            card.classList.remove('opacity-50', 'pointer-events-none');
            showToast('Lỗi: ' + err.message, 'error');
        }
    }

    // CẬP NHẬT BADGE ĐẾM SỐ ẢNH CÒN LẠI
    function capNhatSoLuongAnh() {
        const remaining = document.querySelectorAll('.existing-image-card').length;
        const countBadge = document.getElementById('currentImageCountBadge');
        if (countBadge) countBadge.textContent = `${remaining} ảnh hiện có`;

        if (remaining === 0) {
            const grid = document.getElementById('existingImagesGrid');
            if (grid) {
                grid.innerHTML = '<div class="col-span-full p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-300 text-slate-400 text-xs">Bệnh này hiện chưa có ảnh triệu chứng nào. Bạn có thể chọn file từ máy hoặc dán link bên dưới.</div>';
            }
        }
    }

    // TẢI ẢNH MỚI LÊN NGAY TỨC THÌ (INSTANT AJAX UPLOAD)
    async function taiAnhNgay() {
        const fileInput = document.getElementById('fileInputNewImages');
        if (!fileInput.files || fileInput.files.length === 0) {
            showToast('Vui lòng chọn ít nhất 1 file ảnh từ thiết bị!', 'warning');
            return;
        }

        const btn = document.getElementById('btnUploadNow');
        btn.disabled = true;
        btn.classList.add('opacity-50');
        btn.innerHTML = '<span>⏳ Đang tải...</span>';

        const formData = new FormData();
        Array.from(fileInput.files).forEach(file => {
            formData.append('images[]', file);
        });

        try {
            const resp = await fetch('{{ route('engineer.benh.upload-image', $disease->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await resp.json();
            if (!resp.ok || !data.success) {
                throw new Error(data.message || 'Lỗi khi tải ảnh lên.');
            }

            showToast(data.message || 'Đã tải thêm ảnh thành công!', 'success');
            
            // Tải lại trang để làm mới thư viện ảnh tức thì
            setTimeout(() => {
                window.location.reload();
            }, 600);
        } catch (err) {
            showToast('Lỗi: ' + err.message, 'error');
            btn.disabled = false;
            btn.classList.remove('opacity-50');
            btn.innerHTML = '<span>⚡</span><span>Tải Lên Ngay</span>';
        }
    }

    // THÊM LINK ẢNH TRỰC TUYẾN NGAY (INSTANT URL ADD)
    async function themLinkAnhNgay() {
        const input = document.getElementById('inputNewUrlDirect');
        const url = input ? input.value.trim() : '';

        if (!url) {
            showToast('Vui lòng nhập đường dẫn URL ảnh (https://...)!', 'warning');
            return;
        }

        const btn = document.getElementById('btnAddUrlNow');
        btn.disabled = true;
        btn.classList.add('opacity-50');

        try {
            const resp = await fetch('{{ route('engineer.benh.upload-image', $disease->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ image_url: url }),
            });

            const data = await resp.json();
            if (!resp.ok || !data.success) {
                throw new Error(data.message || 'Lỗi khi thêm link ảnh.');
            }

            showToast('Đã thêm ảnh từ liên kết thành công!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 600);
        } catch (err) {
            showToast('Lỗi: ' + err.message, 'error');
            btn.disabled = false;
            btn.classList.remove('opacity-50');
        }
    }

    // ĐẶT LÀM ẢNH ĐẠI DIỆN CHÍNH
    async function datLamAnhChinh(index, url) {
        try {
            const resp = await fetch('{{ route('engineer.benh.set-primary-image', $disease->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ image_index: index, image_url: url }),
            });

            const data = await resp.json();
            if (!resp.ok || !data.success) {
                throw new Error(data.message || 'Lỗi khi đặt ảnh chính.');
            }

            showToast('Đã đặt làm ảnh chính!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 600);
        } catch (err) {
            showToast('Lỗi: ' + err.message, 'error');
        }
    }

    // HIỂN THỊ PREVIEW KHI CHỌN FILE
    function hienThiPreviewAnhMoi(input) {
        const previewGrid = document.getElementById('previewNewImagesGrid');
        previewGrid.innerHTML = '';

        if (input.files && input.files.length > 0) {
            previewGrid.classList.remove('hidden');
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const card = document.createElement('div');
                    card.className = 'relative rounded-2xl overflow-hidden border border-teal-400 bg-slate-50 aspect-square shadow-2xs animate-in zoom-in-95';
                    card.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded-md bg-teal-800 text-white font-extrabold text-[9px] shadow-xs">Mới #${index + 1}</span>
                    `;
                    previewGrid.appendChild(card);
                };
                reader.readAsDataURL(file);
            });
        } else {
            previewGrid.classList.add('hidden');
        }
    }

    /* ========================================================
     * BỘ LỌC TỨC THÌ (REAL-TIME LIVE SEARCH) THUỐC TRONG FORM EDIT
     * ======================================================== */
    function xoaDauTiengVietEdit(str) {
        if (!str) return '';
        return str.toString().toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[đĐ]/g, 'd')
            .trim();
    }

    function locDanhSachThuocEdit() {
        const input = document.getElementById('filterEditPesticidesInput');
        const raw = input ? input.value.trim() : '';
        const q = xoaDauTiengVietEdit(raw);
        const clearBtn = document.getElementById('btnClearFilterEditBtn');
        if (clearBtn) clearBtn.classList.toggle('hidden', raw === '');

        let matchCount = 0;
        document.querySelectorAll('.edit-pesticide-item').forEach(item => {
            const searchStr = xoaDauTiengVietEdit(item.dataset.search || '');
            const match = !q || searchStr.includes(q);
            item.classList.toggle('hidden', !match);
            if (match) matchCount++;
        });

        const emptyNotice = document.getElementById('noEditPesticideMatchNotice');
        if (emptyNotice) emptyNotice.classList.toggle('hidden', matchCount > 0);
    }

    function xoaLocThuocEdit() {
        const input = document.getElementById('filterEditPesticidesInput');
        if (input) {
            input.value = '';
            input.focus();
        }
        locDanhSachThuocEdit();
    }

    /* ========================================================
     * QUẢN LÝ CHECKBOX NHÓM HOẠT CHẤT (CHEMICAL GROUPS SELECTOR)
     * ======================================================== */
    let tabHoatChatHienTai = 'all';

    function dongBoNhomHoatChat() {
        const checkedList = Array.from(document.querySelectorAll('.chk-chem-group:checked'))
            .map(cb => cb.value.trim())
            .filter(v => v !== '');

        const hiddenInput = document.getElementById('editChemicalGroups');
        if (hiddenInput) {
            hiddenInput.value = checkedList.join(', ');
        }

        const countBadge = document.getElementById('txtCountSelectedChemGroups');
        if (countBadge) {
            countBadge.textContent = checkedList.length;
        }
    }

    function locTabNhomHoatChat(tabKey, btn) {
        tabHoatChatHienTai = tabKey;
        
        document.querySelectorAll('.btn-tab-chem').forEach(b => {
            b.className = 'btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white text-slate-600 border border-slate-200 hover:bg-slate-100 transition';
        });
        if (btn) {
            btn.className = 'btn-tab-chem px-2.5 py-1 rounded-lg text-[11px] font-bold bg-teal-600 text-white shadow-2xs transition';
        }

        locDanhSachNhomHoatChat();
    }

    function locDanhSachNhomHoatChat() {
        const input = document.getElementById('inputFilterChemCatalog');
        const raw = input ? input.value.trim() : '';
        const q = xoaDauTiengVietEdit(raw);
        const clearBtn = document.getElementById('btnClearFilterChemCatalog');
        if (clearBtn) clearBtn.classList.toggle('hidden', raw === '');

        let totalVisible = 0;

        document.querySelectorAll('.chem-catalog-section, #sectionCustomChemGroups').forEach(sec => {
            const secKey = sec.dataset.section;
            let secHasVisible = false;

            // Kiểm tra tab
            const passTab = tabHoatChatHienTai === 'all' || tabHoatChatHienTai === secKey;

            sec.querySelectorAll('.chem-checkbox-item').forEach(item => {
                if (!passTab) {
                    item.classList.add('hidden');
                    return;
                }

                const searchStr = xoaDauTiengVietEdit(item.dataset.search || '');
                const match = !q || searchStr.includes(q);
                item.classList.toggle('hidden', !match);

                if (match) {
                    secHasVisible = true;
                    totalVisible++;
                }
            });

            // Nếu toàn bộ mục trong section bị ẩn thì ẩn section đó
            sec.classList.toggle('hidden', !secHasVisible);
        });

        const emptyNotice = document.getElementById('noChemCatalogMatchNotice');
        if (emptyNotice) emptyNotice.classList.toggle('hidden', totalVisible > 0);
    }

    function chonTatCaNhomHoatChat(status) {
        document.querySelectorAll('.chem-checkbox-item:not(.hidden) .chk-chem-group').forEach(cb => {
            cb.checked = status;
        });
        dongBoNhomHoatChat();
    }

    function themNhanhHoatChatTuyChinh() {
        const inp = document.getElementById('inputNewCustomChemName');
        const val = inp ? inp.value.trim() : '';
        if (!val) {
            showToast('Vui lòng nhập tên hoạt chất mới!', 'warning');
            return;
        }

        // Kiểm tra xem đã có checkbox nào mang giá trị này chưa
        let exists = false;
        document.querySelectorAll('.chk-chem-group').forEach(cb => {
            if (cb.value.trim().toLowerCase() === val.toLowerCase()) {
                cb.checked = true;
                exists = true;
            }
        });

        if (!exists) {
            const container = document.getElementById('gridCustomChemItems');
            const sec = document.getElementById('sectionCustomChemGroups');
            if (container && sec) {
                const label = document.createElement('label');
                label.className = 'chem-checkbox-item flex items-start gap-2.5 p-2.5 rounded-xl border border-teal-200 bg-teal-50/40 hover:bg-teal-50 transition cursor-pointer select-none text-xs';
                label.dataset.section = 'custom';
                label.dataset.search = val.toLowerCase();
                label.innerHTML = `
                    <input type="checkbox"
                           value="${val}"
                           onchange="dongBoNhomHoatChat()"
                           checked
                           class="chk-chem-group rounded border-slate-300 text-teal-600 focus:ring-teal-500 mt-0.5 w-4 h-4 shrink-0">
                    <div class="flex-1 min-w-0">
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-teal-100 text-teal-800">Mới thêm</span>
                        <div class="font-bold text-slate-900 leading-snug">${val}</div>
                    </div>
                `;
                container.appendChild(label);
                sec.classList.remove('hidden');
            }
        }

        if (inp) inp.value = '';
        dongBoNhomHoatChat();
        showToast(`Đã thêm và chọn: "${val}"`, 'success');
    }

    // Khởi tạo đếm số lượng khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        dongBoNhomHoatChat();
    });
</script>
</x-layouts.engineer>
