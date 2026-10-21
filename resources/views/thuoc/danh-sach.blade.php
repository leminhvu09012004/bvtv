<x-layouts.app title="Quản lý thuốc (Admin)">
<div class="px-4 py-4 lg:px-6 lg:py-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <div class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-200 text-amber-800 text-xs px-2.5 py-0.5 rounded-full font-semibold mb-1">
                ⚙️ Khu vực Quản trị
            </div>
            <h1 class="text-xl font-bold text-gray-900">Quản lý thuốc BVTV</h1>
            <p class="text-xs text-gray-500 mt-0.5" id="so-luong-ket-qua">
                @php
                    $hasActiveFilter = request()->filled('q') || request()->filled('category_id') || request()->filled('has_image') || (request('sort') && request('sort') !== 'name_asc');
                @endphp
                @if($hasActiveFilter)
                    <span class="font-bold text-emerald-700">{{ $pesticides->count() }}</span> / {{ $totalCount ?? $pesticides->count() }} sản phẩm tìm thấy • <span class="text-gray-400 text-[11px]">Đang áp dụng bộ lọc</span>
                @else
                    <span id="so-luong-so" class="font-semibold text-gray-800">{{ $pesticides->count() }}</span> sản phẩm
                    @if(isset($missingImageCount) && $missingImageCount > 0)
                        • <span class="text-amber-600 font-medium">⚠️ {{ $missingImageCount }} chưa có hình</span>
                    @endif
                    • Quản lý thêm, sửa, xóa
                @endif
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('thuoc.tra-cuu') }}"
               class="inline-flex items-center gap-1.5 border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap">
                👁️ Xem giao diện Người dùng
            </a>
            <button id="quick-add-btn"
                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap cursor-pointer">
                ➕ Thêm nhanh
            </button>
            <a href="{{ route('thuoc.xuat-ten') }}"
               class="inline-flex items-center gap-1.5 border border-emerald-300 bg-white hover:bg-emerald-50 text-emerald-800 px-3 py-2 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap shadow-2xs"
               title="Tải về file Excel chứa 1 cột tên sản phẩm">
                📊 Xuất 1 cột tên Excel
            </a>
            <a href="{{ route('thuoc.them') }}"
               class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3.5 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                📋 Thêm đầy đủ
            </a>
        </div>
    </div>

    <!-- Tìm kiếm & Lọc AJAX nâng cao -->
    <div class="mb-5 space-y-3 bg-white p-3.5 sm:p-4 rounded-xl border border-gray-200 shadow-2xs">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input
                type="text"
                id="live-search-input"
                data-url="{{ route('ajax.tim-kiem') }}"
                value="{{ request('q') }}"
                placeholder="{{ request('search_by') === 'active_ingredient' ? '🔍 Tìm kiếm theo hoạt chất (Ví dụ: Azoxystrobin, Mancozeb, Cypermethrin)...' : (request('search_by') === 'all' ? '🔍 Tìm tất cả: Tên thuốc, hoạt chất, quy cách, công dụng, ID (#54)...' : '🔍 Tìm kiếm theo tên thuốc (Ví dụ: 15-15-15, Kẽm EDTA, Huỳnh Lâm, Mancozeb, #54)...') }}"
                class="w-full pl-10 pr-16 py-2.5 bg-gray-50/70 hover:bg-white focus:bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all shadow-2xs"
                autocomplete="off"
            >
            <!-- Nút xóa nhanh text trong ô tìm kiếm -->
            <button type="button" id="clear-search-input"
                    style="{{ request('q') ? 'display: inline-flex;' : 'display: none;' }}"
                    class="absolute right-8 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors"
                    title="Xóa tìm kiếm (Phím Esc)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div id="search-loading" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                <svg class="animate-spin h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-2.5 pt-1">
            <div class="flex flex-wrap items-center gap-2">
                <!-- Dropdown Phạm vi tìm kiếm -->
                <div class="relative inline-block">
                    <select id="filter-pham-vi" class="border border-emerald-300 bg-emerald-50/70 text-emerald-800 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-green-500 shadow-2xs cursor-pointer hover:bg-emerald-100 transition-colors">
                        <option value="name" {{ request('search_by', 'name') === 'name' ? 'selected' : '' }}>🔤 Theo tên thuốc</option>
                        <option value="active_ingredient" {{ request('search_by') === 'active_ingredient' ? 'selected' : '' }}>🧪 Theo hoạt chất</option>
                        <option value="all" {{ request('search_by') === 'all' ? 'selected' : '' }}>🌐 Tìm tất cả (tên, hoạt chất, công dụng)</option>
                    </select>
                </div>

                <!-- Dropdown Danh mục -->
                <div class="relative inline-block">
                    <select id="filter-danh-muc" class="border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 shadow-2xs cursor-pointer hover:border-gray-400 transition-colors">
                        <option value="">📂 Tất cả danh mục ({{ $totalCount ?? $pesticides->count() }})</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (string)request('category_id') === (string)$cat->id ? 'selected' : '' }}>
                                {{ $cat->emoji }} {{ $cat->name }} ({{ $cat->pesticides_count ?? 0 }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Lọc ảnh -->
                <div class="relative inline-block">
                    <select id="filter-hinh-anh" class="border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 shadow-2xs cursor-pointer hover:border-gray-400 transition-colors">
                        <option value="">🖼️ Tất cả ảnh ({{ $totalCount ?? $pesticides->count() }})</option>
                        <option value="no" class="text-amber-700 font-semibold" {{ request('has_image') === 'no' ? 'selected' : '' }}>⚠️ Chưa có ảnh ({{ $missingImageCount ?? 0 }})</option>
                        <option value="yes" class="text-emerald-700" {{ request('has_image') === 'yes' ? 'selected' : '' }}>✅ Đã có ảnh ({{ $hasImageCount ?? 0 }})</option>
                    </select>
                </div>

                <!-- Dropdown Sắp xếp -->
                <div class="relative inline-block">
                    <select id="filter-sap-xep" class="border border-gray-300 rounded-lg px-3 py-2 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 shadow-2xs cursor-pointer hover:border-gray-400 transition-colors">
                        <option value="name_asc" {{ request('sort', 'name_asc') === 'name_asc' ? 'selected' : '' }}>🔤 Tên: A → Z</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>🔤 Tên: Z → A</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>🕒 Mới nhất trước</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>🔢 ID tăng dần</option>
                    </select>
                </div>

                <!-- Nút Xóa bộ lọc (Chỉ hiện khi có lọc) -->
                <button id="xoa-bo-loc"
                    type="button"
                    style="display: none;"
                    class="inline-flex items-center gap-1 border border-red-200 bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Xóa bộ lọc</span>
                </button>
            </div>

            <!-- Phím tắt trợ giúp nhanh -->
            <div class="hidden lg:flex items-center gap-1.5 text-xs text-gray-400 select-none">
                <span class="bg-gray-100 border border-gray-200 px-1.5 py-0.5 rounded text-[11px] font-mono text-gray-500">Esc</span> để xóa ô tìm kiếm
            </div>
        </div>

        <!-- Thanh thông báo kết quả lọc động (Chỉ hiện khi có lọc) -->
        <div id="filter-active-tags" style="display: none;" class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-gray-100 text-xs text-gray-600">
            <span class="font-medium text-gray-500">Đang lọc:</span>
            <div id="filter-tag-chips" class="flex flex-wrap items-center gap-1.5"></div>
        </div>
    </div>


    <!-- Empty state (ẩn khi có kết quả) -->
    <div id="empty-state" class="hidden bg-white border border-dashed border-gray-300 rounded-xl py-16 text-center">
        <div class="text-4xl mb-3">🔍</div>
        <p class="text-gray-500 mb-4">Không tìm thấy sản phẩm nào.</p>
        <button id="quick-add-btn-empty"
            onclick="document.getElementById('quick-add-btn').click()"
            class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            ➕ Thêm thuốc mới
        </button>
    </div>

    <!-- Bảng thuốc -->
    @if($pesticides->isEmpty())
        <div id="empty-state-init" class="bg-white border border-dashed border-gray-300 rounded-xl py-16 text-center">
            <div class="text-4xl mb-3">📭</div>
            <p class="text-gray-500 mb-4">Chưa có thuốc nào. Hãy thêm thuốc đầu tiên!</p>
            <button onclick="document.getElementById('quick-add-btn').click()"
                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                ➕ Thêm thuốc đầu tiên
            </button>
        </div>
    @endif

    <!-- Thanh thao tác chọn nhiều (ẩn khi chưa chọn gì) -->
    <div id="bulk-action-bar" class="hidden mb-4 p-3 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between gap-3 shadow-sm transition-all duration-200">
        <div class="flex items-center gap-2 text-sm text-green-900 font-medium">
            <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-1.5 rounded-full bg-green-600 text-white text-xs font-bold" id="so-luong-da-chon">0</span>
            <span>thuốc đã được chọn</span>
        </div>
        <div class="flex items-center gap-2">
            <button id="btn-bo-chon" type="button" class="text-xs px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                Bỏ chọn
            </button>
            <button id="btn-xoa-da-chon" type="button" class="inline-flex items-center gap-1.5 text-xs px-3.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Xóa các mục đã chọn</span>
            </button>
        </div>
    </div>

    <div id="bang-thuoc" class="{{ $pesticides->isEmpty() ? 'hidden' : '' }} bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-center w-10">
                            <input type="checkbox" id="chon-tat-ca" title="Chọn tất cả" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                        </th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[340px] md:min-w-[380px]">Tên thuốc</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell whitespace-nowrap">Danh mục</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell whitespace-nowrap">Hoạt chất</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Công dụng</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bang-thuoc-body" class="divide-y divide-gray-100">
                    @foreach($pesticides as $i => $pesticide)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $pesticide->id }}">
                            <td class="px-3 py-3 text-center w-10">
                                <input type="checkbox" class="chon-thuoc w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer" value="{{ $pesticide->id }}">
                            </td>
                            <td class="px-4 py-3 min-w-[340px] md:min-w-[380px]">
                                <div class="flex items-center gap-3">
                                    @if($pesticide->image_url)
                                        <div class="relative w-16 h-16 rounded-xl overflow-hidden border border-gray-200 shrink-0 cursor-pointer shadow-xs hover:ring-2 hover:ring-green-500 transition-all group bg-white"
                                             onclick="moModalAnh(document.getElementById('admin-img-{{ $pesticide->id }}')?.src || '{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                                             title="Nhấp để xem ảnh lớn">
                                            <img id="admin-img-{{ $pesticide->id }}" src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-all">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-lg">💊</div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('thuoc.xem', [$pesticide, 'admin' => 1]) }}" class="font-medium text-green-700 hover:underline">
                                            {{ $pesticide->name }}
                                        </a>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                            @if($pesticide->concentration)
                                                <span class="text-xs text-gray-500 font-mono">{{ $pesticide->concentration }}</span>
                                            @endif
                                            @if($pesticide->water_volume)
                                                <span class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded border border-blue-200/60 inline-flex items-center gap-0.5" title="Lượng nước pha khuyến cáo">
                                                    💧 Pha: {{ $pesticide->water_volume }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($pesticide->active_ingredient)
                                            <div class="text-xs text-gray-500 mt-0.5 md:hidden truncate">{{ $pesticide->active_ingredient }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell whitespace-nowrap">
                                @if($pesticide->category)
                                    <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}"
                                       class="inline-flex items-center gap-1 text-xs bg-gray-100 hover:bg-green-100 text-gray-600 hover:text-green-700 px-2.5 py-1 rounded-full transition-colors whitespace-nowrap font-medium">
                                        {{ $pesticide->category->name }}
                                    </a>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden md:table-cell">{{ $pesticide->active_ingredient ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell">
                                <span class="line-clamp-2">{{ $pesticide->usage ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('thuoc.xem', [$pesticide, 'admin' => 1]) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">Xem</a>
                                    <button type="button"
                                            onclick="BVTV.moModalSuaNhanh(@js([
                                                'id' => $pesticide->id,
                                                'name' => $pesticide->name,
                                                'category_id' => $pesticide->category_id,
                                                'active_ingredient' => $pesticide->active_ingredient,
                                                'concentration' => $pesticide->concentration,
                                                'water_volume' => $pesticide->water_volume,
                                                'crops' => $pesticide->crops,
                                                'usage' => $pesticide->usage,
                                                'update_url' => route('ajax.thuoc.quick-update', $pesticide)
                                            ]))"
                                            class="text-xs px-2.5 py-1 rounded-md text-amber-700 bg-amber-50 hover:bg-amber-100 font-semibold transition-colors">
                                        ⚡ Sửa nhanh
                                    </button>
                                    <a href="{{ route('thuoc.sua', [$pesticide, 'from' => 'quan-ly']) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">Đầy đủ</a>
                                    <button
                                        onclick="BVTV.xacNhanXoaAjax('{{ route('ajax.xoa', $pesticide) }}', '{{ addslashes($pesticide->name) }}', this)"
                                        class="text-xs px-2.5 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================== -->
<!-- Quick-Add Modal                                             -->
<!-- ========================================================== -->
<div id="quick-add-modal" class="hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/50 px-0 sm:px-4">
    <div class="bg-white rounded-t-2xl sm:rounded-xl shadow-xl w-full sm:max-w-md">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">➕ Thêm thuốc nhanh</h3>
            <button id="quick-add-close" class="text-gray-400 hover:text-gray-600 p-1 rounded-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="quick-add-form" data-url="{{ route('ajax.them-nhanh') }}" class="px-5 py-4 space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tên thuốc <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required
                    placeholder="Ví dụ: Actara 25WG"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <p class="field-error text-red-500 text-xs mt-1" data-field="name"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Danh mục <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->emoji }} {{ $cat->name }}</option>
                    @endforeach
                </select>
                <p class="field-error text-red-500 text-xs mt-1" data-field="category_id"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hoạt chất</label>
                <input type="text" name="active_ingredient"
                    placeholder="Ví dụ: Thiamethoxam"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💧 Lượng nước pha</label>
                <input type="text" name="water_volume"
                    placeholder="Ví dụ: 400 - 500 lít (2 phuy)"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Công dụng / Trị gì</label>
                <textarea name="usage" rows="2"
                    placeholder="Ví dụ: Trừ rầy nâu, bọ trĩ..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                <textarea name="notes" rows="2"
                    placeholder="Ghi chú thực tế tại cửa hàng..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors">
                    💾 Lưu thuốc
                </button>
                <button type="button" id="quick-add-close-bottom"
                    onclick="document.getElementById('quick-add-close').click()"
                    class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Hủy
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================== -->
<!-- Quick-Edit Modal (Sửa nhanh thông số thuốc)                 -->
<!-- ========================================================== -->
<div id="quick-edit-modal" class="hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/50 px-0 sm:px-4">
    <div class="bg-white rounded-t-2xl sm:rounded-xl shadow-xl w-full sm:max-w-md max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 flex items-center gap-1.5">
                <span>⚡</span> Sửa nhanh thông số thuốc
            </h3>
            <button type="button" id="quick-edit-close" class="text-gray-400 hover:text-gray-600 p-1 rounded-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="quick-edit-form" class="px-5 py-4 space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tên thuốc <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                <p class="field-error text-red-500 text-xs mt-1" data-field="name"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Danh mục <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->emoji }} {{ $cat->name }}</option>
                    @endforeach
                </select>
                <p class="field-error text-red-500 text-xs mt-1" data-field="category_id"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hoạt chất</label>
                <input type="text" name="active_ingredient"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hàm lượng / Nồng độ</label>
                <input type="text" name="concentration"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💧 Lượng nước pha</label>
                <input type="text" name="water_volume"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cây trồng đăng ký</label>
                <input type="text" name="crops"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Công dụng / Trị bệnh</label>
                <textarea name="usage" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-amber-600 hover:bg-amber-700 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    💾 Cập nhật ngay
                </button>
                <button type="button" id="quick-edit-cancel"
                    class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Hủy
                </button>
            </div>
        </form>
    </div>
</div>

<script>
window.BVTV_TOTAL_COUNT = {{ $totalCount ?? $pesticides->count() }};
function locNhanhCayTrong(crop) {
    const input = document.getElementById('filter-cay-trong');
    if (!input) return;
    input.value = crop;
    document.querySelectorAll('.filter-crop-pill').forEach(btn => {
        if (btn.dataset.crop === crop) {
            btn.className = 'filter-crop-pill px-3 py-1 rounded-full text-xs font-medium bg-green-700 text-white shadow-xs transition-colors';
        } else {
            btn.className = 'filter-crop-pill px-3 py-1 rounded-full text-xs font-medium bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-800 transition-colors';
        }
    });
    input.dispatchEvent(new Event('input', { bubbles: true }));
}

function themTagCayTrong(inputId, cropName) {
    const el = document.getElementById(inputId);
    if (!el) return;
    const current = el.value.trim();
    if (!current) {
        el.value = cropName;
    } else {
        const parts = current.split(',').map(s => s.trim());
        if (!parts.includes(cropName)) {
            parts.push(cropName);
            el.value = parts.join(', ');
        }
    }
}

// Khôi phục vị trí thanh cuộn CHỈ KHI vừa cập nhật sản phẩm xong (có updated_id trên URL)
document.addEventListener('DOMContentLoaded', () => {
    // Xóa sạch session cũ để không bao giờ bị kẹt cuộn khi F5
    try {
        sessionStorage.removeItem('bvtv_quan_ly_last_id');
        sessionStorage.removeItem('bvtv_quan_ly_scroll');
    } catch(e) {}

    const urlParams = new URLSearchParams(window.location.search);
    const updatedId = urlParams.get('updated_id');
    const paramScroll = urlParams.get('scroll_y');

    // Nếu KHÔNG có updated_id hay scroll_y trên URL: Không làm gì cả, giữ nguyên trạng thái tự nhiên
    if (!updatedId && !paramScroll) {
        return;
    }

    let targetY = paramScroll ? parseInt(paramScroll, 10) : 0;
    let targetRow = null;

    if (updatedId) {
        targetRow = document.querySelector(`tr[data-id="${updatedId}"]`);
        if (targetRow) {
            targetRow.classList.add('bg-emerald-100/90', 'ring-2', 'ring-emerald-500', 'shadow-md', 'transition-all');
            setTimeout(() => {
                targetRow.classList.remove('ring-2', 'ring-emerald-500', 'shadow-md');
            }, 3000);
        }
    }

    const applyScroll = () => {
        if (targetY > 0) {
            window.scrollTo({ top: targetY, behavior: 'instant' });
        } else if (targetRow) {
            targetRow.scrollIntoView({ block: 'center', behavior: 'instant' });
        }
    };

    if (targetY > 0 || targetRow) {
        applyScroll();
        [50, 150, 350].forEach(delay => setTimeout(applyScroll, delay));
    }

    // Xóa sạch query param trên URL để các lần F5 tiếp theo hoàn toàn bình thường
    setTimeout(() => {
        if (urlParams.has('updated_id') || urlParams.has('scroll_y')) {
            urlParams.delete('updated_id');
            urlParams.delete('scroll_y');
            const cleanQuery = urlParams.toString() ? '?' + urlParams.toString() : '';
            try {
                history.replaceState(null, '', window.location.pathname + cleanQuery);
            } catch(e) {}
        }
    }, 500);
});

// Gắn tọa độ cuộn VÀ các bộ lọc hiện tại vào link Sửa để khi lưu xong quay về đúng bộ lọc đó
function layFilterHienTai() {
    const searchInput = document.getElementById('live-search-input');
    const filterScope = document.getElementById('filter-pham-vi');
    const filterCat = document.getElementById('filter-danh-muc');
    const filterImg = document.getElementById('filter-hinh-anh');
    const filterSort = document.getElementById('filter-sap-xep');

    return {
        q: searchInput ? searchInput.value.trim() : '',
        search_by: filterScope ? filterScope.value : 'name',
        category_id: filterCat ? filterCat.value : '',
        has_image: filterImg ? filterImg.value : '',
        sort: (filterSort && filterSort.value !== 'name_asc') ? filterSort.value : ''
    };
}

// Cập nhật href trước khi chuột nhấp hoặc chuột phải
document.addEventListener('pointerdown', (e) => {
    const link = e.target.closest('a[href*="/chinh-sua"]');
    if (!link) return;
    try {
        const scrollY = Math.round(window.scrollY);
        const f = layFilterHienTai();
        const u = new URL(link.href, window.location.origin);
        u.searchParams.set('scroll_y', String(scrollY));
        if (f.q) u.searchParams.set('filter_q', f.q); else u.searchParams.delete('filter_q');
        if (f.search_by && f.search_by !== 'name') u.searchParams.set('filter_search_by', f.search_by); else u.searchParams.delete('filter_search_by');
        if (f.category_id) u.searchParams.set('filter_category_id', f.category_id); else u.searchParams.delete('filter_category_id');
        if (f.has_image) u.searchParams.set('filter_has_image', f.has_image); else u.searchParams.delete('filter_has_image');
        if (f.sort) u.searchParams.set('filter_sort', f.sort); else u.searchParams.delete('filter_sort');
        link.href = u.toString();
    } catch(err) {}
});

document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href*="/chinh-sua"]');
    if (!link || link.target || e.ctrlKey || e.metaKey || e.shiftKey) return;

    e.preventDefault(); // Ngăn trình duyệt điều hướng href cũ trước khi thêm param

    const scrollY = Math.round(window.scrollY);
    const f = layFilterHienTai();

    // Lưu vào sessionStorage làm phương án dự phòng 100%
    try {
        sessionStorage.setItem('bvtv_admin_filters', JSON.stringify(f));
    } catch(err) {}

    const u = new URL(link.href, window.location.origin);
    u.searchParams.set('scroll_y', String(scrollY));
    if (f.q) u.searchParams.set('filter_q', f.q); else u.searchParams.delete('filter_q');
    if (f.search_by && f.search_by !== 'name') u.searchParams.set('filter_search_by', f.search_by); else u.searchParams.delete('filter_search_by');
    if (f.category_id) u.searchParams.set('filter_category_id', f.category_id); else u.searchParams.delete('filter_category_id');
    if (f.has_image) u.searchParams.set('filter_has_image', f.has_image); else u.searchParams.delete('filter_has_image');
    if (f.sort) u.searchParams.set('filter_sort', f.sort); else u.searchParams.delete('filter_sort');

    window.location.href = u.toString();
});

</script>
</x-layouts.app>
