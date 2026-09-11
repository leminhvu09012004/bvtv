<x-layouts.app :title="$pesticide->name">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-2xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        @if($pesticide->category)
            <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}" class="hover:text-green-600">
                {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
            </a>
            <span>/</span>
        @endif
        <span class="text-gray-800 font-medium truncate max-w-[200px]">{{ $pesticide->name }}</span>
    </nav>

    <div class="flex items-center justify-between gap-3 mb-5">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('thuoc.danh-sach') }}"
           class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            ← Quay lại
        </a>
        <div class="flex gap-2">
            <a href="{{ route('thuoc.sua', $pesticide) }}"
               class="inline-flex items-center gap-1.5 border border-blue-300 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                ✏️ Chỉnh sửa
            </a>
            <button
                onclick="moModalXoa('{{ route('thuoc.xoa', $pesticide) }}', '{{ addslashes($pesticide->name) }}')"
                class="inline-flex items-center gap-1.5 border border-red-300 text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                🗑️ Xóa
            </button>
        </div>
    </div>

    <!-- Card chi tiết -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        @if($pesticide->image_url)
            <div class="p-5 sm:p-6 bg-gradient-to-b from-gray-50/80 to-white border-b border-gray-100 flex flex-col sm:flex-row items-center gap-5">
                <div class="relative group cursor-pointer overflow-hidden rounded-2xl border-2 border-green-100/80 shadow-sm bg-white p-1.5 shrink-0 max-w-[200px]"
                     onclick="moModalAnh('{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                     title="Nhấp để xem ảnh to">
                    <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-44 h-44 object-cover rounded-xl group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center text-white gap-1 text-xs font-medium">
                        <span>🔍 Phóng to</span>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full mb-2">
                        <span>📷</span> Bao bì / Nhãn thuốc thực tế
                    </span>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Hình ảnh nhãn mác, quy cách đóng gói và màu nhận diện của <strong>{{ $pesticide->name }}</strong>. Nhấp vào ảnh để xem chi tiết nhãn thuốc.
                    </p>
                </div>
            </div>
        @endif

        <div class="border-b border-gray-100 px-6 py-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $pesticide->name }}</h1>
                    @if($pesticide->concentration)
                        <span class="inline-block mt-1 text-sm text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $pesticide->concentration }}</span>
                    @endif
                </div>
                @if($pesticide->category)
                    <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}"
                       class="shrink-0 inline-flex items-center gap-1.5 text-sm bg-green-50 text-green-700 border border-green-200 px-3 py-1.5 rounded-full hover:bg-green-100 transition-colors">
                        {{ $pesticide->category->emoji }} {{ $pesticide->category->name }}
                    </a>
                @endif
            </div>
        </div>

        <div class="px-6 py-5 divide-y divide-gray-50">
            @if($pesticide->active_ingredient)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Hoạt chất</dt>
                    <dd class="text-sm text-gray-900 col-span-2 font-semibold">{{ $pesticide->active_ingredient }}</dd>
                </div>
            @endif

            @if($pesticide->usage)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Công dụng</dt>
                    <dd class="text-sm text-gray-900 col-span-2 whitespace-pre-line">{{ $pesticide->usage }}</dd>
                </div>
            @endif

            @if($pesticide->target)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Đối tượng phòng/trừ</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->target }}</dd>
                </div>
            @endif

            @if($pesticide->crops)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Cây trồng</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->crops }}</dd>
                </div>
            @endif

            @if($pesticide->form_type)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Dạng thuốc</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->form_type }}</dd>
                </div>
            @endif

            @if($pesticide->isolation_period)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Thời gian cách ly</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->isolation_period }}</dd>
                </div>
            @endif

            @if($pesticide->manufacturer)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Nhà sản xuất</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->manufacturer }}</dd>
                </div>
            @endif

            @if($pesticide->registration_number)
                <div class="py-3 grid grid-cols-3 gap-2">
                    <dt class="text-sm font-medium text-gray-500 col-span-1">Số đăng ký</dt>
                    <dd class="text-sm text-gray-900 col-span-2">{{ $pesticide->registration_number }}</dd>
                </div>
            @endif
        </div>

        @if($pesticide->notes)
            <div class="mx-6 mb-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-amber-800 mb-2">📝 Ghi chú / Kinh nghiệm thực tế</h3>
                <p class="text-sm text-amber-900 whitespace-pre-line">{{ $pesticide->notes }}</p>
            </div>
        @else
            <div class="mx-6 mb-6">
                <a href="{{ route('thuoc.sua', $pesticide) }}"
                   class="flex items-center gap-2 text-sm text-gray-400 border border-dashed border-gray-300 rounded-lg px-4 py-3 hover:border-green-400 hover:text-green-600 transition-colors">
                    <span>+</span>
                    <span>Thêm ghi chú / kinh nghiệm thực tế</span>
                </a>
            </div>
        @endif

        <div class="border-t border-gray-100 px-6 py-3 flex items-center gap-4 text-xs text-gray-400">
            <span>Tạo: {{ $pesticide->created_at->format('d/m/Y H:i') }}</span>
            @if($pesticide->updated_at != $pesticide->created_at)
                <span>Sửa: {{ $pesticide->updated_at->format('d/m/Y H:i') }}</span>
            @endif
        </div>
    </div>
</div>
</x-layouts.app>
