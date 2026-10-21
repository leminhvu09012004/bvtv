<x-layouts.storefront :title="$pesticide->name">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-5xl mx-auto">

    <nav class="text-xs sm:text-sm text-slate-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('thuoc.tra-cuu') }}" class="hover:text-emerald-600 transition">Danh mục thuốc</a>
        @if($pesticide->category)
            <span>/</span>
            <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}" class="hover:text-emerald-600 transition">
                {{ $pesticide->category->name }}
            </a>
        @endif
        <span>/</span>
        <span class="text-slate-900 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $pesticide->name }}</span>
    </nav>

    <div class="flex items-center justify-between gap-3 mb-5">
        <a href="{{ route('thuoc.tra-cuu') }}"
           class="text-xs sm:text-sm text-slate-500 hover:text-emerald-700 flex items-center gap-1 font-semibold transition">
            ← Quay lại danh mục thuốc
        </a>
    </div>

    <!-- Card chi tiết -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <!-- Hero Section: Ảnh & Thông tin chính / Chọn quy cách -->
        <div class="p-6 md:p-7 bg-gradient-to-b from-gray-50/70 to-white border-b border-gray-100">
            <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center md:items-start">

                <!-- Cột trái: Ảnh sản phẩm (Cố định kích thước chuẩn, không bao giờ tràn vỡ layout) -->
                <div class="w-full md:w-[320px] shrink-0 flex flex-col items-center">
                    <div class="relative group cursor-pointer overflow-hidden rounded-2xl border-2 border-emerald-100/90 shadow-sm bg-white p-3 flex items-center justify-center transition-all duration-300 hover:shadow-md hover:border-emerald-300"
                         id="main-image-container"
                         style="width: 100%; max-width: 320px; height: 320px;"
                         onclick="moModalAnh(this.dataset.imgUrl, '{{ addslashes($pesticide->name) }}')"
                         data-img-url="{{ $pesticide->image_url ?? '' }}"
                         title="Nhấp để xem ảnh to">
                        @if($pesticide->image_url)
                            <img id="main-product-img"
                                 src="{{ $pesticide->image_url }}"
                                 alt="{{ $pesticide->name }}"
                                 style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;"
                                 class="rounded-xl group-hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center text-white gap-1.5 text-xs font-semibold backdrop-blur-[1px]">
                                <span>🔍 Phóng to ảnh</span>
                            </div>
                        @else
                            <div id="main-img-placeholder" class="text-5xl">💊</div>
                            <img id="main-product-img"
                                 src=""
                                 alt="{{ $pesticide->name }}"
                                 style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;"
                                 class="hidden rounded-xl group-hover:scale-105 transition-all duration-300">
                        @endif
                    </div>
                    <div class="mt-2.5 text-xs text-gray-400 flex items-center gap-1.5 font-medium">
                        <span>🔍 Nhấp vào ảnh để xem to</span>
                    </div>
                </div>

                <!-- Cột phải: Tên, Phân loại, Kích thước / Quy cách & Liều lượng pha -->
                <div class="flex-1 min-w-0 w-full text-left">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        @if($pesticide->category)
                            <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}"
                               class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full hover:bg-green-100 transition-colors">
                                {{ $pesticide->category->name }}
                            </a>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                        {{ $pesticide->name }}
                    </h1>

                    <!-- Badges liều lượng / dính màu -->
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                        @if($pesticide->concentration)
                            <span class="text-xs sm:text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-lg font-medium border border-gray-200/60">
                                {{ $pesticide->concentration }}
                            </span>
                        @endif
                        @if($pesticide->water_volume)
                            <span class="text-xs sm:text-sm font-bold text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg inline-flex items-center gap-1.5 shadow-2xs">
                                <span>💧 Pha:</span> <span id="val-water-volume">{{ $pesticide->water_volume }}</span>
                            </span>
                        @endif
                        @if($pesticide->stains_fruit)
                            <span class="text-xs sm:text-sm font-bold text-amber-900 bg-amber-100 border border-amber-300 px-3 py-1 rounded-lg inline-flex items-center gap-1.5 shadow-2xs">
                                <span>🎨 Có thể dính màu trái</span>
                            </span>
                        @endif
                        @if($pesticide->frac_code)
                            <span class="text-xs sm:text-sm font-bold text-purple-800 bg-purple-50 border border-purple-200 px-3 py-1 rounded-lg inline-flex items-center gap-1.5 shadow-2xs" title="Mã nhóm cơ chế tác động trừ bệnh (Fungicide Resistance)">
                                <span>🍄 FRAC:</span> <span>{{ $pesticide->frac_code }}</span>
                            </span>
                        @endif
                        @if($pesticide->irac_code)
                            <span class="text-xs sm:text-sm font-bold text-teal-800 bg-teal-50 border border-teal-200 px-3 py-1 rounded-lg inline-flex items-center gap-1.5 shadow-2xs" title="Mã nhóm cơ chế tác động trừ sâu rầy (Insecticide Resistance)">
                                <span>🦗 IRAC:</span> <span>{{ $pesticide->irac_code }}</span>
                            </span>
                        @endif
                    </div>

                    @if($pesticide->productVariants && $pesticide->productVariants->isNotEmpty())
                        @php
                            $variantList = $pesticide->productVariants->map(function($pv) {
                                return [
                                    'id' => $pv->id,
                                    'sku' => $pv->sku,
                                    'specification' => $pv->specification,
                                    'unit' => $pv->unit ?? 'chai/gói',
                                    'price' => $pv->effective_price,
                                    'formatted_price' => $pv->formatted_price,
                                    'stock' => (int)$pv->inventories->sum('quantity_available'),
                                ];
                            });
                            $defaultVariant = $variantList->firstWhere('stock', '>', 0) ?? $variantList->first();
                        @endphp
                        <div class="mt-4 pt-4 border-t border-slate-100"
                             x-data="{
                                 variants: {{ Js::from($variantList) }},
                                 selectedId: {{ $defaultVariant['id'] ?? 'null' }},
                                 quantity: 1,
                                 isSubmitting: false,
                                 get current() {
                                     return this.variants.find(v => v.id === this.selectedId) || this.variants[0];
                                 },
                                 async addToCart(isBuyNow = false) {
                                     if (!this.current || this.current.stock <= 0 || this.isSubmitting) return;
                                     this.isSubmitting = true;
                                     try {
                                         const res = await fetch('{{ route('ajax.cart.add') }}', {
                                             method: 'POST',
                                             headers: {
                                                 'Content-Type': 'application/json',
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                                 'Accept': 'application/json'
                                             },
                                             body: JSON.stringify({
                                                 variant_id: this.current.id,
                                                 quantity: this.quantity
                                             })
                                         });
                                         const data = await res.json();
                                         if (data.success) {
                                             window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart }));
                                             if (isBuyNow) {
                                                 window.location.href = '{{ route('checkout.index') }}';
                                             } else {
                                                 if (typeof showToast === 'function') {
                                                     showToast('✅ Đã thêm ' + this.quantity + ' ' + this.current.specification + ' vào giỏ hàng!');
                                                 } else {
                                                     alert('Đã thêm sản phẩm vào giỏ hàng!');
                                                 }
                                             }
                                         } else {
                                             alert(data.message || 'Có lỗi xảy ra');
                                         }
                                     } catch (e) {
                                         console.error(e);
                                     } finally {
                                         this.isSubmitting = false;
                                     }
                                 }
                             }">
                            <!-- Giá bán nổi bật & trạng thái tồn kho -->
                            <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-100 mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider block mb-0.5">Giá bán niêm yết:</span>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl sm:text-3xl font-black text-emerald-700 tabular-nums tracking-tight"
                                              x-text="current?.formatted_price">
                                            {{ $defaultVariant['formatted_price'] ?? 'Liên hệ' }}
                                        </span>
                                        <span class="text-xs text-slate-500 font-mono"
                                              x-text="'SKU: ' + (current?.sku || '')">
                                            SKU: {{ $defaultVariant['sku'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold shadow-2xs"
                                          :class="(current?.stock || 0) > 0 ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : 'bg-rose-100 text-rose-900 border border-rose-200'"
                                          x-text="(current?.stock || 0) > 0 ? ('✓ Còn ' + current.stock + ' ' + (current?.unit || '')) : '✕ Tạm hết hàng'">
                                        @if(($defaultVariant['stock'] ?? 0) > 0)
                                            ✓ Còn {{ $defaultVariant['stock'] }} {{ $defaultVariant['unit'] }}
                                        @else
                                            ✕ Tạm hết hàng
                                        @endif
                                    </span>
                                    <div class="text-[11px] text-slate-400 mt-1">Sẵn sàng giao ngay</div>
                                </div>
                            </div>

                            <!-- Tiêu đề bộ chọn quy cách -->
                            <div class="mb-2">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Chọn quy cách đóng gói (<span x-text="variants.length">{{ count($variantList) }}</span> loại):
                                </h4>
                            </div>

                            <!-- Danh sách biến thể quy cách -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                @foreach($variantList as $v)
                                    <div @click="selectedId = {{ $v['id'] }}"
                                         class="p-3.5 rounded-xl border cursor-pointer transition select-none shadow-2xs"
                                         :class="selectedId === {{ $v['id'] }}
                                             ? 'border-emerald-600 bg-emerald-50/60 ring-2 ring-emerald-500/50'
                                             : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50/50'">
                                        <div class="flex items-start justify-between gap-1">
                                            <div>
                                                <div class="text-xs font-bold text-slate-800">{{ $v['specification'] }}</div>
                                                <div class="text-[10px] text-slate-400 font-mono">SKU: {{ $v['sku'] }}</div>
                                            </div>
                                            <span class="text-xs font-extrabold text-emerald-600 tabular-nums">{{ $v['formatted_price'] }}</span>
                                        </div>
                                        <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                            <span class="text-slate-500">Tồn kho 2 chi nhánh:</span>
                                            <span class="font-bold tabular-nums {{ $v['stock'] > 0 ? 'text-emerald-700' : 'text-rose-600' }}">
                                                {{ $v['stock'] > 0 ? ($v['stock'] . ' ' . $v['unit']) : 'Tạm hết hàng' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Bộ chọn số lượng & Nút đặt hàng -->
                            <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-600">Số lượng:</span>
                                    <div class="flex items-center border border-slate-300 rounded-xl bg-white shadow-2xs overflow-hidden">
                                        <button type="button"
                                                @click="quantity = Math.max(1, quantity - 1)"
                                                class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold transition">
                                            -
                                        </button>
                                        <input type="number"
                                               x-model.number="quantity"
                                               min="1"
                                               class="w-14 h-9 text-center text-xs font-bold text-slate-800 border-x border-slate-200 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button"
                                                @click="quantity = quantity + 1"
                                                class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 font-bold transition">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <div class="flex-1 flex items-center gap-2.5">
                                    <button type="button"
                                            @click="addToCart(false)"
                                            :disabled="!current || current.stock <= 0 || isSubmitting"
                                            class="flex-1 py-3 px-4 rounded-xl border-2 border-emerald-600 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs sm:text-sm transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:pointer-events-none shadow-2xs">
                                        <span>🛒</span>
                                        <span x-text="isSubmitting ? 'Đang thêm...' : 'Thêm vào giỏ hàng'">Thêm vào giỏ hàng</span>
                                    </button>

                                    <button type="button"
                                            @click="addToCart(true)"
                                            :disabled="!current || current.stock <= 0 || isSubmitting"
                                            class="flex-1 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:pointer-events-none shadow-md">
                                        <span>⚡</span>
                                        <span>Mua ngay</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($pesticide->stains_fruit)
                        <div class="mt-4 bg-amber-50 border border-amber-300/80 rounded-xl p-3.5 flex items-start gap-2.5 text-amber-900 shadow-2xs">
                            <span class="text-lg shrink-0">🎨</span>
                            <div class="text-xs">
                                <strong class="font-bold text-amber-950">Cảnh báo dính màu trên vỏ trái:</strong>
                                <p class="mt-0.5 text-amber-800 leading-relaxed">
                                    Thuốc có thể để lại vệt màu hoặc màng bám trên vỏ trái. Khuyến cáo cẩn trọng khi phun trực tiếp lên trái giai đoạn nuôi trái lớn hoặc sắp thu hoạch.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="px-6 py-5 divide-y divide-gray-100">
            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Danh mục</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if($pesticide->category)
                        <a href="{{ route('danhmuc.xem', $pesticide->category->slug) }}" class="text-green-700 hover:text-green-800 font-medium hover:underline">
                            {{ $pesticide->category->name }}
                        </a>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Hoạt chất</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 font-semibold">
                    {{ $pesticide->active_ingredient ?: '—' }}
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Hàm lượng / Quy cách</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    {{ $pesticide->concentration ?: '—' }}
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2 bg-blue-50/60 -mx-6 px-6">
                <dt class="text-sm font-semibold text-blue-900 flex items-center gap-1.5">
                    <span>💧</span> Lượng nước pha khuyến cáo
                </dt>
                <dd class="text-sm text-blue-900 font-bold sm:col-span-2">
                    {{ $pesticide->water_volume ?: '—' }}
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Dạng thuốc</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if($pesticide->form_type)
                        <span class="inline-block px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded text-xs font-medium">
                            {{ $pesticide->form_type }}
                        </span>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Công dụng</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 whitespace-pre-line leading-relaxed">
                    {{ $pesticide->usage ?: '—' }}
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Đối tượng phòng/trừ</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 leading-relaxed">
                    {{ $pesticide->target ?: '—' }}
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Bệnh điều trị</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if($pesticide->diseases && $pesticide->diseases->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($pesticide->diseases as $benh)
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    @if($benh->image_url)
                                        <img src="{{ $benh->image_url }}" alt="{{ $benh->name }}"
                                             class="w-4 h-4 rounded object-cover cursor-pointer hover:opacity-80"
                                             onclick="moModalAnh('{{ $benh->image_url }}', '{{ addslashes($benh->name) }}')"
                                             title="Nhấp xem ảnh bệnh">
                                    @endif
                                    <span>{{ $benh->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Thời gian cách ly</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if($pesticide->isolation_period)
                        <span class="inline-flex items-center px-2 py-0.5 bg-amber-50 text-amber-800 border border-amber-200 rounded text-xs font-medium">
                            {{ $pesticide->isolation_period }} {{ is_numeric($pesticide->isolation_period) ? 'ngày' : '' }}
                        </span>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>

            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Nhà sản xuất</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    {{ $pesticide->manufacturer ?: '—' }}
                </dd>
            </div>


            <div class="py-3.5 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <dt class="text-sm font-medium text-gray-500">Ghi chú thực tế</dt>
                <dd class="text-sm sm:col-span-2">
                    @if($pesticide->notes)
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3.5 text-amber-900 whitespace-pre-line text-sm leading-relaxed">
                            {{ str_replace(['\r\n', '\r', '\n'], "\n", $pesticide->notes) }}
                        </div>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </dd>
            </div>
        </div>

        <div class="border-t border-gray-100 px-6 py-3 flex items-center gap-4 text-xs text-gray-400 bg-gray-50/50">
            <span>Tạo: {{ $pesticide->created_at->format('d/m/Y H:i') }}</span>
            @if($pesticide->updated_at != $pesticide->created_at)
                <span>Sửa: {{ $pesticide->updated_at->format('d/m/Y H:i') }}</span>
            @endif
        </div>
    </div>

    <!-- KHỐI LƯU Ý PHỐI TRỘN & TƯƠNG KỴ THUỐC -->
    @if(isset($mixingInfo))
        <div class="mt-6 bg-white rounded-3xl border border-gray-200 shadow-sm p-6 lg:p-7">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="p-1 rounded-lg bg-red-100 text-red-700 text-sm">⚖️</span>
                        Lưu Ý Phối Trộn & Tương Kỵ Của Sản Phẩm
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Quy tắc an toàn sinh hóa khi hòa trộn sản phẩm này với các loại thuốc BVTV và phân bón khác
                    </p>
                </div>

                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'engineer']))
                <a href="{{ route('phoi-tron.index', ['p1' => $pesticide->id]) }}"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 px-3.5 py-2 rounded-xl transition-all shadow-2xs self-start sm:self-auto">
                    <span>⚡</span>
                    <span>Thử phối thuốc này (Kỹ sư)</span>
                    <span>→</span>
                </a>
                @endif
            </div>

            <div class="mt-5 space-y-4">
                <!-- CẢNH BÁO CẤM KỴ -->
                @if(!empty($mixingInfo['dangers']))
                    <div class="bg-red-50/80 border border-red-200/90 rounded-2xl p-4">
                        <h4 class="text-xs font-bold text-red-900 uppercase tracking-wider flex items-center gap-1.5 mb-2.5">
                            <span class="text-sm">🚫</span> Tuyệt đối không phối với các nhóm sau:
                        </h4>
                        <div class="space-y-2">
                            @foreach($mixingInfo['dangers'] as $dan)
                                <div class="bg-white p-3 rounded-xl border border-red-200 shadow-2xs text-xs space-y-1">
                                    <div class="font-bold text-red-700 flex items-center gap-1.5">
                                        <span>•</span>
                                        <span>{{ $dan['title'] }}</span>
                                        @if($dan['examples'])
                                            <span class="text-[11px] font-normal text-gray-500">({{ $dan['examples'] }})</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $dan['consequence'] }}</p>
                                    <p class="text-gray-600 italic">💡 {{ $dan['advice'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- CẢNH BÁO THẬN TRỌNG -->
                @if(!empty($mixingInfo['warnings']))
                    <div class="bg-amber-50/80 border border-amber-200/90 rounded-2xl p-4">
                        <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1.5 mb-2.5">
                            <span class="text-sm">⚠️</span> Cần thận trọng & lưu ý khi phối:
                        </h4>
                        <div class="space-y-2">
                            @foreach($mixingInfo['warnings'] as $war)
                                <div class="bg-white p-3 rounded-xl border border-amber-200 shadow-2xs text-xs space-y-1">
                                    <div class="font-bold text-amber-800 flex items-center gap-1.5">
                                        <span>•</span>
                                        <span>{{ $war['title'] }}</span>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $war['reason'] }}</p>
                                    <p class="text-gray-600 italic">💡 {{ $war['advice'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- GỢI Ý CỘNG LỰC AN TOÀN -->
                @if(!empty($mixingInfo['synergies']))
                    <div class="bg-emerald-50/60 border border-emerald-200/80 rounded-2xl p-4">
                        <h4 class="text-xs font-bold text-emerald-900 uppercase tracking-wider flex items-center gap-1.5 mb-2.5">
                            <span class="text-sm">💡</span> Gợi ý phối cộng lực an toàn & hiệu quả cao:
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                            @foreach($mixingInfo['synergies'] as $syn)
                                <div class="bg-white p-3 rounded-xl border border-emerald-200 shadow-2xs text-xs">
                                    <strong class="text-emerald-800 block font-semibold mb-0.5">{{ $syn['title'] }}</strong>
                                    <p class="text-gray-600 leading-relaxed">{{ $syn['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnQuayLai = document.getElementById('btn-quay-lai');
    if (!btnQuayLai) return;

    btnQuayLai.addEventListener('click', (e) => {
        e.preventDefault();
        sessionStorage.setItem('bvtv_is_returning', '1');

        let returnUrl = sessionStorage.getItem('bvtv_tra_cuu_url');
        if (!returnUrl || (!returnUrl.startsWith('/') && !returnUrl.startsWith(window.location.origin))) {
            returnUrl = "{{ route('thuoc.tra-cuu') }}";
        }

        window.location.replace(returnUrl);
    });
});

</script>
</x-layouts.storefront>
