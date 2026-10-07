<x-layouts.app title="Thêm thuốc mới">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-2xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('thuoc.quan-ly') }}" class="hover:text-green-600">Quản lý thuốc</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Thêm mới</span>
    </nav>

    <h1 class="text-xl font-bold text-gray-900 mb-6">➕ Thêm thuốc mới</h1>

    <form action="{{ route('thuoc.luu') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Thông tin chính -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
            <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Thông tin chính <span class="text-red-500">*</span></h2>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Tên thương phẩm <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Ví dụ: Actara 25WG"
                    autofocus required
                    class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Hình ảnh thuốc (tùy chọn)
                </label>
                <div class="mt-1 flex items-center gap-4">
                    <!-- Khung preview ảnh -->
                    <div id="image-preview-wrapper" class="hidden relative w-24 h-24 rounded-xl border-2 border-dashed border-green-400 bg-green-50/50 p-1 shrink-0 group">
                        <img id="image-preview" src="" alt="Xem trước" class="w-full h-full object-cover rounded-lg">
                        <button type="button" onclick="xoaAnhPreview()" title="Bỏ ảnh này"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow hover:bg-red-600 transition-colors">
                            &times;
                        </button>
                    </div>

                    <!-- Nút upload & vùng thả -->
                    <label for="image" class="flex-1 cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 hover:border-green-500 rounded-xl p-4 bg-gray-50/60 hover:bg-green-50/20 transition-all text-center">
                        <span class="text-2xl mb-1">📷</span>
                        <span class="text-sm font-medium text-gray-700"><span class="text-green-600 underline">Tải ảnh lên</span> hoặc kéo thả</span>
                        <span class="text-xs text-gray-400 mt-0.5">JPG, PNG, WEBP tối đa 5MB</span>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="hienThiAnhPreview(this)">
                    </label>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Danh mục <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id" required
                    class="w-full border @error('category_id') border-red-400 @else border-gray-300 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (old('category_id', $selectedCategoryId) == $cat->id) ? 'selected' : '' }}>
                            {{ $cat->emoji }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="active_ingredient" class="block text-sm font-medium text-gray-700 mb-1">Hoạt chất</label>
                <input type="text" id="active_ingredient" name="active_ingredient" value="{{ old('active_ingredient') }}"
                    placeholder="Ví dụ: Thiamethoxam"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="usage" class="block text-sm font-medium text-gray-700 mb-1">Công dụng / Trị gì</label>
                <textarea id="usage" name="usage" rows="3"
                    placeholder="Ví dụ: Trừ rầy nâu, bọ trĩ, rệp muội..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-y"
                >{{ old('usage') }}</textarea>
            </div>


            <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-xl flex items-start gap-2.5">
                <input type="checkbox" id="stains_fruit" name="stains_fruit" value="1" {{ old('stains_fruit') ? 'checked' : '' }}
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
                <textarea id="notes" name="notes" rows="3"
                    placeholder="Ghi lại những gì người hướng dẫn nói, kinh nghiệm riêng..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-y"
                >{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <button type="button" id="them-nang-cao-btn" onclick="batTatNangCao()"
                class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <span>Thông tin bổ sung (tùy chọn)</span>
                <svg id="mui-ten" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="truong-nang-cao" class="hidden border-t border-gray-100 px-5 pb-5 pt-4 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="concentration" class="block text-sm font-medium text-gray-700 mb-1">Hàm lượng / Quy cách</label>
                        <input type="text" id="concentration" name="concentration" value="{{ old('concentration') }}"
                            placeholder="Ví dụ: 400g/l (Chai 1 lít)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="water_volume" class="block text-sm font-medium text-gray-700 mb-1">💧 Lượng nước pha khuyến cáo</label>
                        <input type="text" id="water_volume" name="water_volume" value="{{ old('water_volume') }}"
                            placeholder="Ví dụ: 400 - 500 lít nước (2 phuy)"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="form_type" class="block text-sm font-medium text-gray-700 mb-1">Dạng thuốc</label>
                        <input type="text" id="form_type" name="form_type" value="{{ old('form_type') }}"
                            placeholder="EC, WP, SC, WG, SL..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Đối tượng phòng/trừ</label>
                        <input type="text" id="target" name="target" value="{{ old('target') }}"
                            placeholder="Ví dụ: Rầy nâu, nhện đỏ..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="isolation_period" class="block text-sm font-medium text-gray-700 mb-1">Thời gian cách ly</label>
                        <input type="text" id="isolation_period" name="isolation_period" value="{{ old('isolation_period') }}"
                            placeholder="Ví dụ: 7 ngày"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-1">Nhà sản xuất</label>
                        <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}"
                            placeholder="Ví dụ: Syngenta"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                </div>
            </div>
        </div>

        <!-- Nút hành động -->
        <div class="flex gap-3">
            <button type="submit"
                class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-colors">
                💾 Lưu thuốc
            </button>
            <a href="{{ route('thuoc.quan-ly') }}"
               class="flex-1 sm:flex-none text-center border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                Hủy
            </a>
        </div>
    </form>
</div>

<script>
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

    @if(old('concentration') || old('form_type') || old('target') || old('isolation_period') || old('manufacturer'))
        document.addEventListener('DOMContentLoaded', () => batTatNangCao());
    @endif
</script>
</x-layouts.app>
