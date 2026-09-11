<x-layouts.app :title="'Sửa: '.$pesticide->name">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-2xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('thuoc.xem', $pesticide) }}" class="hover:text-green-600">{{ $pesticide->name }}</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Chỉnh sửa</span>
    </nav>

    <h1 class="text-xl font-bold text-gray-900 mb-6">✏️ Chỉnh sửa thông tin thuốc</h1>

    <form action="{{ route('thuoc.cap-nhat', $pesticide) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

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

            <div>
                <label for="crops" class="block text-sm font-medium text-gray-700 mb-1">Cây trồng sử dụng</label>
                <input type="text" id="crops" name="crops" value="{{ old('crops', $pesticide->crops) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="flex flex-wrap gap-1.5 mt-2">
                    <span class="text-xs text-gray-400 self-center">Chọn nhanh:</span>
                    <button type="button" onclick="themTagCayTrong('crops', 'Sầu riêng')" class="text-xs px-2.5 py-1 rounded-md bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 transition-colors font-medium">+ Sầu riêng</button>
                    <button type="button" onclick="themTagCayTrong('crops', 'Cà phê')" class="text-xs px-2.5 py-1 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 transition-colors font-medium">+ Cà phê</button>
                    <button type="button" onclick="themTagCayTrong('crops', 'Hồ tiêu')" class="text-xs px-2.5 py-1 rounded-md bg-green-50 hover:bg-green-100 text-green-800 border border-green-200 transition-colors font-medium">+ Hồ tiêu</button>
                    <button type="button" onclick="themTagCayTrong('crops', 'Chanh dây')" class="text-xs px-2.5 py-1 rounded-md bg-purple-50 hover:bg-purple-100 text-purple-800 border border-purple-200 transition-colors font-medium">+ Chanh dây</button>
                    <button type="button" onclick="themTagCayTrong('crops', 'Bơ')" class="text-xs px-2.5 py-1 rounded-md bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 transition-colors font-medium">+ Bơ</button>
                    <button type="button" onclick="themTagCayTrong('crops', 'Mắc ca')" class="text-xs px-2.5 py-1 rounded-md bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 transition-colors font-medium">+ Mắc ca</button>
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
                        <label for="concentration" class="block text-sm font-medium text-gray-700 mb-1">Hàm lượng</label>
                        <input type="text" id="concentration" name="concentration" value="{{ old('concentration', $pesticide->concentration) }}"
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
                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-1">Số đăng ký</label>
                        <input type="text" id="registration_number" name="registration_number" value="{{ old('registration_number', $pesticide->registration_number) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-colors">
                💾 Lưu thay đổi
            </button>
            <a href="{{ route('thuoc.xem', $pesticide) }}"
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
</script>
</x-layouts.app>
