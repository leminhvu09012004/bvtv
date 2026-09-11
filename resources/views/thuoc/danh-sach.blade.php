<x-layouts.app title="Tất cả thuốc">
<div class="px-4 py-6 lg:px-8 lg:py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900">💊 Tất cả thuốc BVTV</h1>
            <p class="text-sm text-gray-500 mt-0.5" id="so-luong-ket-qua">{{ $pesticides->total() }} sản phẩm tìm thấy</p>
        </div>
        <div class="flex gap-2 self-start sm:self-auto">
            <button id="quick-add-btn"
                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                ➕ Thêm nhanh
            </button>
            <a href="{{ route('thuoc.them') }}"
               class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                📋 Thêm đầy đủ
            </a>
        </div>
    </div>

    <!-- Tìm kiếm & Lọc AJAX -->
    <div class="mb-5 space-y-3">
        <div class="relative">
            <input
                type="text"
                id="live-search-input"
                data-url="{{ route('ajax.tim-kiem') }}"
                placeholder="🔍 Gõ để tìm ngay — tên thuốc, hoạt chất, công dụng, cây trồng..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                autocomplete="off"
            >
            <div id="search-loading" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                <svg class="animate-spin h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <select id="filter-danh-muc" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->emoji }} {{ $cat->name }}</option>
                @endforeach
            </select>

            <input type="text" id="filter-cay-trong" value="{{ request('cay_trong') }}" placeholder="Lọc cây trồng..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-36">

            <input type="text" id="filter-hoat-chat" placeholder="Lọc hoạt chất..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-36">

            <button id="xoa-bo-loc"
                class="border border-gray-300 hover:bg-gray-50 text-gray-600 px-3 py-2 rounded-lg text-sm transition-colors">
                ✕ Xóa bộ lọc
            </button>
        </div>
    </div>

    <!-- Lọc nhanh theo cây trồng Tây Nguyên -->
    <div class="flex items-center gap-1.5 flex-wrap mb-4 bg-white border border-gray-200 rounded-xl p-2.5 shadow-xs">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-1">Cây Tây Nguyên:</span>
        <button type="button" onclick="locNhanhCayTrong('')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') ? 'bg-gray-100 text-gray-700 hover:bg-green-100' : 'bg-green-700 text-white' }} transition-colors" data-crop="">
            Tất cả
        </button>
        <button type="button" onclick="locNhanhCayTrong('Sầu riêng')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Sầu riêng' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Sầu riêng">
            🍈 Sầu riêng
        </button>
        <button type="button" onclick="locNhanhCayTrong('Cà phê')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Cà phê' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Cà phê">
            ☕ Cà phê
        </button>
        <button type="button" onclick="locNhanhCayTrong('Hồ tiêu')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Hồ tiêu' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Hồ tiêu">
            🌿 Hồ tiêu
        </button>
        <button type="button" onclick="locNhanhCayTrong('Chanh dây')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Chanh dây' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Chanh dây">
            🟣 Chanh dây
        </button>
        <button type="button" onclick="locNhanhCayTrong('Bơ')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Bơ' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Bơ">
            🥑 Bơ
        </button>
        <button type="button" onclick="locNhanhCayTrong('Mắc ca')"
            class="filter-crop-pill px-3 py-1 rounded-full text-xs font-medium {{ request('cay_trong') == 'Mắc ca' ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-green-100' }} transition-colors" data-crop="Mắc ca">
            🌰 Mắc ca
        </button>
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
                        <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">STT</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên thuốc</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Danh mục</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Hoạt chất</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Công dụng</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Cây trồng</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bang-thuoc-body" class="divide-y divide-gray-100">
                    @foreach($pesticides as $i => $pesticide)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $pesticide->id }}">
                            <td class="px-3 py-3 text-center w-10">
                                <input type="checkbox" class="chon-thuoc w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer" value="{{ $pesticide->id }}">
                            </td>
                            <td class="px-3 py-3 text-gray-400 text-xs">{{ $pesticides->firstItem() + $i }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    @if($pesticide->image_url)
                                        <div class="relative w-10 h-10 rounded-lg overflow-hidden border border-gray-200 shrink-0 cursor-pointer shadow-xs hover:ring-2 hover:ring-green-500 transition-all group"
                                             onclick="moModalAnh('{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                                             title="Nhấp để xem ảnh lớn">
                                            <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-base shrink-0 text-gray-400 select-none">
                                            {{ $pesticide->category->emoji ?? '💊' }}
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('thuoc.xem', $pesticide) }}" class="font-medium text-green-700 hover:underline">
                                            {{ $pesticide->name }}
                                        </a>
                                        @if($pesticide->concentration)
                                            <span class="ml-1 text-xs text-gray-400 font-mono">{{ $pesticide->concentration }}</span>
                                        @endif
                                        @if($pesticide->active_ingredient)
                                            <div class="text-xs text-gray-500 mt-0.5 md:hidden truncate">{{ $pesticide->active_ingredient }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                @if($pesticide->category)
                                    <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}"
                                       class="inline-flex items-center gap-1 text-xs bg-gray-100 hover:bg-green-100 text-gray-600 hover:text-green-700 px-2 py-0.5 rounded-full transition-colors">
                                        {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
                                    </a>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden md:table-cell">{{ $pesticide->active_ingredient ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell max-w-xs">
                                <span class="line-clamp-2">{{ $pesticide->usage ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell">
                                <span class="line-clamp-1">{{ $pesticide->crops ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('thuoc.xem', $pesticide) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">Xem</a>
                                    <a href="{{ route('thuoc.sua', $pesticide) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">Sửa</a>
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

    <!-- Phân trang (chỉ hiển thị khi không search) -->
    @if($pesticides->hasPages())
        <div class="mt-4" id="pagination-container">
            {{ $pesticides->links() }}
        </div>
    @endif
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Công dụng / Trị gì</label>
                <textarea name="usage" rows="2"
                    placeholder="Ví dụ: Trừ rầy nâu, bọ trĩ..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cây trồng sử dụng</label>
                <input type="text" id="quick-add-crops" name="crops"
                    placeholder="Ví dụ: Sầu riêng, Cà phê"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="flex flex-wrap gap-1 mt-1.5">
                    <span class="text-[11px] text-gray-400 self-center">Chọn nhanh:</span>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Sầu riêng')" class="text-xs px-2 py-0.5 rounded bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 transition-colors">+ Sầu riêng</button>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Cà phê')" class="text-xs px-2 py-0.5 rounded bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 transition-colors">+ Cà phê</button>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Hồ tiêu')" class="text-xs px-2 py-0.5 rounded bg-green-50 hover:bg-green-100 text-green-800 border border-green-200 transition-colors">+ Hồ tiêu</button>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Chanh dây')" class="text-xs px-2 py-0.5 rounded bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 transition-colors">+ Chanh dây</button>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Bơ')" class="text-xs px-2 py-0.5 rounded bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 transition-colors">+ Bơ</button>
                    <button type="button" onclick="themTagCayTrong('quick-add-crops', 'Mắc ca')" class="text-xs px-2 py-0.5 rounded bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 transition-colors">+ Mắc ca</button>
                </div>
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

<script>
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
</script>
</x-layouts.app>
