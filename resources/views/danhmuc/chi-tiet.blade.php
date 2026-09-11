<x-layouts.app :title="$category->name">
<div class="px-4 py-6 lg:px-8 lg:py-8">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('danhmuc.danh-sach') }}" class="hover:text-green-600">Quản lý danh mục</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">{{ $category->emoji }} {{ $category->name }}</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>{{ $category->emoji }}</span>
                <span>{{ $category->name }}</span>
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                <span id="so-luong-ket-qua">{{ $pesticides->count() }} sản phẩm</span> trong danh mục này
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('danhmuc.danh-sach') }}"
               class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3.5 py-2 rounded-lg text-sm font-medium transition-colors">
                ← Quay lại danh mục
            </a>
            <a href="{{ route('thuoc.them', ['category_id' => $category->id]) }}"
               class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                ➕ Thêm thuốc
            </a>
        </div>
    </div>

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

    <div id="empty-state" class="{{ $pesticides->isEmpty() ? '' : 'hidden' }} bg-white border border-dashed border-gray-300 rounded-xl py-16 text-center">
        <div class="text-4xl mb-3">📭</div>
        <p class="text-gray-500 mb-4">Chưa có sản phẩm nào trong danh mục này.</p>
        <a href="{{ route('thuoc.them', ['category_id' => $category->id]) }}"
           class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            ➕ Thêm thuốc đầu tiên
        </a>
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
                            <td class="px-3 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
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
                                            {{ $category->emoji ?? '💊' }}
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
                            <td class="px-4 py-3 text-gray-600 hidden md:table-cell">
                                {{ $pesticide->active_ingredient ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell max-w-xs">
                                <span class="line-clamp-2">{{ $pesticide->usage ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell">
                                <span class="line-clamp-1">{{ $pesticide->crops ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('thuoc.xem', $pesticide) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">
                                        Xem
                                    </a>
                                    <a href="{{ route('thuoc.sua', $pesticide) }}"
                                       class="text-xs px-2.5 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">
                                        Sửa
                                    </a>
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
</x-layouts.app>
