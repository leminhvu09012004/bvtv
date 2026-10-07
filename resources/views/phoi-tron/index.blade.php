<x-layouts.app title="Tra Cứu Kỵ Phối Trộn Thuốc BVTV">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto space-y-8">

    <!-- 1. HEADER SECTION -->
    <div class="relative bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-xl overflow-hidden border border-emerald-700/40">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-20 top-0 w-48 h-48 bg-teal-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs px-3 py-1 rounded-full font-medium mb-3 backdrop-blur-xs">
                <span>⚖️ Cẩm Nang Nông Nghiệp & Tank-Mix</span>
                <span>•</span>
                <span>An Toàn Cây Trồng</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight text-white flex items-center gap-2.5">
                <span>🚫</span> Tra Cứu Tương Kỵ & Kỵ Phối Trộn Thuốc BVTV
            </h1>
            <p class="text-emerald-100/90 text-sm lg:text-base mt-2.5 leading-relaxed">
                Hệ thống phân tích tương thích hóa lý và sinh học khi phối trộn nhiều loại thuốc bảo vệ thực vật. Tránh kết tủa nghẹt béc, cháy lá, nứt trái, làm mất hoạt lực thuốc hoặc gia tăng tính kháng thuốc.
            </p>

            <div class="flex flex-wrap items-center gap-2.5 mt-5 text-xs font-semibold">
                <span class="inline-flex items-center gap-1.5 bg-red-500/20 text-red-200 border border-red-400/30 px-3 py-1.5 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                    🔴 Cấm kỵ: Cháy lá, kết tủa
                </span>
                <span class="inline-flex items-center gap-1.5 bg-amber-500/20 text-amber-200 border border-amber-400/30 px-3 py-1.5 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    🟡 Thận trọng: Trùng cơ chế, EC
                </span>
                <span class="inline-flex items-center gap-1.5 bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 px-3 py-1.5 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    🟢 An toàn: Phối hợp cộng lực
                </span>
            </div>
        </div>
    </div>

    <!-- 2. INTERACTIVE TANK-MIX CHECKER WIDGET -->
    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <h2 class="text-lg lg:text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700 text-base">🧪</span>
                    Công Cụ Kiểm Tra Phối Trộn Trực Quan
                </h2>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    Hỗ trợ phân tích tương kỵ theo từng sản phẩm cụ thể hoặc quét nhanh giữa 2 danh mục
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="inline-flex p-1 bg-gray-100 rounded-2xl border border-gray-200/80 shadow-2xs">
                <button type="button" id="tab-btn-product" onclick="chuyenTabMixer('product')"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer {{ isset($initialCatResult) ? 'text-gray-600 hover:text-gray-900' : 'bg-white text-emerald-800 shadow-xs' }}">
                    <span>💊</span>
                    <span>Theo Từng Sản Phẩm</span>
                </button>
                <button type="button" id="tab-btn-category" onclick="chuyenTabMixer('category')"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer {{ isset($initialCatResult) ? 'bg-white text-emerald-800 shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>📂</span>
                    <span>Theo Danh Mục</span>
                    <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.5 rounded-full font-extrabold uppercase">Mới</span>
                </button>
            </div>
        </div>

        <!-- 2A. TAB TỪNG SẢN PHẨM -->
        <div id="section-mixer-product" class="{{ isset($initialCatResult) ? 'hidden' : '' }}">
            <div class="flex items-center justify-between gap-2 pt-4 pb-1">
                <p class="text-xs text-gray-500">
                    Chọn 2 sản phẩm cụ thể để phân tích phản ứng tương kỵ và thứ tự pha vào phuy:
                </p>
                <!-- Nút bấm nhanh các cặp kinh điển -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-xs text-gray-400 font-medium hidden sm:inline">Thử nhanh:</span>
                    <button type="button" onclick="chonCapMau('dau_khoang', 'luu_huynh')"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Dầu khoáng + Lưu huỳnh
                    </button>
                    <button type="button" onclick="chonCapMau('dong_do', 'vi_sinh')"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Gốc Đồng + Vi sinh
                    </button>
                    <button type="button" onclick="chonCapMau('canxi', 'mkp')"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Canxi + MKP
                    </button>
                </div>
            </div>

            <!-- FORM CHỌN THUỐC -->
            <div class="grid grid-cols-1 md:grid-cols-11 gap-4 items-center mt-4">
                <!-- Thuốc 1 -->
                <div class="md:col-span-5 bg-gray-50/70 p-4 rounded-2xl border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-200 transition-all">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-600 text-white inline-flex items-center justify-center text-[10px]">1</span>
                        Sản phẩm thuốc thứ nhất
                    </label>
                    <select id="select-thuoc-1" class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm font-medium text-gray-800 focus:outline-none focus:border-emerald-500 shadow-2xs">
                        <option value="">-- Chọn sản phẩm thuốc A --</option>
                        @foreach($pesticides as $p)
                            <option value="{{ $p->id }}" {{ (isset($initialP1) && $initialP1->id === $p->id) ? 'selected' : '' }}
                                data-name="{{ $p->name }}"
                                data-active="{{ $p->active_ingredient }}"
                                data-category="{{ $p->category?->name }}"
                                data-form="{{ $p->form_type }}">
                                {{ $p->name }} {{ $p->active_ingredient ? '(' . Str::limit($p->active_ingredient, 35) . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div id="info-thuoc-1" class="mt-2 text-xs text-gray-500 truncate min-h-[18px]">
                        @if(isset($initialP1))
                            <span class="text-emerald-700 font-semibold">Hoạt chất:</span> {{ $initialP1->active_ingredient ?? 'Chưa rõ' }}
                        @else
                            Chưa chọn sản phẩm
                        @endif
                    </div>
                </div>

                <!-- Nút Hoán Đổi (Swap) -->
                <div class="md:col-span-1 flex justify-center">
                    <button type="button" onclick="hoanDoiThuoc()" title="Đổi chỗ 2 loại thuốc"
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-emerald-100 hover:text-emerald-700 text-gray-600 border border-gray-200 flex items-center justify-center text-sm font-bold shadow-2xs transition-all hover:scale-105 cursor-pointer">
                        ⇄
                    </button>
                </div>

                <!-- Thuốc 2 -->
                <div class="md:col-span-5 bg-gray-50/70 p-4 rounded-2xl border border-gray-200 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-200 transition-all">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-teal-600 text-white inline-flex items-center justify-center text-[10px]">2</span>
                        Sản phẩm thuốc thứ hai
                    </label>
                    <select id="select-thuoc-2" class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm font-medium text-gray-800 focus:outline-none focus:border-emerald-500 shadow-2xs">
                        <option value="">-- Chọn sản phẩm thuốc B --</option>
                        @foreach($pesticides as $p)
                            <option value="{{ $p->id }}" {{ (isset($initialP2) && $initialP2->id === $p->id) ? 'selected' : '' }}
                                data-name="{{ $p->name }}"
                                data-active="{{ $p->active_ingredient }}"
                                data-category="{{ $p->category?->name }}"
                                data-form="{{ $p->form_type }}">
                                {{ $p->name }} {{ $p->active_ingredient ? '(' . Str::limit($p->active_ingredient, 35) . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div id="info-thuoc-2" class="mt-2 text-xs text-gray-500 truncate min-h-[18px]">
                        @if(isset($initialP2))
                            <span class="text-teal-700 font-semibold">Hoạt chất:</span> {{ $initialP2->active_ingredient ?? 'Chưa rõ' }}
                        @else
                            Chưa chọn sản phẩm
                        @endif
                    </div>
                </div>
            </div>

            <!-- Nút bấm kiểm tra thuốc -->
            <div class="mt-5 flex justify-center">
                <button type="button" id="btn-kiem-tra" onclick="thucHienKiemTra()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white font-bold px-8 py-3.5 rounded-2xl shadow-md hover:shadow-lg transition-all text-sm cursor-pointer hover:-translate-y-0.5">
                    <span>⚡</span>
                    <span>Phân Tích Tương Kỵ & Thứ Tự Pha</span>
                </button>
            </div>

            <!-- KHU VỰC HIỂN THỊ KẾT QUẢ PHÂN TÍCH THUỐC -->
            <div id="ket-qua-container" class="mt-8 transition-all {{ isset($initialResult) ? '' : 'hidden' }}">
                @if(isset($initialResult))
                    @include('phoi-tron._ket-qua-partial', ['result' => $initialResult])
                @endif
            </div>
        </div>

        <!-- 2B. TAB DANH MỤC SẢN PHẨM -->
        <div id="section-mixer-category" class="{{ isset($initialCatResult) ? '' : 'hidden' }}">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-4 pb-1">
                <p class="text-xs sm:text-sm text-gray-600 font-medium">
                    Chọn 2 danh mục để quét và liệt kê chi tiết các sản phẩm xung đột kỵ nhau giữa hai nhóm:
                </p>

                <!-- Thử nhanh các cặp danh mục -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-xs text-gray-400 font-medium hidden sm:inline">Gợi ý kiểm tra:</span>
                    <button type="button" onclick="chonCapDanhMucMau('che-pham-vi-sinh', 'thuoc-tru-benh')"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Vi sinh ⟷ Trừ bệnh
                    </button>
                    <button type="button" onclick="chonCapDanhMucMau('thuoc-tru-co', 'phan-bon-la')"
                        class="text-xs bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Trừ cỏ ⟷ Phân bón lá
                    </button>
                    <button type="button" onclick="chonCapDanhMucMau('phan-bon-la', 'phan-bon-la')"
                        class="text-xs bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 px-2 py-1 rounded-lg font-semibold transition-colors cursor-pointer">
                        Phân bón lá nội bộ
                    </button>
                </div>
            </div>

            <!-- FORM CHỌN DANH MỤC -->
            <div class="grid grid-cols-1 md:grid-cols-11 gap-4 items-center mt-4">
                <!-- Danh mục 1 -->
                <div class="md:col-span-5 bg-teal-50/40 p-4 rounded-2xl border border-teal-200/80 focus-within:border-teal-500 focus-within:ring-2 focus-within:ring-teal-200 transition-all">
                    <label class="block text-xs font-bold text-teal-900 mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-teal-700 text-white inline-flex items-center justify-center text-[10px]">A</span>
                        Danh mục sản phẩm thứ nhất
                    </label>
                    <select id="select-danhmuc-1" class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm font-medium text-gray-800 focus:outline-none focus:border-teal-500 shadow-2xs">
                        <option value="">-- Chọn danh mục A --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" data-slug="{{ $cat->slug }}" {{ (isset($initialCat1Id) && $initialCat1Id === $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->pesticides_count }} sản phẩm)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nút Hoán Đổi (Swap) Danh mục -->
                <div class="md:col-span-1 flex justify-center">
                    <button type="button" onclick="hoanDoiDanhMuc()" title="Đổi chỗ 2 danh mục"
                        class="w-10 h-10 rounded-full bg-gray-100 hover:bg-teal-100 hover:text-teal-700 text-gray-600 border border-gray-200 flex items-center justify-center text-sm font-bold shadow-2xs transition-all hover:scale-105 cursor-pointer">
                        ⇄
                    </button>
                </div>

                <!-- Danh mục 2 -->
                <div class="md:col-span-5 bg-teal-50/40 p-4 rounded-2xl border border-teal-200/80 focus-within:border-teal-500 focus-within:ring-2 focus-within:ring-teal-200 transition-all">
                    <label class="block text-xs font-bold text-teal-900 mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-teal-700 text-white inline-flex items-center justify-center text-[10px]">B</span>
                        Danh mục sản phẩm thứ hai
                    </label>
                    <select id="select-danhmuc-2" class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm font-medium text-gray-800 focus:outline-none focus:border-teal-500 shadow-2xs">
                        <option value="">-- Chọn danh mục B --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" data-slug="{{ $cat->slug }}" {{ (isset($initialCat2Id) && $initialCat2Id === $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->pesticides_count }} sản phẩm)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nút bấm kiểm tra danh mục -->
            <div class="mt-5 flex justify-center">
                <button type="button" id="btn-kiem-tra-danh-muc" onclick="thucHienKiemTraDanhMuc()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-700 to-emerald-700 hover:from-teal-800 hover:to-emerald-800 text-white font-bold px-8 py-3.5 rounded-2xl shadow-md hover:shadow-lg transition-all text-sm cursor-pointer hover:-translate-y-0.5">
                    <span>⚡</span>
                    <span>Quét Tương Kỵ & Tìm Sản Phẩm Xung Đột</span>
                </button>
            </div>

            <!-- KHU VỰC HIỂN THỊ KẾT QUẢ PHÂN TÍCH DANH MỤC -->
            <div id="ket-qua-category-container" class="mt-8 transition-all {{ isset($initialCatResult) ? '' : 'hidden' }}">
                @if(isset($initialCatResult))
                    @include('phoi-tron._ket-qua-category-partial', ['catResult' => $initialCatResult])
                @endif
            </div>
        </div>
    </div>

    <!-- 3. BẢNG MA TRẬN TƯƠNG KỴ KINH ĐIỂN (COMPATIBILITY MATRIX) -->
    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-gray-100">
            <div>
                <h2 class="text-lg lg:text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="p-1.5 rounded-lg bg-teal-100 text-teal-700 text-base">📊</span>
                    Bảng Ma Trận Tương Kỵ Các Nhóm Hợp Chất Nông Nghiệp
                </h2>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">
                    Tra cứu nhanh quy tắc phối trộn giữa các nhóm thuốc bảo vệ thực vật và phân bón lá phổ biến
                </p>
            </div>

            <!-- Chú thích màu -->
            <div class="flex items-center gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1.5 text-red-700 bg-red-50 border border-red-200 px-2.5 py-1 rounded-lg">
                    <span>❌</span> Cấm kỵ
                </span>
                <span class="inline-flex items-center gap-1.5 text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-lg">
                    <span>⚠️</span> Thận trọng
                </span>
                <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg">
                    <span>✅</span> An toàn
                </span>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700">
                        <th class="p-3 border border-gray-200 font-bold min-w-[160px] bg-gray-100">Nhóm Thuốc</th>
                        @foreach($matrixData['keys'] as $colKey)
                            @php $gInfo = $matrixData['groups'][$colKey] ?? null; @endphp
                            <th class="p-2.5 border border-gray-200 font-semibold text-center min-w-[110px]" title="{{ $gInfo['examples'] ?? '' }}">
                                <div class="text-base">{{ $gInfo['icon'] ?? '💊' }}</div>
                                <div class="truncate max-w-[100px] mt-0.5">{{ $gInfo['name'] ?? $colKey }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($matrixData['keys'] as $rowKey)
                        @php $rInfo = $matrixData['groups'][$rowKey] ?? null; @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="p-3 border border-gray-200 font-bold text-gray-800 bg-gray-50 whitespace-nowrap">
                                <span class="mr-1">{{ $rInfo['icon'] ?? '💊' }}</span>
                                <span>{{ $rInfo['name'] ?? $rowKey }}</span>
                            </td>
                            @foreach($matrixData['keys'] as $colKey)
                                @php $cell = $matrixData['matrix'][$rowKey][$colKey] ?? null; @endphp
                                <td class="p-2 border border-gray-200 text-center {{ $cell['class'] ?? '' }} cursor-pointer hover:opacity-85 transition-opacity"
                                    onclick="hienThiGiaiThichMaTran('{{ addslashes($rInfo['name'] ?? $rowKey) }}', '{{ addslashes($matrixData['groups'][$colKey]['name'] ?? $colKey) }}', '{{ addslashes($cell['label'] ?? '') }}', '{{ addslashes($cell['title'] ?? '') }}', '{{ addslashes($cell['reason'] ?? '') }}')">
                                    <span class="inline-block px-1 py-0.5 rounded text-[11px] font-bold">
                                        {{ $cell['label'] ?? '—' }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-gray-400 mt-2.5 italic">
            💡 Mẹo: Nhấp chuột vào bất kỳ ô nào trong bảng ma trận để xem phân tích chi tiết phản ứng hóa lý giữa 2 nhóm.
        </p>
    </div>

    <!-- 4. NGUYÊN TẮC VÀNG & THỬ NGHIỆM CỐC NƯỚC (JAR TEST) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 4.1. Quy trình thử nghiệm cốc nước -->
        <div class="bg-gradient-to-br from-amber-500/10 via-amber-50 to-orange-50/40 rounded-3xl p-6 lg:p-7 border border-amber-200 shadow-xs">
            <h3 class="text-base font-bold text-amber-950 flex items-center gap-2">
                <span class="text-xl">🫙</span>
                Quy Trình Thử Nghiệm Cốc Nước (Jar Test)
            </h3>
            <p class="text-xs text-amber-800 mt-1 leading-relaxed">
                Phương pháp kiểm tra bắt buộc trước khi pha chung thuốc lạ vào phuy lớn 200 - 400 lít nước để tránh hỏng cả phuy thuốc và cháy lá cây.
            </p>

            <div class="mt-4 space-y-2.5">
                @foreach($guideData['jar_test_steps'] as $idx => $step)
                    <div class="flex items-start gap-2.5 bg-white/80 p-3 rounded-xl border border-amber-200/60 shadow-2xs">
                        <span class="shrink-0 w-6 h-6 rounded-full bg-amber-600 text-white font-bold text-xs flex items-center justify-center">
                            {{ $idx + 1 }}
                        </span>
                        <p class="text-xs text-gray-800 leading-relaxed font-medium">
                            {{ $step }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 4.2. Bảng thứ tự rót thuốc vào phuy (W-A-L-E-S) -->
        <div class="bg-gradient-to-br from-emerald-500/10 via-emerald-50 to-teal-50/40 rounded-3xl p-6 lg:p-7 border border-emerald-200 shadow-xs">
            <h3 class="text-base font-bold text-emerald-950 flex items-center gap-2">
                <span class="text-xl">📋</span>
                Nguyên Tắc Vàng: Thứ Tự Rót Thuốc Vào Phuy
            </h3>
            <p class="text-xs text-emerald-800 mt-1 leading-relaxed">
                Tuân thủ quy chuẩn quốc tế <strong>W-A-L-E-S</strong>: Dạng khó tan hòa tan trước, dạng lỏng tan nhanh cho vào sau cùng.
            </p>

            <div class="mt-4 space-y-2.5">
                <div class="bg-white/80 p-3 rounded-xl border border-emerald-200/60 shadow-2xs flex items-start gap-3">
                    <span class="shrink-0 font-bold px-2 py-0.5 rounded bg-emerald-600 text-white text-xs">1. WG / WP</span>
                    <div class="text-xs text-gray-800 leading-relaxed">
                        <strong>Dạng Bột & Hạt phân tán:</strong> Cho vào xô hòa tan hoàn toàn trước tiên khi phuy mới có khoảng 1/2 lượng nước.
                    </div>
                </div>

                <div class="bg-white/80 p-3 rounded-xl border border-emerald-200/60 shadow-2xs flex items-start gap-3">
                    <span class="shrink-0 font-bold px-2 py-0.5 rounded bg-teal-600 text-white text-xs">2. SC / FS</span>
                    <div class="text-xs text-gray-800 leading-relaxed">
                        <strong>Dạng Huyền phù đậm đặc:</strong> Lắc đều chai rồi đổ vào phuy, khuấy nhẹ cho hòa tan đồng nhất.
                    </div>
                </div>

                <div class="bg-white/80 p-3 rounded-xl border border-emerald-200/60 shadow-2xs flex items-start gap-3">
                    <span class="shrink-0 font-bold px-2 py-0.5 rounded bg-amber-600 text-white text-xs">3. EC / EW</span>
                    <div class="text-xs text-gray-800 leading-relaxed">
                        <strong>Dạng Nhũ dầu:</strong> Cho vào sau khi các dạng bột đã tan hết, để dung môi nhũ hóa phân tán tự do.
                    </div>
                </div>

                <div class="bg-white/80 p-3 rounded-xl border border-emerald-200/60 shadow-2xs flex items-start gap-3">
                    <span class="shrink-0 font-bold px-2 py-0.5 rounded bg-blue-600 text-white text-xs">4. SL / L</span>
                    <div class="text-xs text-gray-800 leading-relaxed">
                        <strong>Dạng Dung dịch nước:</strong> Đổ trực tiếp vào phuy.
                    </div>
                </div>

                <div class="bg-white/80 p-3 rounded-xl border border-emerald-200/60 shadow-2xs flex items-start gap-3">
                    <span class="shrink-0 font-bold px-2 py-0.5 rounded bg-purple-600 text-white text-xs">5. Phân bón & Bám dính</span>
                    <div class="text-xs text-gray-800 leading-relaxed">
                        <strong>Phân bón lá & Chất loang trải:</strong> Cho vào cuối cùng, bổ sung đủ lượng nước phuy và khuấy đều lần cuối.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal xem chi tiết ô ma trận -->
<div id="matrix-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4" onclick="if(event.target===this)dongModalMaTran()">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100">
        <div class="flex items-start justify-between gap-3 border-b border-gray-100 pb-3">
            <div id="modal-matrix-header">
                <span id="modal-matrix-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-1"></span>
                <h4 id="modal-matrix-title" class="text-base font-bold text-gray-900"></h4>
            </div>
            <button type="button" onclick="dongModalMaTran()" class="w-8 h-8 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-700 flex items-center justify-center text-lg font-bold">
                &times;
            </button>
        </div>
        <div class="mt-4 space-y-3 text-xs leading-relaxed text-gray-700">
            <div>
                <strong class="text-gray-900">Cặp so sánh:</strong>
                <p id="modal-matrix-pair" class="text-gray-600 mt-0.5"></p>
            </div>
            <div>
                <strong class="text-gray-900">Phân tích & Lý do:</strong>
                <p id="modal-matrix-reason" class="text-gray-600 mt-0.5 leading-relaxed"></p>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="button" onclick="dongModalMaTran()" class="px-5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-colors">
                Đóng
            </button>
        </div>
    </div>
</div>

<script>
    // Dữ liệu thuốc mẫu để thử nhanh
    const sampleProducts = {!! json_encode($sampleProducts) !!};

    document.getElementById('select-thuoc-1')?.addEventListener('change', function() {
        capNhatInfoThuoc(1, this);
    });
    document.getElementById('select-thuoc-2')?.addEventListener('change', function() {
        capNhatInfoThuoc(2, this);
    });

    function capNhatInfoThuoc(num, selectEl) {
        const infoEl = document.getElementById('info-thuoc-' + num);
        const opt = selectEl.options[selectEl.selectedIndex];
        if (!opt || !opt.value) {
            infoEl.innerHTML = 'Chưa chọn sản phẩm';
            return;
        }
        const active = opt.getAttribute('data-active') || 'Chưa rõ';
        const form = opt.getAttribute('data-form') || '';
        infoEl.innerHTML = `<span class="text-${num === 1 ? 'emerald' : 'teal'}-700 font-semibold">Hoạt chất:</span> ${active} ${form ? '• Dạng: ' + form : ''}`;
    }

    function hoanDoiThuoc() {
        const s1 = document.getElementById('select-thuoc-1');
        const s2 = document.getElementById('select-thuoc-2');
        const val1 = s1.value;
        const val2 = s2.value;
        s1.value = val2;
        s2.value = val1;
        capNhatInfoThuoc(1, s1);
        capNhatInfoThuoc(2, s2);
        if (s1.value && s2.value) {
            thucHienKiemTra();
        }
    }

    function chonCapMau(typeA, typeB) {
        const s1 = document.getElementById('select-thuoc-1');
        const s2 = document.getElementById('select-thuoc-2');

        let pA = null;
        let pB = null;

        if (typeA === 'dau_khoang') {
            pA = sampleProducts.find(p => /dầu khoáng|enspray/i.test(p.name + ' ' + p.active));
        } else if (typeA === 'dong_do') {
            pA = sampleProducts.find(p => /đồng|nordox|coc 85/i.test(p.name + ' ' + p.active));
        } else if (typeA === 'canxi') {
            pA = sampleProducts.find(p => /canxi/i.test(p.name + ' ' + p.active));
        }

        if (typeB === 'luu_huynh') {
            pB = sampleProducts.find(p => /lưu huỳnh|thiovit|kumulus/i.test(p.name + ' ' + p.active));
        } else if (typeB === 'vi_sinh') {
            pB = sampleProducts.find(p => p.cat === 'che-pham-vi-sinh' || /trichoderma|vi sinh/i.test(p.name + ' ' + p.active));
        } else if (typeB === 'mkp') {
            pB = sampleProducts.find(p => /mkp|lân 86/i.test(p.name + ' ' + p.active));
        }

        if (pA) {
            s1.value = pA.id;
            capNhatInfoThuoc(1, s1);
        }
        if (pB) {
            s2.value = pB.id;
            capNhatInfoThuoc(2, s2);
        }

        if (pA && pB) {
            thucHienKiemTra();
        } else {
            alert('Không tìm thấy đủ 2 sản phẩm mẫu khớp với nhóm này trong danh mục hiện tại.');
        }
    }

    function chuyenTabMixer(tab) {
        const secProd = document.getElementById('section-mixer-product');
        const secCat = document.getElementById('section-mixer-category');
        const btnProd = document.getElementById('tab-btn-product');
        const btnCat = document.getElementById('tab-btn-category');

        if (tab === 'product') {
            secProd.classList.remove('hidden');
            secCat.classList.add('hidden');
            btnProd.className = 'flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer bg-white text-emerald-800 shadow-xs';
            btnCat.className = 'flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer text-gray-600 hover:text-gray-900';
        } else {
            secCat.classList.remove('hidden');
            secProd.classList.add('hidden');
            btnCat.className = 'flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer bg-white text-emerald-800 shadow-xs';
            btnProd.className = 'flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer text-gray-600 hover:text-gray-900';
        }
    }

    function hoanDoiDanhMuc() {
        const sel1 = document.getElementById('select-danhmuc-1');
        const sel2 = document.getElementById('select-danhmuc-2');
        const tmp = sel1.value;
        sel1.value = sel2.value;
        sel2.value = tmp;
        if (sel1.value && sel2.value) {
            thucHienKiemTraDanhMuc();
        }
    }

    function chonCapDanhMucMau(slug1, slug2) {
        chuyenTabMixer('category');

        const sel1 = document.getElementById('select-danhmuc-1');
        const sel2 = document.getElementById('select-danhmuc-2');

        const opt1 = Array.from(sel1.options).find(o => o.dataset.slug === slug1);
        const opt2 = Array.from(sel2.options).find(o => o.dataset.slug === slug2);

        if (opt1) sel1.value = opt1.value;
        if (opt2) sel2.value = opt2.value;

        if (sel1.value && sel2.value) {
            thucHienKiemTraDanhMuc();
        }
    }

    async function thucHienKiemTraDanhMuc() {
        const cat1Id = document.getElementById('select-danhmuc-1').value;
        const cat2Id = document.getElementById('select-danhmuc-2').value;

        if (!cat1Id || !cat2Id) {
            alert('Vui lòng chọn cả 2 danh mục để kiểm tra tương kỵ!');
            return;
        }

        const btn = document.getElementById('btn-kiem-tra-danh-muc');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>⏳</span><span>Đang quét các sản phẩm xung đột giữa 2 danh mục...</span>';

        const resContainer = document.getElementById('ket-qua-category-container');

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            const res = await fetch("{{ route('ajax.kiem-tra-phoi-tron-danh-muc') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ cat1_id: parseInt(cat1Id), cat2_id: parseInt(cat2Id) })
            });

            const data = await res.json();
            if (data.success && data.html) {
                resContainer.innerHTML = data.html;
                resContainer.classList.remove('hidden');
                resContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                alert(data.message || 'Có lỗi khi phân tích danh mục.');
            }
        } catch (err) {
            alert('Lỗi kết nối kiểm tra: ' + err.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = origText;
        }
    }

    async function thucHienKiemTra() {
        const id1 = document.getElementById('select-thuoc-1').value;
        const id2 = document.getElementById('select-thuoc-2').value;

        if (!id1 || !id2) {
            alert('Vui lòng chọn cả 2 loại thuốc để kiểm tra phối trộn!');
            return;
        }

        const btn = document.getElementById('btn-kiem-tra');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>⏳</span><span>Đang phân tích phản ứng hóa lý...</span>';

        const resContainer = document.getElementById('ket-qua-container');

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            const res = await fetch("{{ route('ajax.kiem-tra-phoi-tron') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ids: [parseInt(id1), parseInt(id2)] })
            });

            const data = await res.json();
            if (data.success && data.data) {
                hienThiKetQuaHTML(data.data);
                resContainer.classList.remove('hidden');
                resContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                alert(data.message || 'Có lỗi khi phân tích.');
            }
        } catch (err) {
            alert('Lỗi kết nối kiểm tra: ' + err.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = origText;
        }
    }

    function hienThiKetQuaHTML(d) {
        const container = document.getElementById('ket-qua-container');

        let statusBg = 'bg-emerald-50 border-emerald-300 text-emerald-900';
        let statusBadge = '<span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold">🟢 AN TOÀN - CÓ THỂ PHỐI TRỘN</span>';
        let statusTitle = 'Hai sản phẩm này có tính tương thích tốt khi pha chung';

        if (d.status === 'danger') {
            statusBg = 'bg-red-50/90 border-red-300 text-red-950';
            statusBadge = '<span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">🔴 CẤM KỴ - KHÔNG ĐƯỢC PHỐI TRỘN</span>';
            statusTitle = 'CẢNH BÁO: Phát hiện phản ứng tương kỵ nguy hiểm!';
        } else if (d.status === 'warning') {
            statusBg = 'bg-amber-50/90 border-amber-300 text-amber-950';
            statusBadge = '<span class="bg-amber-600 text-white px-3 py-1 rounded-full text-xs font-bold">🟡 THẬN TRỌNG - LƯU Ý KHI PHỐI</span>';
            statusTitle = 'Có thể phối nhưng cần tuân thủ lưu ý kỹ thuật';
        }

        let conflictsHtml = '';
        if (d.conflicts && d.conflicts.length > 0) {
            conflictsHtml = `
            <div class="mt-5 space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider ${d.status === 'danger' ? 'text-red-900' : 'text-amber-900'}">Chi tiết phản ứng tương kỵ phát hiện:</h4>
                ${d.conflicts.map(c => `
                    <div class="bg-white p-4 rounded-2xl border ${c.level === 'danger' ? 'border-red-200 shadow-2xs' : 'border-amber-200 shadow-2xs'} space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="text-base">${c.level === 'danger' ? '🚫' : '⚠️'}</span>
                            <span class="font-bold text-sm ${c.level === 'danger' ? 'text-red-700' : 'text-amber-700'}">${c.title}</span>
                        </div>
                        <p class="text-xs text-gray-700 leading-relaxed"><strong>• Nguyên nhân:</strong> ${c.reason}</p>
                        <p class="text-xs text-gray-700 leading-relaxed"><strong>• Hậu quả:</strong> ${c.consequence}</p>
                        <p class="text-xs text-emerald-800 font-medium leading-relaxed bg-emerald-50/80 p-2 rounded-lg border border-emerald-200/50"><strong>💡 Lời khuyên:</strong> ${c.advice}</p>
                    </div>
                `).join('')}
            </div>`;
        }

        let orderHtml = '';
        if (d.mixing_order && d.mixing_order.length > 0) {
            orderHtml = `
            <div class="mt-6 pt-5 border-t border-gray-200/80">
                <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                    <span>💧</span> Hướng dẫn thứ tự pha vào phuy nếu sử dụng:
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    ${d.mixing_order.map(m => `
                        <div class="bg-white p-3 rounded-xl border border-gray-200 flex items-start gap-2.5 shadow-2xs">
                            <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                ${m.step}
                            </span>
                            <div class="text-xs">
                                <div class="font-bold text-gray-900">${m.name} <span class="text-[10px] text-gray-500 font-mono">(${m.form_type})</span></div>
                                <div class="text-gray-600 mt-0.5 leading-relaxed">${m.instruction}</div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>`;
        }

        container.innerHTML = `
            <div class="p-6 rounded-3xl border-2 ${statusBg} shadow-sm transition-all animate-fadeIn">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    ${statusBadge}
                    <span class="text-xs text-gray-500">Phân tích chuyên gia BVTV</span>
                </div>
                <h3 class="text-lg font-bold mt-2.5">${statusTitle}</h3>
                ${conflictsHtml}
                ${orderHtml}
            </div>
        `;
    }

    function hienThiGiaiThichMaTran(nameA, nameB, label, title, reason) {
        const modal = document.getElementById('matrix-modal');
        const badge = document.getElementById('modal-matrix-badge');
        const titleEl = document.getElementById('modal-matrix-title');
        const pairEl = document.getElementById('modal-matrix-pair');
        const reasonEl = document.getElementById('modal-matrix-reason');

        badge.textContent = label;
        if (label.includes('Cấm')) {
            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-1 bg-red-100 text-red-800 border border-red-200';
        } else if (label.includes('Thận')) {
            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-1 bg-amber-100 text-amber-800 border border-amber-200';
        } else {
            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-1 bg-emerald-100 text-emerald-800 border border-emerald-200';
        }

        titleEl.textContent = title || label;
        pairEl.textContent = `${nameA} ⟷ ${nameB}`;
        reasonEl.textContent = reason || 'Có thể phối trộn bình thường. Luôn tuân thủ thứ tự pha loãng riêng từng loại.';

        modal.classList.remove('hidden');
    }

    function dongModalMaTran() {
        document.getElementById('matrix-modal')?.classList.add('hidden');
    }
</script>
</x-layouts.app>
