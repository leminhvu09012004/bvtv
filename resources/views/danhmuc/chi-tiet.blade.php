<x-layouts.storefront :title="$category->name">
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-7xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        @if($isAdmin)
            <a href="{{ route('danhmuc.danh-sach') }}" class="hover:text-green-600">Quản lý danh mục</a>
        @else
            <a href="{{ route('thuoc.tra-cuu') }}" class="hover:text-green-600">Tra cứu thuốc</a>
        @endif
        <span>/</span>
        <span class="text-gray-800 font-medium">{{ $category->emoji }} {{ $category->name }}</span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            @if($isAdmin)
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 mb-1">
                    <span>⚙️ KHU VỰC QUẢN TRỊ (CRUD)</span>
                </div>
            @endif
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span>{{ $category->emoji }}</span>
                <span>{{ $category->name }}</span>
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                <span id="so-luong-ket-qua" class="font-semibold text-emerald-700">{{ $pesticides->count() }}</span> sản phẩm trong danh mục này
            </p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            @if($isAdmin)
                <a href="{{ route('danhmuc.danh-sach') }}"
                   class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3.5 py-2 rounded-lg text-sm font-medium transition-colors">
                    ← Quay lại danh mục
                </a>
                <a href="{{ route('thuoc.them', ['category_id' => $category->id]) }}"
                   class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap shadow-sm">
                    ➕ Thêm thuốc
                </a>
            @else
                <a href="{{ route('thuoc.tra-cuu') }}"
                   onclick="if(document.referrer && document.referrer !== window.location.href){ event.preventDefault(); history.back(); }"
                   class="inline-flex items-center gap-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3.5 py-2 rounded-lg text-sm font-medium transition-colors">
                    ← Quay lại trang trước
                </a>
            @endif
        </div>
    </div>

    <!-- CẢNH BÁO TƯƠNG KỴ PHỐI TRỘN CỦA DANH MỤC NÀY -->
    @if(isset($mixingCategoryInfo) && (!empty($mixingCategoryInfo['incompatible_categories']) || !empty($mixingCategoryInfo['internal_conflicts'])))
        <div class="mb-6 bg-white rounded-2xl border border-red-200/90 shadow-2xs overflow-hidden">
            <div class="bg-red-50/80 px-5 py-3.5 border-b border-red-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="text-base">🚫</span>
                    <h3 class="text-sm font-bold text-red-950">
                        Cảnh Báo Phối Trộn: Danh mục này không được trộn với những danh mục nào?
                    </h3>
                </div>
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'engineer']))
                <a href="{{ route('phoi-tron.index', ['cat1' => $category->id]) }}"
                    class="text-xs font-bold text-red-700 hover:text-red-800 hover:underline inline-flex items-center gap-1">
                    <span>Xem công cụ phân tích danh mục (Kỹ sư)</span>
                    <span>→</span>
                </a>
                @endif
            </div>

            <div class="p-5 space-y-3.5">
                @if(!empty($mixingCategoryInfo['internal_conflicts']))
                    <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-3 text-xs text-amber-900 flex items-start gap-2">
                        <span class="text-sm">⚠️</span>
                        <div>
                            <strong>Lưu ý nội bộ danh mục:</strong> {{ $mixingCategoryInfo['internal_conflicts']['summary'] }}
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($mixingCategoryInfo['incompatible_categories'] as $inc)
                        @php $otherCat = $inc['category']; @endphp
                        <div class="bg-gray-50/80 rounded-xl border border-gray-200 p-3.5 flex flex-col justify-between gap-2.5">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="font-bold text-xs text-gray-900 flex items-center gap-1">
                                        <span>{{ $otherCat->emoji }}</span>
                                        <span>{{ $otherCat->name }}</span>
                                    </span>
                                    @if($inc['status'] === 'danger')
                                        <span class="text-[10px] font-bold bg-red-100 text-red-800 px-2 py-0.5 rounded-full border border-red-200">
                                            🔴 CẤM KỴ ({{ $inc['total_conflicts'] }} cặp)
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full border border-amber-200">
                                            🟡 THẬN TRỌNG
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $inc['summary'] }}</p>

                                @if(!empty($inc['sample_conflicts']))
                                    <div class="mt-2 text-[11px] text-gray-500 bg-white p-2 rounded-lg border border-gray-200/70 space-y-1">
                                        <strong class="text-gray-700 block">Ví dụ cặp sản phẩm kỵ nhau:</strong>
                                        @foreach($inc['sample_conflicts'] as $sc)
                                            <div class="truncate">
                                                ❌ <strong class="text-gray-800">{{ $sc['product_1']->name }}</strong> ⟷ <span class="text-red-700">{{ $sc['product_2']->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'engineer']))
                            <a href="{{ route('phoi-tron.index', ['cat1' => $category->id, 'cat2' => $otherCat->id]) }}"
                                class="inline-flex items-center justify-center gap-1 text-[11px] font-bold text-red-700 hover:text-red-800 bg-white hover:bg-red-50 border border-red-200 px-3 py-1.5 rounded-lg transition shadow-2xs">
                                <span>⚡ Xem chi tiết kỵ phối trộn với {{ $otherCat->name }}</span>
                                <span>→</span>
                            </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($isAdmin)
        <!-- Thanh thao tác chọn nhiều (chỉ hiển thị ở chế độ Admin) -->
        <div id="bulk-action-bar" class="hidden mb-4 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between gap-3 shadow-sm transition-all duration-200">
            <div class="flex items-center gap-2 text-sm text-amber-900 font-medium">
                <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-1.5 rounded-full bg-amber-600 text-white text-xs font-bold" id="so-luong-da-chon">0</span>
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
    @endif

    <div id="empty-state" class="{{ $pesticides->isEmpty() ? '' : 'hidden' }} bg-white border border-dashed border-gray-300 rounded-xl py-16 text-center">
        <div class="text-4xl mb-3">📭</div>
        <p class="text-gray-500 mb-4">Chưa có sản phẩm nào trong danh mục này.</p>
        @if($isAdmin)
            <a href="{{ route('thuoc.them', ['category_id' => $category->id]) }}"
               class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                ➕ Thêm thuốc đầu tiên
            </a>
        @endif
    </div>

    <div id="bang-thuoc" class="{{ $pesticides->isEmpty() ? 'hidden' : '' }} bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        @if($isAdmin)
                            <th class="px-3 py-3 text-center w-10">
                                <input type="checkbox" id="chon-tat-ca" title="Chọn tất cả" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                            </th>
                        @endif
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[340px] md:min-w-[380px]">Tên thuốc</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Hoạt chất</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Liều pha nước</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Công dụng</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bang-thuoc-body" class="divide-y divide-gray-100">
                    @foreach($pesticides as $pesticide)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $pesticide->id }}">
                            @if($isAdmin)
                                <td class="px-3 py-3 text-center w-10">
                                    <input type="checkbox" class="chon-thuoc w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer" value="{{ $pesticide->id }}">
                                </td>
                            @endif
                            <td class="px-4 py-3 min-w-[340px] md:min-w-[380px]">
                                <div class="flex items-center gap-3">
                                    @if($pesticide->image_url)
                                        <div class="relative w-16 h-16 rounded-xl overflow-hidden border border-gray-200 shrink-0 cursor-pointer shadow-xs hover:ring-2 hover:ring-green-500 transition-all group"
                                             onclick="moModalAnh('{{ $pesticide->image_url }}', '{{ addslashes($pesticide->name) }}')"
                                             title="Nhấp để xem ảnh lớn">
                                            <img src="{{ $pesticide->image_url }}" alt="{{ $pesticide->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-xl opacity-40">💊</div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('thuoc.xem', $pesticide) }}" class="font-bold text-gray-900 hover:text-emerald-700 transition">
                                            {{ $pesticide->name }}
                                        </a>
                                        @if($pesticide->concentration)
                                            <span class="ml-1 text-xs text-gray-400 font-mono">{{ $pesticide->concentration }}</span>
                                        @endif
                                        @if($pesticide->form_type)
                                            <span class="ml-1 text-[10px] font-bold px-1.5 py-0.2 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                                {{ $pesticide->form_type }}
                                            </span>
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
                            <td class="px-4 py-3 hidden sm:table-cell">
                                @if($pesticide->water_volume)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">
                                        <span>💧</span> {{ $pesticide->water_volume }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell max-w-xs">
                                <span class="line-clamp-2 text-xs">{{ $pesticide->usage ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if($isAdmin)
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('thuoc.xem', [$pesticide, 'admin' => 1]) }}"
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
                                @else
                                    <a href="{{ route('thuoc.xem', $pesticide) }}"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg border border-emerald-200 transition">
                                        Chi tiết →
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.storefront>
