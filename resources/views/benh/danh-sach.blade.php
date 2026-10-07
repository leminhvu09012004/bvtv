<x-layouts.app title="Quản lý bài thuốc & bệnh hại — Admin">
<div class="px-4 py-4 lg:px-6 lg:py-5">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Quản lý bài thuốc (Admin)</span>
    </nav>

    {{-- Header & Button thêm mới --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 mb-1">
                <span>⚙️ KHU VỰC QUẢN TRỊ (CRUD)</span>
            </div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>🛡️</span> Quản lý bài thuốc & bệnh hại
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Hiện có <span id="tong-so-benh" class="font-semibold text-green-700">{{ $diseases->count() }}</span> loại bệnh & bài thuốc được lưu trữ
            </p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('benh.danh-sach') }}"
                class="inline-flex items-center gap-1.5 border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-emerald-900 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-2xs">
                <span>👁️</span> Xem giao diện Người dùng
            </a>
            <button onclick="moModalThemBenh()"
                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Thêm bệnh mới</span>
            </button>
        </div>
    </div>

    {{-- Thanh thao tác chọn nhiều --}}
    <div id="bulk-action-bar-benh" class="hidden mb-4 p-3 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between gap-3 shadow-sm">
        <div class="flex items-center gap-2 text-sm text-green-900 font-medium">
            <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-1.5 rounded-full bg-green-600 text-white text-xs font-bold" id="so-luong-da-chon-benh">0</span>
            <span>bệnh đã được chọn</span>
        </div>
        <div class="flex items-center gap-2">
            <button id="btn-bo-chon-benh" type="button" class="text-xs px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                Bỏ chọn
            </button>
            <button id="btn-xoa-da-chon-benh" type="button" class="inline-flex items-center gap-1.5 text-xs px-3.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Xóa các mục đã chọn</span>
            </button>
        </div>
    </div>

    {{-- Thanh tìm kiếm & Lọc nhanh Nấm Sầu Riêng --}}
    <div class="mb-4 bg-white border border-gray-200 rounded-xl p-3 sm:p-4 shadow-2xs space-y-2.5">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none text-sm">
                🔍
            </span>
            <input type="text"
                id="admin-tim-benh"
                placeholder="Tìm bài thuốc theo tên (Phytophthora, Fusarium, Thán thư, Cháy lá...), triệu chứng, hoặc thuốc..."
                class="w-full pl-9 pr-8 py-2 bg-gray-50 hover:bg-white focus:bg-white text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
            <button id="admin-xoa-tim-benh"
                type="button"
                class="hidden absolute inset-y-0 right-0 items-center pr-2.5 text-gray-400 hover:text-gray-600 transition">
                ✕
            </button>
        </div>
        <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 text-xs scrollbar-none">
            <span class="text-gray-400 font-semibold shrink-0 flex items-center gap-1">
                <span>🍄</span> Nấm sầu riêng:
            </span>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-green-700 text-white font-semibold shrink-0 transition cursor-pointer" data-filter="">Tất cả</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium shrink-0 transition cursor-pointer" data-filter="sầu riêng">🌳 Tất cả nấm sầu riêng</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-medium shrink-0 transition cursor-pointer" data-filter="phytophthora">🔴 Phytophthora</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-amber-50 text-gray-700 hover:text-amber-700 font-medium shrink-0 transition cursor-pointer" data-filter="fusarium">🟤 Fusarium</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-orange-50 text-gray-700 hover:text-orange-700 font-medium shrink-0 transition cursor-pointer" data-filter="colletotrichum">🟠 Colletotrichum (Thán thư)</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-medium shrink-0 transition cursor-pointer" data-filter="rhizoctonia">🔥 Rhizoctonia (Cháy lá)</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-yellow-50 text-gray-700 hover:text-yellow-700 font-medium shrink-0 transition cursor-pointer" data-filter="pythium">🟡 Pythium (Thối rễ non)</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-purple-50 text-gray-700 hover:text-purple-700 font-medium shrink-0 transition cursor-pointer" data-filter="lasiodiplodia">🟣 Lasiodiplodia (Khô cành)</button>
            <button type="button" class="admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-pink-50 text-gray-700 hover:text-pink-700 font-medium shrink-0 transition cursor-pointer" data-filter="nấm hồng">🩷 Nấm hồng</button>
        </div>
    </div>

    {{-- Bảng danh sách bệnh --}}
    <div id="bang-benh-container" class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="bang-danh-benh">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-center w-10">
                            <input type="checkbox" id="chon-tat-ca-benh" title="Chọn tất cả" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                        </th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Hình ảnh</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên bệnh & Chi tiết</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Thuốc cần dùng</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Phác đồ (Phòng & Trị)</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bang-benh-body" class="divide-y divide-gray-100">
                    @forelse($diseases as $benh)
                        @php
                            $imgUrls = $benh->images_urls;
                            $mainImg = $imgUrls[0] ?? null;
                            $countImg = count($imgUrls);
                            $benhJson = [
                                'id'           => $benh->id,
                                'name'         => $benh->name,
                                'image_url'    => $benh->image_url,
                                'images'       => $benh->images ?? ($benh->image ? [$benh->image] : []),
                                'images_urls'  => $imgUrls,
                                'symptoms'     => $benh->symptoms ?? '',
                                'prevention'   => $benh->prevention ?? '',
                                'treatment'    => $benh->treatment ?? '',
                                'treatment_plans' => $benh->treatment_plans ?? [],
                                'notes'        => $benh->notes ?? '',
                                'pesticide_ids'=> $benh->pesticides->pluck('id')->toArray(),
                                'pesticides'   => $benh->pesticides->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'image_url' => $p->image_url])->toArray(),
                                'url_cap_nhat' => route('ajax.benh.cap-nhat', $benh),
                                'url_xoa'      => route('ajax.benh.xoa', $benh),
                            ];

                            $searchCorpus = mb_strtolower(
                                $benh->name . ' ' .
                                ($benh->notes ?? '') . ' ' .
                                ($benh->symptoms ?? '') . ' ' .
                                ($benh->prevention ?? '') . ' ' .
                                ($benh->treatment ?? '') . ' ' .
                                $benh->pesticides->pluck('name')->implode(' ') . ' ' .
                                $benh->pesticides->pluck('active_ingredient')->implode(' ')
                            );
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors row-benh-item"
                            data-id="{{ $benh->id }}"
                            data-search="{{ $searchCorpus }}">
                            <td class="px-3 py-3 text-center w-10">
                                <input type="checkbox" class="chon-benh w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer"
                                    value="{{ $benh->id }}"
                                    data-name="{{ $benh->name }}">
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="relative w-14 h-14 mx-auto">
                                    @if($mainImg)
                                        <img src="{{ $mainImg }}" alt="{{ $benh->name }}"
                                            class="w-14 h-14 object-cover rounded-lg border border-gray-200 cursor-pointer hover:ring-2 hover:ring-green-500 transition-all col-img"
                                            onclick="moModalGalleryBenh({{ json_encode($imgUrls) }}, '{{ addslashes($benh->name) }}')"
                                            title="Nhấp để xem gallery {{ $countImg }} ảnh">
                                        @if($countImg > 1)
                                            <span class="absolute -bottom-1 -right-1 bg-emerald-700 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full shadow border border-white"
                                                  title="{{ $countImg }} hình ảnh">
                                                +{{ $countImg }}
                                            </span>
                                        @endif
                                    @else
                                        <div class="w-14 h-14 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-xl text-gray-400">
                                            🌿
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-900 col-name text-sm">{{ $benh->name }}</div>
                                <div class="flex flex-wrap items-center gap-1 mt-1 text-[11px]">
                                    @if($benh->symptoms)
                                        <span class="bg-amber-50 text-amber-800 border border-amber-200 px-1.5 py-0.2 rounded font-medium">🔍 1.1 Triệu chứng</span>
                                    @endif
                                    @if($benh->prevention)
                                        <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-1.5 py-0.2 rounded font-medium">🛡️ 1.2 Phòng bệnh</span>
                                    @endif
                                    @if($benh->treatment)
                                        <span class="bg-blue-50 text-blue-800 border border-blue-200 px-1.5 py-0.2 rounded font-medium">💊 1.3 Điều trị</span>
                                    @endif
                                    @if(!empty($benh->treatment_plans) && count($benh->treatment_plans) > 0)
                                        <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-1.5 py-0.2 rounded font-medium">🧪 {{ count($benh->treatment_plans) }} combo</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell col-thuoc">
                                @if($benh->pesticides->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($benh->pesticides as $thuoc)
                                            <button type="button"
                                                onclick="xemAnhThuoc('{{ $thuoc->image_url }}', '{{ addslashes($thuoc->name) }}')"
                                                class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 hover:text-blue-900 text-xs px-2.5 py-1 rounded-full border border-blue-200 cursor-pointer transition-colors"
                                                title="Bấm để xem hình ảnh thuốc {{ $thuoc->name }}">
                                                {{ $thuoc->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">— Chưa có thuốc</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs hidden lg:table-cell max-w-xs col-notes">
                                @if($benh->treatment)
                                    <div class="line-clamp-2 text-blue-900"><strong class="text-blue-700">Trị:</strong> {{ $benh->treatment }}</div>
                                @elseif($benh->symptoms)
                                    <div class="line-clamp-2"><strong class="text-amber-700">TC:</strong> {{ $benh->symptoms }}</div>
                                @elseif($benh->notes)
                                    <div class="line-clamp-2">{{ $benh->notes }}</div>
                                @else
                                    <span class="text-gray-400">— Chưa cập nhật</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button"
                                        onclick='moModalSuaBenh(@json($benhJson))'
                                        class="text-xs px-2 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer">
                                        Sửa
                                    </button>
                                    <button type="button"
                                        onclick="xacNhanXoaBenh('{{ route('ajax.benh.xoa', $benh) }}', '{{ addslashes($benh->name) }}', this)"
                                        class="text-xs px-2 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="row-empty-benh">
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <p class="font-medium text-gray-600">Chưa có loại bệnh nào.</p>
                                    <p class="text-sm">Bấm "Thêm bệnh mới" ở trên để bắt đầu!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="admin-no-results" class="hidden">
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-2xl">🔍</span>
                                <p class="font-medium text-gray-600">Không tìm thấy bệnh nào phù hợp với bộ lọc.</p>
                                <p class="text-xs text-gray-400">Thử tìm với từ khóa hoặc triệu chứng khác.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- Modal Thêm Bệnh (Hỗ trợ Nhiều ảnh + 1.1, 1.2, 1.3 + Combos) --}}
{{-- ========================================================== --}}
<div id="modal-them-benh" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 max-h-[92vh] overflow-y-auto space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <span class="text-green-600">➕</span> Thêm bài thuốc & bệnh hại mới
            </h3>
            <button onclick="dongModalThemBenh()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold p-1 leading-none">&times;</button>
        </div>

        <form id="form-them-benh" class="space-y-4" enctype="multipart/form-data">
            @csrf
            {{-- Tên bệnh --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">
                    Tên bệnh hại <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required placeholder="Ví dụ: Phytophthora Palmivora (Nứt thân xì mủ), Thán thư, Rầy xanh..."
                    class="w-full text-sm font-medium border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none shadow-2xs">
                <span class="text-xs text-red-500 mt-1 block benh-error" data-field="name"></span>
            </div>

            {{-- Hình ảnh minh họa (Nhiều ảnh) --}}
            <div class="bg-gray-50/70 border border-gray-200/80 rounded-xl p-3.5 space-y-2.5">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        📷 Hình ảnh minh họa bệnh (Chọn được nhiều ảnh)
                    </label>
                    <span id="them-img-count" class="text-xs font-medium text-emerald-700 hidden">0 ảnh đã chọn</span>
                </div>

                <div class="flex flex-col sm:flex-row items-start gap-3">
                    <label class="cursor-pointer border-2 border-dashed border-emerald-400 bg-emerald-50/50 hover:bg-emerald-50 text-emerald-800 rounded-xl px-4 py-3 flex items-center gap-2 text-xs font-bold transition-all shrink-0">
                        <span class="text-lg">📁</span>
                        <span>Chọn các ảnh minh họa...</span>
                        <input type="file" name="images[]" id="them-images-input" multiple accept="image/*" class="hidden">
                    </label>
                    <p class="text-xs text-gray-500 self-center">Có thể chọn nhiều ảnh cùng lúc (JPG, PNG, WEBP tối đa 5MB/ảnh)</p>
                </div>

                {{-- Preview lưới các ảnh chuẩn bị upload --}}
                <div id="them-images-preview" class="hidden flex-wrap gap-2.5 pt-2 border-t border-gray-200"></div>
            </div>

            {{-- 1.1 Triệu chứng --}}
            <div class="bg-amber-50/40 border border-amber-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-amber-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>🔍</span> 1.1. Triệu chứng nhận biết
                </label>
                <textarea name="symptoms" rows="3" placeholder="Mô tả dấu hiệu trên lá, thân cành, vỏ, rễ, bông, trái... (Ví dụ: Vỏ cây nứt nẻ chảy mủ nâu đỏ mùi chua tanh, đốm úng nước lan nhanh trên lá, thối đen quả...)"
                    class="w-full text-sm border border-amber-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none resize-none"></textarea>
            </div>

            {{-- 1.2 Cách phòng bệnh --}}
            <div class="bg-emerald-50/40 border border-emerald-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-emerald-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>🛡️</span> 1.2. Cách phòng bệnh
                </label>
                <textarea name="prevention" rows="3" placeholder="Biện pháp canh tác, vườn thông thoáng, rãnh thoát nước, nâng mô, quét vôi hoặc đồng đỏ định kỳ phòng ngừa..."
                    class="w-full text-sm border border-emerald-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none resize-none"></textarea>
            </div>

            {{-- 1.3 Cách điều trị --}}
            <div class="bg-blue-50/40 border border-blue-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-blue-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>💊</span> 1.3. Cách điều trị & Phác đồ dùng thuốc
                </label>
                <textarea name="treatment" rows="3" placeholder="Phác đồ điều trị: Cạo sạch mủ quét thuốc đậm đặc, liều phun tán lá, tưới đẫm gốc, chu kỳ lặp lại (7 - 10 ngày)..."
                    class="w-full text-sm border border-blue-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
            </div>

            {{-- CÁC PHÁC ĐỒ / COMBO ĐIỀU TRỊ PHỐI HỢP (TÙY Ý THÊM NHIỀU COMBO) --}}
            <div class="bg-gradient-to-br from-emerald-50/50 via-white to-teal-50/30 border-2 border-emerald-300/80 rounded-2xl p-4 space-y-3.5 shadow-xs">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-wide flex items-center gap-1.5">
                            <span class="text-base">🧪</span> Các phác đồ / Combo điều trị phối hợp
                        </label>
                        <p class="text-[11px] text-emerald-800/80 mt-0.5">
                            Thêm tùy ý nhiều combo (cặp đôi phối hợp, bộ 3, hoặc phun đơn). Tự do chọn các thuốc đi cùng nhau.
                        </p>
                    </div>
                    <button type="button" onclick="themComboMoi('them')"
                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                        <span class="text-sm leading-none font-black">+</span> Thêm combo mới
                    </button>
                </div>

                {{-- Danh sách các thẻ combo --}}
                <div id="them-combos-container" class="space-y-4"></div>

                <div id="them-combos-empty" class="text-center py-5 bg-white/70 rounded-xl border border-dashed border-emerald-300 text-xs text-gray-500 space-y-1">
                    <span class="text-2xl block">📦</span>
                    <p class="font-medium text-gray-600">Chưa có combo điều trị phối hợp nào.</p>
                    <p class="text-[11px] text-gray-400">Bấm nút <strong>"+ Thêm combo mới"</strong> ở trên để tạo combo (Cặp đôi hoặc Bộ 3 thuốc).</p>
                </div>
            </div>

            {{-- Thuốc cần dùng (checkbox list) --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">📦 Danh mục thuốc bổ sung khác (Toa thuốc đơn lẻ)</label>
                    <span id="them-thuoc-count" class="text-xs text-green-700 font-bold hidden">0 đã chọn</span>
                </div>
                {{-- Ô tìm kiếm thuốc --}}
                <div class="relative mb-1.5">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                    <input type="text" id="them-thuoc-search" placeholder="🔍 Gõ tìm nhanh thuốc cần thêm vào toa..."
                        class="w-full text-xs border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:ring-2 focus:ring-green-400 outline-none bg-gray-50">
                </div>
                {{-- Danh sách checkbox --}}
                <div id="them-thuoc-list"
                    class="border border-gray-200 rounded-xl overflow-y-auto divide-y divide-gray-100 bg-white"
                    style="max-height: 170px;">
                    @forelse($pesticides as $thuoc)
                        <label class="thuoc-item flex items-center gap-2.5 px-3 py-2 hover:bg-green-50 cursor-pointer transition-colors select-none"
                            data-name="{{ strtolower($thuoc->name) }}">
                            <input type="checkbox" name="pesticide_ids[]" value="{{ $thuoc->id }}"
                                class="them-thuoc-cb w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer flex-shrink-0">
                            <span class="text-sm text-gray-800">{{ $thuoc->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-400 px-3 py-3">Chưa có thuốc nào trong hệ thống.</p>
                    @endforelse
                </div>
            </div>

            {{-- Ghi chú thêm --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">
                    📝 Ghi chú bổ sung (nếu có)
                </label>
                <textarea name="notes" rows="2" placeholder="Lưu ý thời vụ, cách pha trộn, thời gian cách ly..."
                    class="w-full text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-3 border-t border-gray-100">
                <button type="button" onclick="dongModalThemBenh()"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors cursor-pointer">
                    Hủy
                </button>
                <button type="submit" id="btn-submit-them-benh"
                    class="px-6 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-bold transition-colors shadow-md cursor-pointer">
                    Lưu bệnh & bài thuốc
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================== --}}
{{-- Modal Sửa Bệnh (Hỗ trợ Nhiều ảnh + 1.1, 1.2, 1.3 + Combos) --}}
{{-- ========================================================== --}}
<div id="modal-sua-benh" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 max-h-[92vh] overflow-y-auto space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <span class="text-blue-600">✏️</span> Chỉnh sửa bài thuốc & bệnh hại
            </h3>
            <button onclick="dongModalSuaBenh()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold p-1 leading-none">&times;</button>
        </div>

        <form id="form-sua-benh" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="sua-benh-id">
            <input type="hidden" id="sua-benh-url">

            {{-- Tên bệnh --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">
                    Tên bệnh hại <span class="text-red-500">*</span>
                </label>
                <input type="text" id="sua-benh-name" name="name" required
                    class="w-full text-sm font-medium border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none shadow-2xs">
                <span class="text-xs text-red-500 mt-1 block benh-error-sua" data-field="name"></span>
            </div>

            {{-- Hình ảnh minh họa (Nhiều ảnh: danh sách hiện tại + thêm mới) --}}
            <div class="bg-gray-50/70 border border-gray-200/80 rounded-xl p-3.5 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        📷 Hình ảnh bệnh (Quản lý nhiều ảnh)
                    </label>
                    <span id="sua-img-count-badge" class="text-xs font-medium text-blue-700"></span>
                </div>

                {{-- Lưới các ảnh hiện tại --}}
                <div>
                    <div class="text-[11px] font-semibold text-gray-500 mb-1.5">Ảnh hiện tại:</div>
                    <div id="sua-existing-images-grid" class="flex flex-wrap gap-2.5 min-h-[50px] items-center">
                        {{-- JS render các ảnh kèm nút Xóa --}}
                    </div>
                </div>

                {{-- Tải thêm ảnh mới --}}
                <div class="pt-2 border-t border-gray-200 space-y-2">
                    <div class="flex flex-col sm:flex-row items-start gap-3">
                        <label class="cursor-pointer border-2 border-dashed border-blue-400 bg-blue-50/50 hover:bg-blue-50 text-blue-800 rounded-xl px-4 py-2.5 flex items-center gap-2 text-xs font-bold transition-all shrink-0">
                            <span class="text-base">➕</span>
                            <span>Tải thêm ảnh mới...</span>
                            <input type="file" name="images[]" id="sua-images-input" multiple accept="image/*" class="hidden">
                        </label>
                        <p class="text-xs text-gray-500 self-center">Chọn thêm 1 hoặc nhiều ảnh để bổ sung vào album bệnh</p>
                    </div>

                    {{-- Preview các ảnh mới vừa chọn --}}
                    <div id="sua-new-images-preview" class="hidden flex-wrap gap-2.5 pt-1"></div>
                </div>
            </div>

            {{-- 1.1 Triệu chứng --}}
            <div class="bg-amber-50/40 border border-amber-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-amber-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>🔍</span> 1.1. Triệu chứng nhận biết
                </label>
                <textarea id="sua-benh-symptoms" name="symptoms" rows="3" placeholder="Mô tả dấu hiệu trên lá, thân cành, vỏ, rễ, bông, trái..."
                    class="w-full text-sm border border-amber-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none resize-none"></textarea>
            </div>

            {{-- 1.2 Cách phòng bệnh --}}
            <div class="bg-emerald-50/40 border border-emerald-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-emerald-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>🛡️</span> 1.2. Cách phòng bệnh
                </label>
                <textarea id="sua-benh-prevention" name="prevention" rows="3" placeholder="Biện pháp canh tác, vườn thông thoáng, rãnh thoát nước, tỉa cành, quét vôi hoặc đồng đỏ..."
                    class="w-full text-sm border border-emerald-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none resize-none"></textarea>
            </div>

            {{-- 1.3 Cách điều trị --}}
            <div class="bg-blue-50/40 border border-blue-200 rounded-xl p-3.5 space-y-1">
                <label class="block text-xs font-bold text-blue-900 uppercase tracking-wide flex items-center gap-1.5">
                    <span>💊</span> 1.3. Cách điều trị & Phác đồ dùng thuốc
                </label>
                <textarea id="sua-benh-treatment" name="treatment" rows="3" placeholder="Phác đồ điều trị: Cạo sạch mủ quét thuốc đậm đặc, liều phun tán lá, tưới gốc..."
                    class="w-full text-sm border border-blue-300/80 bg-white rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
            </div>

            {{-- CÁC PHÁC ĐỒ / COMBO ĐIỀU TRỊ PHỐI HỢP (TÙY Ý THÊM NHIỀU COMBO) --}}
            <div class="bg-gradient-to-br from-emerald-50/50 via-white to-teal-50/30 border-2 border-emerald-300/80 rounded-2xl p-4 space-y-3.5 shadow-xs">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-wide flex items-center gap-1.5">
                            <span class="text-base">🧪</span> Các phác đồ / Combo điều trị phối hợp
                        </label>
                        <p class="text-[11px] text-emerald-800/80 mt-0.5">
                            Thêm tùy ý nhiều combo (cặp đôi phối hợp, bộ 3, hoặc phun đơn). Tự do chọn các thuốc đi cùng nhau.
                        </p>
                    </div>
                    <button type="button" onclick="themComboMoi('sua')"
                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                        <span class="text-sm leading-none font-black">+</span> Thêm combo mới
                    </button>
                </div>

                {{-- Danh sách các thẻ combo --}}
                <div id="sua-combos-container" class="space-y-4"></div>

                <div id="sua-combos-empty" class="text-center py-5 bg-white/70 rounded-xl border border-dashed border-emerald-300 text-xs text-gray-500 space-y-1">
                    <span class="text-2xl block">📦</span>
                    <p class="font-medium text-gray-600">Chưa có combo điều trị phối hợp nào.</p>
                    <p class="text-[11px] text-gray-400">Bấm nút <strong>"+ Thêm combo mới"</strong> ở trên để tạo combo (Cặp đôi hoặc Bộ 3 thuốc).</p>
                </div>
            </div>

            {{-- Thuốc cần dùng (checkbox list) --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">📦 Danh mục thuốc bổ sung khác (Toa thuốc đơn lẻ)</label>
                    <span id="sua-thuoc-count" class="text-xs text-green-700 font-bold hidden">0 đã chọn</span>
                </div>
                {{-- Ô tìm kiếm thuốc --}}
                <div class="relative mb-1.5">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                    <input type="text" id="sua-thuoc-search" placeholder="🔍 Gõ tìm nhanh thuốc cần chọn..."
                        class="w-full text-xs border border-gray-300 rounded-lg pl-8 pr-3 py-2 focus:ring-2 focus:ring-green-400 outline-none bg-gray-50">
                </div>
                {{-- Danh sách checkbox --}}
                <div id="sua-thuoc-list"
                    class="border border-gray-200 rounded-xl overflow-y-auto divide-y divide-gray-100 bg-white"
                    style="max-height: 170px;">
                    @forelse($pesticides as $thuoc)
                        <label class="thuoc-item flex items-center gap-2.5 px-3 py-2 hover:bg-green-50 cursor-pointer transition-colors select-none"
                            data-name="{{ strtolower($thuoc->name) }}">
                            <input type="checkbox" name="pesticide_ids[]" value="{{ $thuoc->id }}"
                                class="sua-thuoc-cb w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer flex-shrink-0">
                            <span class="text-sm text-gray-800">{{ $thuoc->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-400 px-3 py-3">Chưa có thuốc nào trong hệ thống.</p>
                    @endforelse
                </div>
            </div>

            {{-- Ghi chú thêm --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">
                    📝 Ghi chú bổ sung
                </label>
                <textarea id="sua-benh-notes" name="notes" rows="2"
                    class="w-full text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-green-500 outline-none resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-3 border-t border-gray-100">
                <button type="button" onclick="dongModalSuaBenh()"
                    class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors cursor-pointer">
                    Hủy
                </button>
                <button type="submit" id="btn-submit-sua-benh"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition-colors shadow-md cursor-pointer">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================== --}}
{{-- Modal Gallery Ảnh Bệnh (Xem nhiều ảnh lớn)                 --}}
{{-- ========================================================== --}}
<div id="modal-gallery-benh" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4 py-4 backdrop-blur-sm" onclick="if(event.target === this) dongModalGalleryBenh()">
    <div class="bg-white rounded-2xl max-w-3xl w-full p-5 space-y-4 max-h-[95vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
            <h3 id="gallery-benh-title" class="font-bold text-gray-900 text-base flex items-center gap-2">
                <span>🖼️</span> Album ảnh bệnh hại
            </h3>
            <button onclick="dongModalGalleryBenh()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold leading-none p-1">&times;</button>
        </div>
        <div id="gallery-benh-main" class="w-full h-80 sm:h-96 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center border border-gray-200">
            <img id="gallery-benh-main-img" src="" class="w-full h-full object-contain">
        </div>
        <div id="gallery-benh-thumbs" class="flex flex-wrap items-center gap-2 pt-2"></div>
    </div>
</div>

<script>
// ============================================================
// Helpers & API
// ============================================================
async function goiApiBenh(url, method = 'GET', body = null, isFormData = false) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const headers = {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token,
        ...(isFormData ? {} : { 'Content-Type': 'application/json' }),
    };

    try {
        const res = await fetch(url, {
            method,
            headers,
            ...(body ? { body: isFormData ? body : JSON.stringify(body) } : {}),
        });
        let data = {};
        try { data = await res.json(); } catch (e) { data = { message: 'Phản hồi không hợp lệ.' }; }
        return { ok: res.ok, status: res.status, data };
    } catch (err) {
        return { ok: false, status: 0, data: { message: 'Lỗi kết nối máy chủ.' } };
    }
}

function baoThongBaoBenh(msg, type = 'success') {
    if (window.BVTV && typeof window.BVTV.toast === 'function') {
        window.BVTV.toast(msg, type);
        return;
    }
    const container = document.getElementById('toast-container');
    if (!container) { alert(msg); return; }
    const toast = document.createElement('div');
    toast.className = (type === 'success' ? 'bg-green-600' : 'bg-red-600') + ' text-white text-sm px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 transition-all';
    toast.textContent = msg;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}

function escapeHtmlBenh(str) {
    return String(str ?? '').replace(/[&<>"']/g, s => (
        { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[s]
    ));
}

function xemAnhThuoc(imageUrl, name) {
    if (imageUrl) {
        if (typeof window.moModalAnh === 'function') {
            window.moModalAnh(imageUrl, 'Thuốc: ' + name);
        } else {
            window.open(imageUrl, '_blank');
        }
    } else {
        baoThongBaoBenh('Thuốc "' + name + '" chưa có hình ảnh.', 'error');
    }
}

// Tìm kiếm & Lọc nhanh Nấm Sầu Riêng (Admin)
function initAdminBenhSearch() {
    const searchInput = document.getElementById('admin-tim-benh');
    const clearBtn = document.getElementById('admin-xoa-tim-benh');
    const filterBtns = document.querySelectorAll('.admin-durian-filter');
    const noResults = document.getElementById('admin-no-results');

    function updateAdminFilterStyles(activeVal) {
        filterBtns.forEach(btn => {
            const val = (btn.dataset.filter || '').trim().toLowerCase();
            const isActive = (val === activeVal.trim().toLowerCase()) || (val === '' && activeVal.trim() === '');
            if (isActive) {
                btn.className = 'admin-durian-filter px-2 py-0.5 rounded-md bg-green-700 text-white font-semibold shrink-0 transition cursor-pointer shadow-xs';
            } else {
                btn.className = 'admin-durian-filter px-2 py-0.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium shrink-0 transition cursor-pointer';
            }
        });
    }

    function applyAdminFilter() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        if (clearBtn) clearBtn.classList.toggle('hidden', query.length === 0);

        let visibleCount = 0;
        document.querySelectorAll('.row-benh-item').forEach(row => {
            const corpus = (row.dataset.search || '').toLowerCase();
            if (query === '' || corpus.includes(query)) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        if (noResults) {
            noResults.classList.toggle('hidden', visibleCount > 0);
        }
    }

    searchInput?.addEventListener('input', () => {
        updateAdminFilterStyles(searchInput.value);
        applyAdminFilter();
    });

    clearBtn?.addEventListener('click', () => {
        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
            updateAdminFilterStyles('');
            applyAdminFilter();
        }
    });

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filterVal = this.dataset.filter || '';
            if (searchInput) {
                searchInput.value = filterVal;
                updateAdminFilterStyles(filterVal);
                applyAdminFilter();
            }
        });
    });
}
document.addEventListener('DOMContentLoaded', initAdminBenhSearch);

// Modal Gallery nhiều ảnh
function moModalGalleryBenh(urls, title) {
    if (!urls || urls.length === 0) return;
    const modal = document.getElementById('modal-gallery-benh');
    const titleEl = document.getElementById('gallery-benh-title');
    const mainImg = document.getElementById('gallery-benh-main-img');
    const thumbs = document.getElementById('gallery-benh-thumbs');
    if (!modal) return;

    if (titleEl) titleEl.innerHTML = `<span>🖼️</span> Album ảnh: <strong>${escapeHtmlBenh(title)}</strong> (${urls.length} ảnh)`;
    if (mainImg) mainImg.src = urls[0];

    if (thumbs) {
        thumbs.innerHTML = urls.map((u, i) => `
            <img src="${escapeHtmlBenh(u)}"
                 onclick="document.getElementById('gallery-benh-main-img').src='${escapeHtmlBenh(u)}'; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('ring-2','ring-emerald-500')); this.classList.add('ring-2','ring-emerald-500');"
                 class="gallery-thumb w-16 h-16 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition ${i === 0 ? 'ring-2 ring-emerald-500' : ''}">
        `).join('');
    }

    modal.classList.remove('hidden');
}

function dongModalGalleryBenh() {
    document.getElementById('modal-gallery-benh')?.classList.add('hidden');
}

// ============================================================
// Multi-Image File Handlers (Thêm bệnh & Sửa bệnh)
// ============================================================
let themFilesArr = [];
let suaNewFilesArr = [];
let suaExistingArr = [];

function initMultiImageUpload() {
    // 1. Thêm bệnh input
    const themInput = document.getElementById('them-images-input');
    const themPreview = document.getElementById('them-images-preview');
    const themCount = document.getElementById('them-img-count');

    themInput?.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        files.forEach(f => themFilesArr.push(f));
        renderThemPreview();
    });

    function renderThemPreview() {
        if (!themPreview) return;
        if (themFilesArr.length === 0) {
            themPreview.innerHTML = '';
            themPreview.classList.add('hidden');
            if (themCount) themCount.classList.add('hidden');
            return;
        }

        themPreview.classList.remove('hidden');
        themPreview.classList.add('flex');
        if (themCount) {
            themCount.textContent = themFilesArr.length + ' ảnh đã chọn';
            themCount.classList.remove('hidden');
        }

        themPreview.innerHTML = '';
        themFilesArr.forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'relative w-20 h-20 rounded-xl overflow-hidden border border-gray-200 shadow-xs group bg-white shrink-0';
            const img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            img.src = URL.createObjectURL(file);

            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold opacity-90 hover:opacity-100 cursor-pointer shadow';
            delBtn.innerHTML = '&times;';
            delBtn.title = 'Xóa ảnh này';
            delBtn.onclick = () => {
                themFilesArr.splice(index, 1);
                renderThemPreview();
            };

            card.appendChild(img);
            card.appendChild(delBtn);
            themPreview.appendChild(card);
        });
    }

    // 2. Sửa bệnh input (tải thêm ảnh)
    const suaInput = document.getElementById('sua-images-input');
    suaInput?.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        files.forEach(f => suaNewFilesArr.push(f));
        renderSuaNewPreview();
    });
}

function renderSuaExistingGrid() {
    const grid = document.getElementById('sua-existing-images-grid');
    const badge = document.getElementById('sua-img-count-badge');
    if (!grid) return;

    if (suaExistingArr.length === 0) {
        grid.innerHTML = '<span class="text-xs text-gray-400 italic">Chưa có ảnh lưu trữ nào.</span>';
        if (badge) badge.textContent = '0 ảnh hiện có';
        return;
    }

    if (badge) badge.textContent = `${suaExistingArr.length} ảnh hiện có`;

    grid.innerHTML = suaExistingArr.map((imgObj, idx) => {
        const fullUrl = imgObj.url;
        const rawPath = imgObj.path;
        return `
            <div class="relative w-20 h-20 rounded-xl overflow-hidden border border-gray-200 shadow-xs bg-white shrink-0 group" id="sua-img-box-${idx}">
                <input type="hidden" name="existing_images[]" value="${escapeHtmlBenh(rawPath)}">
                <img src="${escapeHtmlBenh(fullUrl)}" class="w-full h-full object-cover cursor-pointer" onclick="moModalGalleryBenh(['${escapeHtmlBenh(fullUrl)}'], 'Ảnh bệnh')">
                <button type="button" onclick="xoaAnhExisting(${idx})" class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold opacity-90 hover:opacity-100 cursor-pointer shadow" title="Xóa ảnh này khỏi bệnh">
                    &times;
                </button>
            </div>
        `;
    }).join('');
}

function xoaAnhExisting(index) {
    suaExistingArr.splice(index, 1);
    renderSuaExistingGrid();
}

function renderSuaNewPreview() {
    const preview = document.getElementById('sua-new-images-preview');
    if (!preview) return;

    if (suaNewFilesArr.length === 0) {
        preview.innerHTML = '';
        preview.classList.add('hidden');
        return;
    }

    preview.classList.remove('hidden');
    preview.classList.add('flex');
    preview.innerHTML = '';

    suaNewFilesArr.forEach((file, index) => {
        const card = document.createElement('div');
        card.className = 'relative w-20 h-20 rounded-xl overflow-hidden border-2 border-dashed border-blue-400 shadow-xs bg-blue-50 shrink-0';
        const img = document.createElement('img');
        img.className = 'w-full h-full object-cover';
        img.src = URL.createObjectURL(file);

        const badge = document.createElement('span');
        badge.className = 'absolute bottom-0.5 left-0.5 bg-blue-700 text-white text-[9px] px-1 rounded';
        badge.textContent = 'Mới';

        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold cursor-pointer shadow';
        delBtn.innerHTML = '&times;';
        delBtn.onclick = () => {
            suaNewFilesArr.splice(index, 1);
            renderSuaNewPreview();
        };

        card.appendChild(img);
        card.appendChild(badge);
        card.appendChild(delBtn);
        preview.appendChild(card);
    });
}

// ============================================================
// Quản lý Phác đồ / Combo điều trị phối hợp động (Admin)
// ============================================================
@php
    $pesticidesListJson = json_encode($pesticides->map(fn($p) => [
        'id'                => $p->id,
        'name'              => $p->name,
        'category'          => $p->category->name ?? '',
        'form_type'         => $p->form_type ?? '',
        'water_volume'      => $p->water_volume ?? '',
        'image_url'         => $p->image_url ?? null,
        'active_ingredient' => $p->active_ingredient ?? '',
    ])->values());
@endphp
const danhSachThuocHeThong = {!! $pesticidesListJson !!};

function xoaDauTiengViet(str) {
    return String(str || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'd')
        .trim();
}

function taoOptionsThuocHeThong(selectedId = null) {
    let html = '<option value="">-- Chọn thuốc chính --</option>';
    danhSachThuocHeThong.forEach(t => {
        let extra = '';
        if (t.category) {
            extra = ' [' + t.category + ']';
        } else if (t.form_type) {
            extra = ' [' + t.form_type + ']';
        }
        const sel = String(t.id) === String(selectedId) ? 'selected' : '';
        html += '<option value="' + t.id + '" ' + sel + '>' + escapeHtmlBenh(t.name) + extra + '</option>';
    });
    return html;
}

// ------------------------------------------------------------
// Xử lý Tìm Kiếm & Chọn Thuốc Chính (Searchable Picker)
// ------------------------------------------------------------
function renderDropdownThuocChinh(dropdownEl, dsThuoc, query = '') {
    if (!dropdownEl) return;
    if (dsThuoc.length === 0) {
        dropdownEl.innerHTML = `
            <div class="p-3 text-center text-xs text-gray-500">
                <span>🔍 Không tìm thấy thuốc nào khớp với "<strong>${escapeHtmlBenh(query)}</strong>"</span>
            </div>
        `;
        dropdownEl.classList.remove('hidden');
        return;
    }

    let itemsHtml = '';
    const displayList = dsThuoc.slice(0, 35);
    displayList.forEach(p => {
        const thumbHtml = p.image_url
            ? `<img src="${escapeHtmlBenh(p.image_url)}" class="w-8 h-8 sm:w-9 sm:h-9 object-cover rounded-lg border border-gray-200 bg-white shrink-0" onerror="this.src='';this.className='hidden'">`
            : `<div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0">🧪</div>`;

        const catBadge = p.category
            ? `<span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">${escapeHtmlBenh(p.category)}</span>`
            : '';

        const subInfo = [
            p.active_ingredient ? `HC: ${escapeHtmlBenh(p.active_ingredient)}` : '',
            p.form_type ? `Dạng: ${escapeHtmlBenh(p.form_type)}` : '',
            p.water_volume ? `💧 ${escapeHtmlBenh(p.water_volume)}` : '',
        ].filter(Boolean).join(' • ');

        itemsHtml += `
            <div class="item-thuoc-option flex items-center gap-2.5 p-2 hover:bg-emerald-50/80 cursor-pointer transition select-none group"
                onclick="chonThuocChinh(this, ${p.id})">
                ${thumbHtml}
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="text-xs font-bold text-gray-900 group-hover:text-emerald-900">${escapeHtmlBenh(p.name)}</span>
                        ${catBadge}
                    </div>
                    ${subInfo ? `<div class="text-[10px] text-gray-500 truncate mt-0.5">${subInfo}</div>` : ''}
                </div>
                <span class="text-[10px] font-bold text-emerald-700 px-2 py-1 rounded-md bg-emerald-100/70 group-hover:bg-emerald-200 shrink-0 border border-emerald-300">
                    Chọn ↵
                </span>
            </div>
        `;
    });

    const footerText = dsThuoc.length > 35
        ? `<div class="px-3 py-1.5 bg-gray-50 text-[10px] text-gray-400 text-center font-medium border-t border-gray-100">Đang hiện 35/${dsThuoc.length} kết quả. Gõ thêm từ khóa để tìm chính xác hơn.</div>`
        : `<div class="px-3 py-1 bg-gray-50 text-[10px] text-gray-400 text-center border-t border-gray-100">Tìm thấy ${dsThuoc.length} sản phẩm thuốc</div>`;

    dropdownEl.innerHTML = itemsHtml + footerText;
    dropdownEl.classList.remove('hidden');
}

function timKiemThuocChinh(inputEl) {
    const box = inputEl.closest('.group-primary-search-box');
    const dropdown = box?.querySelector('.group-search-dropdown');
    const clearBtn = box?.querySelector('.btn-clear-search');
    const val = inputEl.value.trim();

    if (clearBtn) {
        if (val) clearBtn.classList.remove('hidden');
        else clearBtn.classList.add('hidden');
    }

    const q = xoaDauTiengViet(val);
    let ds = danhSachThuocHeThong;
    if (q) {
        ds = danhSachThuocHeThong.filter(t => {
            const nameNorm = xoaDauTiengViet(t.name);
            const catNorm  = xoaDauTiengViet(t.category);
            const actNorm  = xoaDauTiengViet(t.active_ingredient);
            return nameNorm.includes(q) || catNorm.includes(q) || actNorm.includes(q);
        });
    }

    renderDropdownThuocChinh(dropdown, ds, val);
}

function moDropdownThuocChinh(inputEl) {
    timKiemThuocChinh(inputEl);
}

function xoaInputSearch(btn) {
    const box = btn.closest('.group-primary-search-box');
    const input = box?.querySelector('.group-search-input');
    if (input) {
        input.value = '';
        input.focus();
        timKiemThuocChinh(input);
    }
}

function chonThuocChinh(sourceEl, pId) {
    const p = danhSachThuocHeThong.find(t => t.id == pId);
    if (!p) return;

    const wrapper = sourceEl.closest('.group-primary-picker-wrapper');
    if (!wrapper) return;

    // 1. Cập nhật hidden input để thuThapCombos đọc
    const hiddenInput = wrapper.querySelector('.group-primary-select');
    if (hiddenInput) hiddenInput.value = p.id;

    // 2. Cập nhật giao diện card đã chọn
    const card = wrapper.querySelector('.group-primary-selected-card');
    if (card) {
        const thumbBox = card.querySelector('.group-selected-thumb');
        if (thumbBox) {
            thumbBox.innerHTML = p.image_url
                ? `<img src="${escapeHtmlBenh(p.image_url)}" class="w-full h-full object-cover">`
                : `<span class="text-base">🧪</span>`;
        }
        const nameEl = card.querySelector('.group-selected-name');
        if (nameEl) nameEl.textContent = p.name;

        const catEl = card.querySelector('.group-selected-cat');
        if (catEl) {
            catEl.textContent = p.category || 'Thuốc BVTV';
            catEl.classList.toggle('hidden', !p.category);
        }

        const extraEl = card.querySelector('.group-selected-extra');
        if (extraEl) {
            const extraParts = [
                p.active_ingredient ? `HC: ${p.active_ingredient}` : '',
                p.form_type ? `Dạng: ${p.form_type}` : '',
                p.water_volume ? `💧 ${p.water_volume}` : '',
            ].filter(Boolean).join(' • ');
            extraEl.textContent = extraParts;
            extraEl.classList.toggle('hidden', !extraParts);
        }

        card.classList.remove('hidden');
        card.classList.add('flex');
    }

    // 3. Ẩn search box & dropdown
    const searchBox = wrapper.querySelector('.group-primary-search-box');
    if (searchBox) {
        searchBox.classList.add('hidden');
        searchBox.querySelector('.group-search-dropdown')?.classList.add('hidden');
        const input = searchBox.querySelector('.group-search-input');
        if (input) input.value = '';
    }
}

function doiThuocChinh(btn) {
    const wrapper = btn.closest('.group-primary-picker-wrapper');
    if (!wrapper) return;

    const card = wrapper.querySelector('.group-primary-selected-card');
    const searchBox = wrapper.querySelector('.group-primary-search-box');
    if (card) card.classList.add('hidden');
    if (searchBox) {
        searchBox.classList.remove('hidden');
        const input = searchBox.querySelector('.group-search-input');
        if (input) {
            input.focus();
            timKiemThuocChinh(input);
        }
    }
}

function boChonThuocChinh(btn) {
    const wrapper = btn.closest('.group-primary-picker-wrapper');
    if (!wrapper) return;

    const hiddenInput = wrapper.querySelector('.group-primary-select');
    if (hiddenInput) hiddenInput.value = '';

    const card = wrapper.querySelector('.group-primary-selected-card');
    const searchBox = wrapper.querySelector('.group-primary-search-box');
    if (card) card.classList.add('hidden');
    if (searchBox) {
        searchBox.classList.remove('hidden');
        const input = searchBox.querySelector('.group-search-input');
        if (input) {
            input.value = '';
            input.focus();
            timKiemThuocChinh(input);
        }
    }
}

// ------------------------------------------------------------
// Xử lý Tìm Kiếm & Chọn Thuốc Thay Thế Dự Phòng
// ------------------------------------------------------------
function renderDropdownThuocThayThe(dropdownEl, dsThuoc, query = '') {
    if (!dropdownEl) return;
    if (dsThuoc.length === 0) {
        dropdownEl.innerHTML = `
            <div class="p-2.5 text-center text-xs text-gray-500">
                <span>Không tìm thấy thuốc thay thế phù hợp</span>
            </div>
        `;
        dropdownEl.classList.remove('hidden');
        return;
    }

    let itemsHtml = '';
    const displayList = dsThuoc.slice(0, 30);
    displayList.forEach(p => {
        const thumbHtml = p.image_url
            ? `<img src="${escapeHtmlBenh(p.image_url)}" class="w-7 h-7 object-cover rounded border border-gray-200 bg-white shrink-0">`
            : `<div class="w-7 h-7 rounded bg-amber-100 text-amber-800 flex items-center justify-center text-xs shrink-0 font-bold">🔄</div>`;

        itemsHtml += `
            <div class="flex items-center gap-2 p-1.5 hover:bg-amber-50 cursor-pointer transition select-none text-xs"
                onclick="themSubstituteTheoId(this, ${p.id})">
                ${thumbHtml}
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-gray-800 truncate">${escapeHtmlBenh(p.name)}</div>
                    <div class="text-[10px] text-gray-500 truncate">${escapeHtmlBenh(p.category || p.form_type || '')}</div>
                </div>
                <span class="text-[10px] font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 border border-amber-300 px-2 py-0.5 rounded shrink-0">
                    + Thêm
                </span>
            </div>
        `;
    });

    dropdownEl.innerHTML = itemsHtml;
    dropdownEl.classList.remove('hidden');
}

function timKiemThuocThayThe(inputEl) {
    const wrapper = inputEl.closest('.group-sub-search-wrapper');
    const dropdown = wrapper?.querySelector('.sub-search-dropdown');
    const clearBtn = wrapper?.querySelector('.btn-clear-sub-search');
    const val = inputEl.value.trim();

    if (clearBtn) {
        if (val) clearBtn.classList.remove('hidden');
        else clearBtn.classList.add('hidden');
    }

    const groupItem = inputEl.closest('.combo-group-item');
    const curPrimaryId = groupItem?.querySelector('.group-primary-select')?.value;
    const existingSubChips = groupItem?.querySelectorAll('.substitute-chip') || [];
    const existingSubIds = Array.from(existingSubChips).map(c => String(c.dataset.id));

    let ds = danhSachThuocHeThong.filter(t => {
        if (curPrimaryId && String(t.id) === String(curPrimaryId)) return false;
        if (existingSubIds.includes(String(t.id))) return false;
        return true;
    });

    const q = xoaDauTiengViet(val);
    if (q) {
        ds = ds.filter(t => {
            const nameNorm = xoaDauTiengViet(t.name);
            const catNorm  = xoaDauTiengViet(t.category);
            const actNorm  = xoaDauTiengViet(t.active_ingredient);
            return nameNorm.includes(q) || catNorm.includes(q) || actNorm.includes(q);
        });
    }

    renderDropdownThuocThayThe(dropdown, ds, val);
}

function moDropdownThuocThayThe(inputEl) {
    timKiemThuocThayThe(inputEl);
}

function xoaSubInputSearch(btn) {
    const wrapper = btn.closest('.group-sub-search-wrapper');
    const input = wrapper?.querySelector('.sub-search-input');
    if (input) {
        input.value = '';
        input.focus();
        timKiemThuocThayThe(input);
    }
}

function themSubstituteTheoId(sourceEl, pId) {
    const p = danhSachThuocHeThong.find(t => t.id == pId);
    if (!p) return;

    const groupItem = sourceEl.closest('.combo-group-item');
    const chipsContainer = groupItem?.querySelector('.group-substitutes-chips');
    const wrapper = sourceEl.closest('.group-sub-search-wrapper');
    const input = wrapper?.querySelector('.sub-search-input');
    const dropdown = wrapper?.querySelector('.sub-search-dropdown');

    if (chipsContainer) {
        const exists = chipsContainer.querySelector(`.substitute-chip[data-id="${p.id}"]`);
        if (!exists) {
            const chip = document.createElement('span');
            chip.className = 'substitute-chip inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-300 text-xs font-semibold shadow-2xs';
            chip.dataset.id = p.id;
            chip.innerHTML = `
                <span>🔄 ${escapeHtmlBenh(p.name)}</span>
                <button type="button" onclick="this.closest('.substitute-chip').remove()" class="text-red-500 hover:text-red-700 font-bold cursor-pointer leading-none">&times;</button>
            `;
            chipsContainer.appendChild(chip);
        }
    }

    if (input) input.value = '';
    if (dropdown) dropdown.classList.add('hidden');
    wrapper?.querySelector('.btn-clear-sub-search')?.classList.add('hidden');
}

function taoGroupRowHtml(mode, comboIdx, groupIdx, groupData = {}) {
    const isFirst = groupIdx === 0;
    const operatorBadge = isFirst
        ? '<span class="font-black text-emerald-800 text-xs">Thuốc 1 (Thuốc chính)</span>'
        : '<span class="font-black text-emerald-800 text-xs flex items-center gap-1"><span class="bg-emerald-600 text-white rounded-full w-4 h-4 inline-flex items-center justify-center text-[10px] font-black leading-none">+</span> Phối hợp cùng:</span>';

    const subIds = Array.isArray(groupData.substitute_ids) ? groupData.substitute_ids : [];
    let chipsHtml = '';
    subIds.forEach(sid => {
        const p = danhSachThuocHeThong.find(item => item.id == sid);
        if (p) {
            chipsHtml += `
                <span class="substitute-chip inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-300 text-xs font-semibold shadow-2xs" data-id="${p.id}">
                    <span>🔄 ${escapeHtmlBenh(p.name)}</span>
                    <button type="button" onclick="this.closest('.substitute-chip').remove()" class="text-red-500 hover:text-red-700 font-bold cursor-pointer leading-none">&times;</button>
                </span>
            `;
        }
    });

    const primaryPesticide = danhSachThuocHeThong.find(item => String(item.id) === String(groupData.primary_pesticide_id));
    const hasPrimary = Boolean(primaryPesticide);

    const primaryThumb = primaryPesticide && primaryPesticide.image_url
        ? `<img src="${escapeHtmlBenh(primaryPesticide.image_url)}" class="w-full h-full object-cover">`
        : `<span class="text-base">🧪</span>`;

    const primaryExtra = primaryPesticide
        ? [
            primaryPesticide.active_ingredient ? `HC: ${escapeHtmlBenh(primaryPesticide.active_ingredient)}` : '',
            primaryPesticide.form_type ? `Dạng: ${escapeHtmlBenh(primaryPesticide.form_type)}` : '',
            primaryPesticide.water_volume ? `💧 ${escapeHtmlBenh(primaryPesticide.water_volume)}` : '',
          ].filter(Boolean).join(' • ')
        : '';

    return `
        <div class="combo-group-item bg-white border border-gray-200 rounded-xl p-3 space-y-2.5 shadow-2xs transition-all relative">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                    ${operatorBadge}
                    <input type="text" class="group-label text-xs border border-gray-300 rounded-lg px-2.5 py-1 flex-1 focus:ring-2 focus:ring-emerald-400 outline-none"
                        placeholder="Vai trò (VD: Thuốc trừ nấm / Kháng sinh loét...)"
                        value="${escapeHtmlBenh(groupData.label || '')}">
                </div>
                <button type="button" onclick="xoaThuocKhoiCombo(this)"
                    class="btn-xoa-group text-xs text-red-500 hover:text-red-700 px-2 py-0.5 rounded-md hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors cursor-pointer ${isFirst ? 'hidden' : ''}"
                    title="Xóa thuốc này khỏi combo">
                    ✕ Xóa thuốc này
                </button>
            </div>

            <!-- Bộ Chọn & Tìm Kiếm Thuốc Chính -->
            <div class="group-primary-picker-wrapper space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">
                        Sản phẩm thuốc chính: <span class="text-red-500">*</span>
                    </label>
                    <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 flex items-center gap-1">
                        <span>⚡</span> Gõ tìm trong 150+ thuốc
                    </span>
                </div>

                <input type="hidden" class="group-primary-select" value="${primaryPesticide ? primaryPesticide.id : ''}">

                <!-- Thẻ thuốc đã chọn -->
                <div class="group-primary-selected-card ${hasPrimary ? 'flex' : 'hidden'} items-center justify-between gap-2.5 p-2.5 rounded-xl bg-emerald-50/90 border-2 border-emerald-300 shadow-2xs">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <div class="group-selected-thumb w-10 h-10 rounded-lg overflow-hidden border border-emerald-300 bg-white shrink-0 flex items-center justify-center shadow-2xs">
                            ${primaryThumb}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="group-selected-name font-bold text-xs text-emerald-950 truncate">${primaryPesticide ? escapeHtmlBenh(primaryPesticide.name) : ''}</span>
                                <span class="group-selected-cat text-[10px] font-semibold px-1.5 py-0.5 rounded bg-emerald-200 text-emerald-900 ${primaryPesticide && primaryPesticide.category ? '' : 'hidden'}">${primaryPesticide && primaryPesticide.category ? escapeHtmlBenh(primaryPesticide.category) : ''}</span>
                            </div>
                            <div class="text-[10px] text-gray-600 truncate group-selected-extra mt-0.5 ${primaryExtra ? '' : 'hidden'}">
                                ${primaryExtra}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button" onclick="doiThuocChinh(this)" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold transition flex items-center gap-1 cursor-pointer shadow-2xs" title="Đổi sang thuốc khác">
                            <span>🔄 Đổi thuốc</span>
                        </button>
                        <button type="button" onclick="boChonThuocChinh(this)" class="p-1.5 rounded-xl bg-white hover:bg-red-50 text-red-500 hover:text-red-700 border border-gray-200 text-xs font-bold transition cursor-pointer" title="Bỏ chọn">
                            &times;
                        </button>
                    </div>
                </div>

                <!-- Hộp tìm kiếm có ô input và nút tìm kiếm -->
                <div class="group-primary-search-box relative ${hasPrimary ? 'hidden' : 'block'}">
                    <div class="relative flex items-center gap-1.5">
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-emerald-600 text-xs pointer-events-none">🔍</span>
                            <input type="text"
                                class="group-search-input w-full text-xs font-semibold border-2 border-emerald-300 rounded-xl pl-8 pr-8 py-2.5 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-400 outline-none transition placeholder-gray-400 shadow-2xs"
                                placeholder="Gõ tên thuốc, hoạt chất để tìm... (VD: tebaz, ridomil, kasu, thần địch...)"
                                oninput="timKiemThuocChinh(this)"
                                onfocus="moDropdownThuocChinh(this)"
                                autocomplete="off">
                            <button type="button" onclick="xoaInputSearch(this)" class="btn-clear-search absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm font-bold hidden cursor-pointer w-4 h-4 flex items-center justify-center rounded-full">&times;</button>
                        </div>
                        <button type="button" onclick="moDropdownThuocChinh(this.previousElementSibling.querySelector('input'))"
                            class="px-3.5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-2xs flex items-center gap-1.5 shrink-0 cursor-pointer transition">
                            <span>🔍 Tìm kiếm</span>
                        </button>
                    </div>
                    <!-- Dropdown kết quả tìm kiếm -->
                    <div class="group-search-dropdown absolute left-0 right-0 top-full mt-1.5 bg-white border-2 border-emerald-300 rounded-xl shadow-2xl max-h-64 overflow-y-auto z-50 divide-y divide-gray-100 hidden"></div>
                </div>
            </div>

            <!-- Thuốc Thay Thế Dự Phòng -->
            <div class="pt-2 border-t border-dashed border-gray-200">
                <div class="flex items-center justify-between gap-2 flex-wrap mb-1.5">
                    <span class="text-[11px] font-bold text-gray-700 flex items-center gap-1">
                        <span>🔄</span> Thuốc thay thế dự phòng (nếu hết thuốc chính):
                    </span>
                    <div class="group-sub-search-wrapper relative">
                        <div class="relative flex items-center">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-amber-600 text-xs pointer-events-none">🔍</span>
                            <input type="text"
                                class="sub-search-input text-xs border border-amber-300 rounded-lg pl-7 pr-6 py-1 bg-amber-50/40 text-gray-800 placeholder-amber-800/60 focus:bg-white focus:ring-2 focus:ring-amber-400 outline-none w-48 sm:w-64 transition"
                                placeholder="+ Gõ tìm thuốc thay thế..."
                                oninput="timKiemThuocThayThe(this)"
                                onfocus="moDropdownThuocThayThe(this)"
                                autocomplete="off">
                            <button type="button" onclick="xoaSubInputSearch(this)" class="btn-clear-sub-search absolute right-1.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs font-bold hidden cursor-pointer w-4 h-4 flex items-center justify-center">&times;</button>
                        </div>
                        <div class="sub-search-dropdown absolute right-0 top-full mt-1 w-72 sm:w-84 bg-white border border-amber-300 rounded-xl shadow-2xl max-h-60 overflow-y-auto z-50 divide-y divide-gray-100 hidden"></div>
                    </div>
                </div>
                <div class="group-substitutes-chips flex flex-wrap items-center gap-1.5 min-h-[24px]">
                    ${chipsHtml}
                </div>
            </div>
        </div>
    `;
}

function taoComboCardHtml(mode, comboIdx, comboData = {}) {
    const groups = Array.isArray(comboData.groups) && comboData.groups.length > 0
        ? comboData.groups
        : [{ label: '', primary_pesticide_id: null, substitute_ids: [] }];

    let groupsHtml = '';
    groups.forEach((g, gIdx) => {
        groupsHtml += taoGroupRowHtml(mode, comboIdx, gIdx, g);
    });

    return `
        <div class="combo-card bg-white border-2 border-emerald-300/90 rounded-2xl p-4 shadow-xs space-y-3.5 transition-all">
            <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-gray-100">
                <div class="flex items-center gap-2 flex-1 min-w-0">
                    <span class="combo-number-badge px-2.5 py-1 rounded-lg bg-emerald-700 text-white font-black text-xs shrink-0 shadow-xs">
                        Combo #${comboIdx + 1}
                    </span>
                    <input type="text" class="combo-title w-full text-xs sm:text-sm font-bold border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
                        placeholder="Tên combo (VD: Phác đồ 1: Cặp đôi Mát Lá - Mát Hoa & Ngừa Sẹo Đọt Non)"
                        value="${escapeHtmlBenh(comboData.title || '')}">
                </div>
                <button type="button" onclick="xoaComboCard(this, '${mode}')"
                    class="px-2.5 py-1.5 rounded-xl text-red-600 hover:bg-red-50 text-xs font-bold transition flex items-center gap-1 shrink-0 border border-red-200 cursor-pointer shadow-2xs"
                    title="Xóa combo này">
                    🗑️ <span class="hidden sm:inline">Xóa combo</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">🏷️ Huy hiệu (Badge)</label>
                    <input type="text" class="combo-badge w-full text-xs border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
                        placeholder="VD: Cặp đôi phối hợp (2 trong 1) / Combo 3 món..."
                        value="${escapeHtmlBenh(comboData.badge || '')}">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">🌱 Giai đoạn sử dụng</label>
                    <input type="text" class="combo-stage w-full text-xs border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
                        placeholder="VD: Giai đoạn nhú cơi đọt non (1 - 2cm), dưỡng hoa nở rộ..."
                        value="${escapeHtmlBenh(comboData.stage || '')}">
                </div>
            </div>

            <div class="bg-gray-50/70 border border-emerald-100 rounded-xl p-3.5 space-y-3">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <span class="text-xs font-black text-emerald-950 flex items-center gap-1.5">
                        <span>🔗</span> CÁC THUỐC PHỐI HỢP TRONG COMBO NÀY:
                    </span>
                    <button type="button" onclick="themThuocVaoCombo(this, '${mode}')"
                        class="text-xs font-bold text-emerald-800 hover:text-emerald-950 bg-emerald-100/90 hover:bg-emerald-200 px-3 py-1 rounded-lg transition flex items-center gap-1 cursor-pointer shadow-2xs">
                        <span>➕</span> Thêm thuốc vào combo này
                    </button>
                </div>

                <div class="combo-groups-container space-y-3">
                    ${groupsHtml}
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-700 mb-1">💧 Cách pha & Liều lượng chung</label>
                <textarea class="combo-dosage w-full text-xs border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 outline-none resize-none" rows="2"
                    placeholder="VD: Pha 1 gói Antracol (1kg) + 1 chai Kasugacin (450ml) cho 400 - 500 lít nước (2 phuy 200L)...">${escapeHtmlBenh(comboData.dosage_guide || '')}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-700 mb-1">⚠️ Lưu ý an toàn & Chống kết tủa</label>
                <textarea class="combo-safety w-full text-xs border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 outline-none resize-none" rows="2"
                    placeholder="VD: Cặp đôi này cực kỳ an toàn, mát hoa mát quả, không kết tủa. Tuyệt đối KHÔNG trộn chung với thuốc gốc đồng...">${escapeHtmlBenh(comboData.safety_note || '')}</textarea>
            </div>
        </div>
    `;
}

function renderCombosList(mode, plans = []) {
    const container = document.getElementById(`${mode}-combos-container`);
    const emptyEl   = document.getElementById(`${mode}-combos-empty`);
    if (!container) return;

    container.innerHTML = '';
    const arr = Array.isArray(plans) ? plans : [];

    if (arr.length === 0) {
        if (emptyEl) emptyEl.classList.remove('hidden');
        return;
    }

    if (emptyEl) emptyEl.classList.add('hidden');
    arr.forEach((plan, idx) => {
        container.insertAdjacentHTML('beforeend', taoComboCardHtml(mode, idx, plan));
    });
}

function themComboMoi(mode, defaultData = {}) {
    const container = document.getElementById(`${mode}-combos-container`);
    const emptyEl   = document.getElementById(`${mode}-combos-empty`);
    if (!container) return;

    if (emptyEl) emptyEl.classList.add('hidden');
    const curCount = container.querySelectorAll('.combo-card').length;
    container.insertAdjacentHTML('beforeend', taoComboCardHtml(mode, curCount, defaultData));
    capNhatSoThuTuCombos(mode);

    const lastCard = container.lastElementChild;
    lastCard?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    lastCard?.querySelector('.combo-title')?.focus();
}

function xoaComboCard(btn, mode) {
    const card = btn.closest('.combo-card');
    if (!card) return;
    card.remove();
    capNhatSoThuTuCombos(mode);
}

function capNhatSoThuTuCombos(mode) {
    const container = document.getElementById(`${mode}-combos-container`);
    const emptyEl   = document.getElementById(`${mode}-combos-empty`);
    if (!container) return;

    const cards = container.querySelectorAll('.combo-card');
    if (cards.length === 0) {
        if (emptyEl) emptyEl.classList.remove('hidden');
        return;
    }
    if (emptyEl) emptyEl.classList.add('hidden');

    cards.forEach((c, idx) => {
        const badge = c.querySelector('.combo-number-badge');
        if (badge) badge.textContent = `Combo #${idx + 1}`;
    });
}

function themThuocVaoCombo(btn, mode) {
    const card = btn.closest('.combo-card');
    const container = card?.querySelector('.combo-groups-container');
    if (!container) return;

    const curGroups = container.querySelectorAll('.combo-group-item');
    const newIdx = curGroups.length;
    container.insertAdjacentHTML('beforeend', taoGroupRowHtml(mode, 0, newIdx, {}));

    if (container.querySelectorAll('.combo-group-item').length > 1) {
        container.querySelectorAll('.btn-xoa-group').forEach(b => b.classList.remove('hidden'));
    }
}

function xoaThuocKhoiCombo(btn) {
    const item = btn.closest('.combo-group-item');
    const container = item?.closest('.combo-groups-container');
    if (!item || !container) return;

    item.remove();
    const remaining = container.querySelectorAll('.combo-group-item');
    if (remaining.length === 1) {
        remaining[0].querySelector('.btn-xoa-group')?.classList.add('hidden');
    }
}

function chonThuocThayThe(selectEl) {
    const pId = selectEl.value;
    if (!pId) return;

    const p = danhSachThuocHeThong.find(t => String(t.id) === String(pId));
    if (!p) return;

    const parent = selectEl.closest('.combo-group-item');
    const chipsContainer = parent?.querySelector('.group-substitutes-chips');
    if (!chipsContainer) return;

    const exists = chipsContainer.querySelector(`.substitute-chip[data-id="${p.id}"]`);
    if (exists) {
        selectEl.value = '';
        return;
    }

    const chip = document.createElement('span');
    chip.className = 'substitute-chip inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-900 border border-amber-200 text-xs font-semibold';
    chip.dataset.id = p.id;
    chip.innerHTML = `
        <span>🔄 ${escapeHtmlBenh(p.name)}</span>
        <button type="button" onclick="this.closest('.substitute-chip').remove()" class="text-red-500 hover:text-red-700 font-bold ml-0.5 cursor-pointer leading-none">&times;</button>
    `;
    chipsContainer.appendChild(chip);
    selectEl.value = '';
}

function thuThapCombos(mode) {
    const container = document.getElementById(`${mode}-combos-container`);
    if (!container) return [];

    const cards = container.querySelectorAll('.combo-card');
    const combos = [];

    cards.forEach((card, cIdx) => {
        const title = card.querySelector('.combo-title')?.value.trim() || '';
        const badge = card.querySelector('.combo-badge')?.value.trim() || '';
        const stage = card.querySelector('.combo-stage')?.value.trim() || '';
        const dosage = card.querySelector('.combo-dosage')?.value.trim() || '';
        const safety = card.querySelector('.combo-safety')?.value.trim() || '';

        const groupItems = card.querySelectorAll('.combo-group-item');
        const groups = [];

        groupItems.forEach((gi, gIdx) => {
            const label = gi.querySelector('.group-label')?.value.trim() || '';
            const primaryId = gi.querySelector('.group-primary-select')?.value || '';
            const subChips = gi.querySelectorAll('.substitute-chip');
            const subIds = Array.from(subChips).map(c => parseInt(c.dataset.id)).filter(Boolean);

            if (primaryId || subIds.length > 0) {
                groups.push({
                    label: label,
                    operator: gIdx > 0 ? '➕' : '',
                    primary_pesticide_id: primaryId ? parseInt(primaryId) : null,
                    substitute_label: 'Hoặc có thể chọn thay thế bằng:',
                    substitute_ids: subIds,
                });
            }
        });

        if (title || groups.length > 0) {
            combos.push({
                title: title || `Phác đồ ${cIdx + 1}`,
                badge: badge,
                stage: stage,
                dosage_guide: dosage,
                safety_note: safety,
                groups: groups,
            });
        }
    });

    return combos;
}

// ============================================================
// Form Thêm Bệnh Submit
// ============================================================
function initFormThemBenh() {
    const form = document.getElementById('form-them-benh');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('btn-submit-them-benh');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang lưu...';
        form.querySelectorAll('.benh-error').forEach(el => el.textContent = '');

        const formData = new FormData(form);

        // Xóa các file mặc định trong input và nạp lại từ mảng themFilesArr
        formData.delete('images[]');
        themFilesArr.forEach(f => formData.append('images[]', f));

        // Nạp treatment_plans từ dynamic builder
        const themCombos = thuThapCombos('them');
        formData.append('treatment_plans', JSON.stringify(themCombos));

        try {
            const { ok, status, data } = await goiApiBenh('{{ route('ajax.benh.them') }}', 'POST', formData, true);

            if (ok && data.success) {
                dongModalThemBenh();
                form.reset();
                themFilesArr = [];
                document.getElementById('them-images-preview').innerHTML = '';
                document.getElementById('them-images-preview').classList.add('hidden');
                document.getElementById('row-empty-benh')?.remove();

                const tableBody = document.getElementById('bang-benh-body');
                const b = data.benh;
                const newTr = document.createElement('tr');
                newTr.className = 'hover:bg-gray-50 transition-colors';
                newTr.dataset.id = b.id;
                newTr.innerHTML = buildBenhRow(b);
                newTr.style.background = '#f0fdf4';
                tableBody.appendChild(newTr);
                setTimeout(() => newTr.style.background = '', 2500);

                const tongEl = document.getElementById('tong-so-benh');
                if (tongEl) tongEl.textContent = document.querySelectorAll('#bang-benh-body tr[data-id]').length;

                baoThongBaoBenh(data.thong_bao, 'success');
                window.capNhatTichChonBenh?.();
            } else if (status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const err = form.querySelector(`.benh-error[data-field="${field}"]`);
                    if (err) err.textContent = msgs[0];
                });
            } else {
                baoThongBaoBenh(data.message ?? 'Có lỗi xảy ra khi lưu.', 'error');
            }
        } catch (err) {
            baoThongBaoBenh('Lỗi kết nối khi thêm bệnh.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Lưu bệnh & bài thuốc';
        }
    });
}

// ============================================================
// Form Sửa Bệnh Submit
// ============================================================
function initFormSuaBenh() {
    const form = document.getElementById('form-sua-benh');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('btn-submit-sua-benh');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang lưu...';
        form.querySelectorAll('.benh-error-sua').forEach(el => el.textContent = '');

        const url = document.getElementById('sua-benh-url').value;
        const id  = document.getElementById('sua-benh-id').value;
        const formData = new FormData(form);

        // Nạp các ảnh mới từ mảng suaNewFilesArr
        formData.delete('images[]');
        suaNewFilesArr.forEach(f => formData.append('images[]', f));

        // Nạp existing_images[] còn lại
        formData.delete('existing_images[]');
        suaExistingArr.forEach(imgObj => formData.append('existing_images[]', imgObj.path));

        // Nạp treatment_plans từ dynamic builder
        const suaCombos = thuThapCombos('sua');
        formData.append('treatment_plans', JSON.stringify(suaCombos));

        try {
            const { ok, status, data } = await goiApiBenh(url, 'POST', formData, true);

            if (ok && data.success) {
                dongModalSuaBenh();
                const b = data.benh;
                const row = document.querySelector(`#bang-benh-body tr[data-id="${id}"]`);
                if (row) {
                    row.innerHTML = buildBenhRow(b);
                    row.style.background = '#f0fdf4';
                    setTimeout(() => row.style.background = '', 2500);
                }
                baoThongBaoBenh(data.thong_bao, 'success');
            } else if (status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const err = form.querySelector(`.benh-error-sua[data-field="${field}"]`);
                    if (err) err.textContent = msgs[0];
                });
            } else {
                baoThongBaoBenh(data.message ?? 'Có lỗi xảy ra khi lưu.', 'error');
            }
        } catch (err) {
            baoThongBaoBenh('Lỗi kết nối khi cập nhật bệnh.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Lưu thay đổi';
        }
    });
}

// ============================================================
// Render Row HTML cho bảng
// ============================================================
function buildBenhRow(b) {
    const urls = b.images_urls || (b.image_url ? [b.image_url] : []);
    const mainImg = urls[0] || null;
    const count = urls.length;

    let imgHtml = '';
    if (mainImg) {
        const badge = count > 1 ? `<span class="absolute -bottom-1 -right-1 bg-emerald-700 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full shadow border border-white">+${count}</span>` : '';
        imgHtml = `
            <div class="relative w-14 h-14 mx-auto">
                <img src="${escapeHtmlBenh(mainImg)}" alt="${escapeHtmlBenh(b.name)}"
                    class="w-14 h-14 object-cover rounded-lg border border-gray-200 cursor-pointer hover:ring-2 hover:ring-green-500 transition-all col-img"
                    onclick='moModalGalleryBenh(${JSON.stringify(urls)}, "${escapeHtmlBenh(b.name).replace(/"/g, '&quot;')}")'
                    title="Nhấp xem ${count} ảnh">
                ${badge}
            </div>
        `;
    } else {
        imgHtml = `<div class="w-14 h-14 bg-gray-100 rounded-lg border border-gray-200 mx-auto flex items-center justify-center text-xl text-gray-400">🌿</div>`;
    }

    const thuocBadges = (b.pesticides && b.pesticides.length > 0)
        ? '<div class="flex flex-wrap gap-1">' + b.pesticides.map(p => `
            <button type="button" onclick="xemAnhThuoc('${escapeHtmlBenh(p.image_url || '')}', '${escapeHtmlBenh(p.name).replace(/'/g, "\\'")}')"
                class="inline-block bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full border border-blue-200 cursor-pointer transition-colors"
                title="Bấm để xem ảnh thuốc">${escapeHtmlBenh(p.name)}</button>
          `).join('') + '</div>'
        : '<span class="text-xs text-gray-400">— Chưa có thuốc</span>';

    const pids = b.pesticides ? b.pesticides.map(p => p.id) : (b.pesticide_ids || []);
    const fullJson = {
        ...b,
        pesticide_ids: pids,
        treatment_plans: b.treatment_plans || [],
    };
    const jsonStr = JSON.stringify(fullJson).replace(/"/g, '&quot;');

    const symBadge = b.symptoms ? '<span class="bg-amber-50 text-amber-800 border border-amber-200 px-1.5 py-0.2 rounded font-medium">🔍 1.1 Triệu chứng</span>' : '';
    const prevBadge = b.prevention ? '<span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-1.5 py-0.2 rounded font-medium">🛡️ 1.2 Phòng bệnh</span>' : '';
    const treatBadge = b.treatment ? '<span class="bg-blue-50 text-blue-800 border border-blue-200 px-1.5 py-0.2 rounded font-medium">💊 1.3 Điều trị</span>' : '';
    const comboBadge = (b.treatment_plans && b.treatment_plans.length > 0)
        ? `<span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-1.5 py-0.2 rounded font-medium">🧪 ${b.treatment_plans.length} combo</span>`
        : '';

    let phacDoHtml = '<span class="text-gray-400">— Chưa cập nhật</span>';
    if (b.treatment) {
        phacDoHtml = `<div class="line-clamp-2 text-blue-900"><strong class="text-blue-700">Trị:</strong> ${escapeHtmlBenh(b.treatment)}</div>`;
    } else if (b.symptoms) {
        phacDoHtml = `<div class="line-clamp-2"><strong class="text-amber-700">TC:</strong> ${escapeHtmlBenh(b.symptoms)}</div>`;
    } else if (b.notes) {
        phacDoHtml = `<div class="line-clamp-2">${escapeHtmlBenh(b.notes)}</div>`;
    }

    return `
        <td class="px-3 py-3 text-center w-10">
            <input type="checkbox" class="chon-benh w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer"
                value="${b.id}" data-name="${escapeHtmlBenh(b.name)}">
        </td>
        <td class="px-3 py-3 text-center">${imgHtml}</td>
        <td class="px-4 py-3">
            <div class="font-semibold text-gray-900 col-name text-sm">${escapeHtmlBenh(b.name)}</div>
            <div class="flex flex-wrap items-center gap-1 mt-1 text-[11px]">
                ${symBadge} ${prevBadge} ${treatBadge} ${comboBadge}
            </div>
        </td>
        <td class="px-4 py-3 hidden md:table-cell col-thuoc">${thuocBadges}</td>
        <td class="px-4 py-3 text-gray-600 text-xs hidden lg:table-cell max-w-xs col-notes">${phacDoHtml}</td>
        <td class="px-4 py-3 text-right whitespace-nowrap">
            <div class="flex items-center justify-end gap-1">
                <button type="button"
                    onclick='moModalSuaBenh(${jsonStr})'
                    class="text-xs px-2 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer">Sửa</button>
                <button type="button"
                    onclick="xacNhanXoaBenh('${b.url_xoa}', '${escapeHtmlBenh(b.name).replace(/'/g, "\\'")}', this)"
                    class="text-xs px-2 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors cursor-pointer">Xóa</button>
            </div>
        </td>
    `;
}

// ============================================================
// Mở / Đóng Modal
// ============================================================
function moModalThemBenh() {
    themFilesArr = [];
    document.getElementById('form-them-benh')?.reset();
    document.getElementById('them-images-preview').innerHTML = '';
    document.getElementById('them-images-preview').classList.add('hidden');
    document.getElementById('them-img-count')?.classList.add('hidden');
    datLaiCheckboxThuoc('them-thuoc-list', 'them-thuoc-count', 'them-thuoc-cb', []);

    // Khởi tạo danh sách combo (trống)
    renderCombosList('them', []);

    document.getElementById('modal-them-benh').classList.remove('hidden');
    document.getElementById('form-them-benh')?.querySelector('[name="name"]')?.focus();
}

function dongModalThemBenh() {
    document.getElementById('modal-them-benh').classList.add('hidden');
}

function moModalSuaBenh(benh) {
    document.getElementById('sua-benh-id').value       = benh.id;
    document.getElementById('sua-benh-url').value      = benh.url_cap_nhat;
    document.getElementById('sua-benh-name').value     = benh.name;
    document.getElementById('sua-benh-symptoms').value = benh.symptoms || '';
    document.getElementById('sua-benh-prevention').value = benh.prevention || '';
    document.getElementById('sua-benh-treatment').value  = benh.treatment || '';
    document.getElementById('sua-benh-notes').value    = benh.notes || '';

    // Khởi tạo danh sách ảnh hiện có
    suaExistingArr = [];
    suaNewFilesArr = [];

    const rawPaths = Array.isArray(benh.images) && benh.images.length > 0
        ? benh.images
        : (benh.image ? [benh.image] : []);

    const urls = Array.isArray(benh.images_urls) && benh.images_urls.length > 0
        ? benh.images_urls
        : (benh.image_url ? [benh.image_url] : []);

    rawPaths.forEach((path, i) => {
        suaExistingArr.push({
            path: path,
            url: urls[i] || path
        });
    });

    renderSuaExistingGrid();
    renderSuaNewPreview();

    // Checkbox thuốc
    datLaiCheckboxThuoc('sua-thuoc-list', 'sua-thuoc-count', 'sua-thuoc-cb', benh.pesticide_ids || []);

    // Khởi tạo danh sách combo phác đồ từ DB
    renderCombosList('sua', benh.treatment_plans || []);

    document.getElementById('modal-sua-benh').classList.remove('hidden');
    document.getElementById('sua-benh-name').focus();
}

function dongModalSuaBenh() {
    document.getElementById('modal-sua-benh').classList.add('hidden');
}

// Xóa 1 bệnh
function xacNhanXoaBenh(url, name, btn) {
    const modal = document.getElementById('delete-modal');
    const modalText = document.getElementById('delete-modal-text');
    const xoaBtn = document.getElementById('ajax-xoa-btn');
    if (!modal || !xoaBtn) return;

    xoaBtn.disabled = false;
    xoaBtn.textContent = 'Xóa';
    modalText.innerHTML = `Bạn có chắc muốn xóa bệnh <strong>"${escapeHtmlBenh(name)}"</strong> không?`;
    modal.classList.remove('hidden');

    xoaBtn.onclick = async () => {
        xoaBtn.disabled = true;
        xoaBtn.textContent = 'Đang xóa...';
        try {
            const { ok, data } = await goiApiBenh(url, 'DELETE');
            if (ok && data.success) {
                const row = btn?.closest('tr');
                if (row) {
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        const remaining = document.querySelectorAll('#bang-benh-body tr[data-id]').length;
                        const tongEl = document.getElementById('tong-so-benh');
                        if (tongEl) tongEl.textContent = remaining;
                        window.capNhatTichChonBenh?.();
                    }, 300);
                }
                baoThongBaoBenh(data.thong_bao, 'success');
            } else {
                baoThongBaoBenh(data.message ?? 'Có lỗi xảy ra khi xóa.', 'error');
            }
        } catch (err) {
            baoThongBaoBenh('Lỗi kết nối khi xóa.', 'error');
        } finally {
            xoaBtn.disabled = false;
            xoaBtn.textContent = 'Xóa';
            document.getElementById('delete-modal')?.classList.add('hidden');
        }
    };
}

function datLaiCheckboxThuoc(listId, countId, cbClass, selectedIds) {
    const list = document.getElementById(listId);
    const ids = (selectedIds || []).map(String);
    list?.querySelectorAll(`input.${cbClass}`).forEach(cb => {
        cb.checked = ids.includes(cb.value);
        cb.closest('.thuoc-item')?.classList.toggle('bg-green-50', cb.checked);
    });
    capNhatSoDaTich(listId, countId, cbClass);
}

function capNhatSoDaTich(listId, countId, cbClass) {
    const list = document.getElementById(listId);
    const countEl = document.getElementById(countId);
    if (!list || !countEl) return;
    const n = list.querySelectorAll(`input.${cbClass}:checked`).length;
    if (n > 0) {
        countEl.textContent = n + ' đã chọn';
        countEl.classList.remove('hidden');
    } else {
        countEl.classList.add('hidden');
    }
}

// DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    initMultiImageUpload();
    initFormThemBenh();
    initFormSuaBenh();

    // Checkbox table
    const table = document.getElementById('bang-danh-benh');
    const chonTatCa = document.getElementById('chon-tat-ca-benh');
    const bar = document.getElementById('bulk-action-bar-benh');
    const countEl = document.getElementById('so-luong-da-chon-benh');
    const btnBoChon = document.getElementById('btn-bo-chon-benh');
    const btnXoaDaChon = document.getElementById('btn-xoa-da-chon-benh');

    window.capNhatTichChonBenh = function () {
        const checkboxes = document.querySelectorAll('.chon-benh');
        const checked = document.querySelectorAll('.chon-benh:checked');
        if (countEl) countEl.textContent = checked.length;
        if (bar) bar.classList.toggle('hidden', checked.length === 0);
        if (chonTatCa) {
            if (checkboxes.length === 0) { chonTatCa.checked = false; chonTatCa.indeterminate = false; }
            else if (checked.length === checkboxes.length) { chonTatCa.checked = true; chonTatCa.indeterminate = false; }
            else if (checked.length > 0) { chonTatCa.checked = false; chonTatCa.indeterminate = true; }
            else { chonTatCa.checked = false; chonTatCa.indeterminate = false; }
        }
    };

    chonTatCa?.addEventListener('change', () => {
        document.querySelectorAll('.chon-benh').forEach(cb => {
            cb.checked = chonTatCa.checked;
            cb.closest('tr')?.classList.toggle('bg-green-50/70', chonTatCa.checked);
        });
        window.capNhatTichChonBenh();
    });

    table?.addEventListener('change', (e) => {
        if (e.target.classList.contains('chon-benh')) {
            e.target.closest('tr')?.classList.toggle('bg-green-50/70', e.target.checked);
            window.capNhatTichChonBenh();
        }
    });

    btnBoChon?.addEventListener('click', () => {
        document.querySelectorAll('.chon-benh').forEach(cb => {
            cb.checked = false;
            cb.closest('tr')?.classList.remove('bg-green-50/70');
        });
        if (chonTatCa) { chonTatCa.checked = false; chonTatCa.indeterminate = false; }
        window.capNhatTichChonBenh();
    });

    btnXoaDaChon?.addEventListener('click', () => {
        const checked = Array.from(document.querySelectorAll('.chon-benh:checked'));
        if (checked.length === 0) return;
        const ids = checked.map(cb => cb.value);
        const modal = document.getElementById('delete-modal');
        const modalText = document.getElementById('delete-modal-text');
        const xoaBtn = document.getElementById('ajax-xoa-btn');
        if (!modal || !xoaBtn) return;

        modalText.innerHTML = `Bạn có chắc muốn xóa <strong>${ids.length} bệnh</strong> đã chọn không?`;
        modal.classList.remove('hidden');

        xoaBtn.onclick = async () => {
            xoaBtn.disabled = true;
            xoaBtn.textContent = 'Đang xóa...';
            try {
                const { ok, data } = await goiApiBenh('{{ route('ajax.benh.xoa-nhieu') }}', 'DELETE', { ids });
                if (ok && data.success) {
                    checked.forEach(cb => cb.closest('tr')?.remove());
                    const remaining = document.querySelectorAll('#bang-benh-body tr[data-id]').length;
                    const tongEl = document.getElementById('tong-so-benh');
                    if (tongEl) tongEl.textContent = remaining;
                    window.capNhatTichChonBenh();
                    baoThongBaoBenh(data.thong_bao, 'success');
                } else {
                    baoThongBaoBenh(data.message ?? 'Có lỗi khi xóa.', 'error');
                }
            } catch(e) {
                baoThongBaoBenh('Lỗi kết nối khi xóa.', 'error');
            } finally {
                xoaBtn.disabled = false;
                xoaBtn.textContent = 'Xóa';
                modal.classList.add('hidden');
            }
        };
    });

    // Search thuốc trong modals
    ['them-thuoc', 'sua-thuoc'].forEach(prefix => {
        const sInput = document.getElementById(`${prefix}-search`);
        const sList = document.getElementById(`${prefix}-list`);
        sInput?.addEventListener('input', () => {
            const kw = sInput.value.trim().toLowerCase();
            sList?.querySelectorAll('.thuoc-item').forEach(it => {
                const n = it.dataset.name || '';
                it.style.display = n.includes(kw) ? '' : 'none';
            });
        });
        sList?.addEventListener('change', () => capNhatSoDaTich(`${prefix}-list`, `${prefix}-count`, `${prefix}-cb`));
    });

    // Đóng các dropdown tìm kiếm thuốc khi click ra ngoài
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.group-primary-search-box')) {
            document.querySelectorAll('.group-search-dropdown').forEach(d => d.classList.add('hidden'));
        }
        if (!e.target.closest('.group-sub-search-wrapper')) {
            document.querySelectorAll('.sub-search-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });
});
</script>
</x-layouts.app>
