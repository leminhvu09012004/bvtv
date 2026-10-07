<x-layouts.app :title="'Sửa: '.$pesticide->name">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-2xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        @if(($from ?? request('from')) === 'quan-ly')
            <a href="{{ route('thuoc.quan-ly') }}" class="hover:text-green-600">Quản lý thuốc</a>
        @else
            <a href="{{ route('thuoc.xem', [$pesticide, 'admin' => 1]) }}" class="hover:text-green-600">{{ $pesticide->name }}</a>
        @endif
        <span>/</span>
        <span class="text-gray-800 font-medium">Chỉnh sửa</span>
    </nav>

    <h1 class="text-xl font-bold text-gray-900 mb-6">✏️ Chỉnh sửa thông tin thuốc</h1>

    <form action="{{ route('thuoc.cap-nhat', $pesticide) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')
        <input type="hidden" name="from" value="{{ old('from', $from ?? request('from', 'quan-ly')) }}">
        <input type="hidden" name="scroll_y" id="input-scroll-y" value="{{ old('scroll_y', request('scroll_y')) }}">
        <input type="hidden" name="filter_q" id="input-filter-q" value="{{ old('filter_q', request('filter_q')) }}">
        <input type="hidden" name="filter_search_by" id="input-filter-search-by" value="{{ old('filter_search_by', request('filter_search_by')) }}">
        <input type="hidden" name="filter_category_id" id="input-filter-category-id" value="{{ old('filter_category_id', request('filter_category_id')) }}">
        <input type="hidden" name="filter_has_image" id="input-filter-has-image" value="{{ old('filter_has_image', request('filter_has_image')) }}">
        <input type="hidden" name="filter_sort" id="input-filter-sort" value="{{ old('filter_sort', request('filter_sort')) }}">


        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
            <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Thông tin chính</h2>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên thương phẩm <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $pesticide->name) }}" required autofocus
                    class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Hình ảnh thuốc
                </label>
                <div class="mt-1 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <!-- Ảnh hiện tại nếu có -->
                    @if($pesticide->image_url)
                        <div id="current-image-wrapper" class="relative w-24 h-24 rounded-xl border border-gray-200 p-1 bg-white shrink-0 shadow-sm">
                            <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-cover rounded-lg cursor-pointer" onclick="moModalAnh('{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')">
                            <span class="absolute bottom-1 right-1 bg-black/60 text-white text-[10px] px-1 rounded">Ảnh hiện tại</span>
                        </div>
                    @endif

                    <!-- Khung preview ảnh mới -->
                    <div id="image-preview-wrapper" class="hidden relative w-24 h-24 rounded-xl border-2 border-dashed border-green-400 bg-green-50/50 p-1 shrink-0 group">
                        <img id="image-preview" src="" alt="Xem trước ảnh mới" class="w-full h-full object-cover rounded-lg">
                        <button type="button" onclick="xoaAnhPreview()" title="Bỏ ảnh này"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow hover:bg-red-600 transition-colors">
                            &times;
                        </button>
                    </div>

                    <!-- Nút upload & vùng thả -->
                    <label for="image" class="flex-1 w-full cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 hover:border-green-500 rounded-xl p-4 bg-gray-50/60 hover:bg-green-50/20 transition-all text-center">
                        <span class="text-2xl mb-1">📷</span>
                        <span class="text-sm font-medium text-gray-700">
                            {{ $pesticide->image ? 'Thay đổi ảnh thuốc khác' : 'Tải ảnh lên hoặc kéo thả' }}
                        </span>
                        <span class="text-xs text-gray-400 mt-0.5">JPG, PNG, WEBP tối đa 5MB</span>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="hienThiAnhPreview(this)">
                    </label>
                </div>

                @if($pesticide->image)
                    <div class="mt-2.5 flex items-center gap-2">
                        <input type="checkbox" id="xoa_anh" name="xoa_anh" value="1" class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 cursor-pointer">
                        <label for="xoa_anh" class="text-xs text-red-600 font-medium cursor-pointer hover:underline">
                            🗑️ Xóa ảnh hiện tại (không dùng ảnh cho thuốc này)
                        </label>
                    </div>
                @endif
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
                <select id="category_id" name="category_id" required
                    class="w-full border @error('category_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $pesticide->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->emoji }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="active_ingredient" class="block text-sm font-medium text-gray-700 mb-1">Hoạt chất</label>
                <input type="text" id="active_ingredient" name="active_ingredient" value="{{ old('active_ingredient', $pesticide->active_ingredient) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="usage" class="block text-sm font-medium text-gray-700 mb-1">Công dụng / Trị gì</label>
                <textarea id="usage" name="usage" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-y"
                >{{ old('usage', $pesticide->usage) }}</textarea>
            </div>


            <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-xl flex items-start gap-2.5">
                <input type="checkbox" id="stains_fruit" name="stains_fruit" value="1" {{ old('stains_fruit', $pesticide->stains_fruit) ? 'checked' : '' }}
                    class="mt-0.5 w-4 h-4 text-amber-600 rounded border-gray-300 focus:ring-amber-500 cursor-pointer">
                <div>
                    <label for="stains_fruit" class="text-sm font-semibold text-amber-950 cursor-pointer flex items-center gap-1.5">
                        <span>🎨</span> Có thể dính màu vào trái
                    </label>
                    <p class="text-xs text-amber-800 mt-0.5">
                        Tích chọn nếu thuốc có màu đậm (Mancozeb xanh, Đồng đỏ, bột WP váng kẽm...) dễ bám dính vệt màu lên vỏ trái khi phun.
                    </p>
                </div>
            </div>



            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú / Kinh nghiệm thực tế</label>
                <textarea id="notes" name="notes" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-y"
                >{{ old('notes', $pesticide->notes) }}</textarea>
            </div>
        </div>


        <!-- Thông tin bổ sung -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <button type="button" onclick="batTatNangCao()"
                class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <span>Thông tin bổ sung</span>
                <svg id="mui-ten" class="w-4 h-4 text-gray-400 transition-transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="truong-nang-cao" class="border-t border-gray-100 px-5 pb-5 pt-4 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="concentration" class="block text-sm font-medium text-gray-700 mb-1">Hàm lượng / Quy cách</label>
                        <input type="text" id="concentration" name="concentration" value="{{ old('concentration', $pesticide->concentration) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="water_volume" class="block text-sm font-medium text-gray-700 mb-1">💧 Lượng nước pha khuyến cáo</label>
                        <input type="text" id="water_volume" name="water_volume" value="{{ old('water_volume', $pesticide->water_volume) }}"
                            placeholder="Ví dụ: 400 - 500 lít nước (2 phuy)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="form_type" class="block text-sm font-medium text-gray-700 mb-1">Dạng thuốc</label>
                        <input type="text" id="form_type" name="form_type" value="{{ old('form_type', $pesticide->form_type) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Đối tượng phòng/trừ</label>
                        <input type="text" id="target" name="target" value="{{ old('target', $pesticide->target) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="isolation_period" class="block text-sm font-medium text-gray-700 mb-1">Thời gian cách ly</label>
                        <input type="text" id="isolation_period" name="isolation_period" value="{{ old('isolation_period', $pesticide->isolation_period) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-1">Nhà sản xuất</label>
                        <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $pesticide->manufacturer) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-colors">
                💾 Lưu thay đổi
            </button>
            @php
                $cancelParams = ['updated_id' => $pesticide->id];
                if (request('filter_q')) $cancelParams['q'] = request('filter_q');
                if (request('filter_category_id')) $cancelParams['category_id'] = request('filter_category_id');
                if (request('filter_has_image')) $cancelParams['has_image'] = request('filter_has_image');
                if (request('filter_sort')) $cancelParams['sort'] = request('filter_sort');
                if (request('scroll_y')) $cancelParams['scroll_y'] = request('scroll_y');
            @endphp
            <a id="btn-huy-chinh-sua"
               href="{{ ($from ?? request('from', 'quan-ly')) === 'quan-ly' ? route('thuoc.quan-ly', $cancelParams) : route('thuoc.xem', [$pesticide, 'admin' => 1]) }}"
               class="flex-1 sm:flex-none text-center border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                Hủy
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollInput = document.getElementById('input-scroll-y');
        let savedY = null;
        if (scrollInput) {
            if (!scrollInput.value || scrollInput.value === '0') {
                savedY = sessionStorage.getItem('bvtv_quan_ly_scroll');
                if (savedY) {
                    scrollInput.value = savedY;
                }
            } else {
                savedY = scrollInput.value;
            }
        }

        const btnHuy = document.getElementById('btn-huy-chinh-sua');
        if (btnHuy && savedY) {
            try {
                const u = new URL(btnHuy.href, window.location.origin);
                u.searchParams.set('scroll_y', savedY);
                btnHuy.href = u.toString();
            } catch(e) {}
        }

        // Tự động khôi phục bộ lọc từ sessionStorage nếu URL chưa có
        try {
            const savedFilters = sessionStorage.getItem('bvtv_admin_filters');
            if (savedFilters) {
                const f = JSON.parse(savedFilters);
                const qEl = document.getElementById('input-filter-q');
                const scopeEl = document.getElementById('input-filter-search-by');
                const catEl = document.getElementById('input-filter-category-id');
                const imgEl = document.getElementById('input-filter-has-image');
                const sortEl = document.getElementById('input-filter-sort');

                if (qEl && !qEl.value && f.q) qEl.value = f.q;
                if (scopeEl && !scopeEl.value && f.search_by) scopeEl.value = f.search_by;
                if (catEl && !catEl.value && f.category_id) catEl.value = f.category_id;
                if (imgEl && !imgEl.value && f.has_image) imgEl.value = f.has_image;
                if (sortEl && !sortEl.value && f.sort && f.sort !== 'name_asc') sortEl.value = f.sort;

                if (btnHuy) {
                    const hu = new URL(btnHuy.href, window.location.origin);
                    if (f.q && !hu.searchParams.has('q')) hu.searchParams.set('q', f.q);
                    if (f.search_by && f.search_by !== 'name' && !hu.searchParams.has('search_by')) hu.searchParams.set('search_by', f.search_by);
                    if (f.category_id && !hu.searchParams.has('category_id')) hu.searchParams.set('category_id', f.category_id);
                    if (f.has_image && !hu.searchParams.has('has_image')) hu.searchParams.set('has_image', f.has_image);
                    if (f.sort && f.sort !== 'name_asc' && !hu.searchParams.has('sort')) hu.searchParams.set('sort', f.sort);
                    btnHuy.href = hu.toString();
                }
            }
        } catch(e) {}


    function batTatNangCao() {
        const truong = document.getElementById('truong-nang-cao');
        const muiTen = document.getElementById('mui-ten');
        truong.classList.toggle('hidden');
        muiTen.style.transform = truong.classList.contains('hidden') ? '' : 'rotate(180deg)';
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

    function hienThiAnhPreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-wrapper').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function xoaAnhPreview() {
        const input = document.getElementById('image');
        if (input) input.value = '';
        document.getElementById('image-preview').src = '';
        document.getElementById('image-preview-wrapper').classList.add('hidden');
    }
</script>
</x-layouts.app>
