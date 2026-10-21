<x-layouts.storefront title="Giỏ hàng của bạn">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-6xl mx-auto" x-data="cartView()">

    <!-- Breadcrumb -->
    <nav class="text-xs sm:text-sm text-slate-500 mb-6 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('thuoc.tra-cuu') }}" class="hover:text-emerald-600 transition">Sản phẩm</a>
        <span>/</span>
        <span class="text-slate-900 font-semibold">Giỏ hàng</span>
    </nav>

    <!-- Header & Item Counter -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>🛒</span> Giỏ hàng của bạn
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Xem lại danh sách sản phẩm thuốc BVTV, kiểm tra tính tương kỵ và tiến hành đặt hàng an toàn.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('thuoc.tra-cuu') }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 px-3.5 py-2 rounded-xl transition shadow-2xs">
                <span>←</span> Tiếp tục mua hàng
            </a>
        </div>
    </div>

    <!-- Cảnh báo Tương kỵ thuốc trong giỏ (Tank-Mix Pre-check) -->
    <template x-if="cart.mixing_alerts && cart.mixing_alerts.length > 0">
        <div class="mt-6 bg-gradient-to-r from-amber-50 to-rose-50 border-2 border-rose-300 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center text-xl shrink-0 shadow-sm">
                    ⚠️
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-rose-950 flex items-center gap-2">
                        <span>CẢNH BÁO TƯƠNG KỴ TANK-MIX TRONG GIỎ HÀNG</span>
                        <span class="text-[11px] uppercase tracking-wider font-extrabold bg-rose-200 text-rose-800 px-2 py-0.5 rounded-full">
                            Khoa học BVTV
                        </span>
                    </h3>
                    <p class="text-xs text-rose-800 mt-1 leading-relaxed">
                        Hệ thống phát hiện trong giỏ hàng có các sản phẩm <strong>không được pha trộn chung bình xịt</strong>. Vui lòng đọc kỹ khuyến cáo kỹ thuật trước khi sử dụng:
                    </p>
                    <div class="mt-3 space-y-2">
                        <template x-for="(alert, idx) in cart.mixing_alerts" :key="idx">
                            <div class="p-3 bg-white/90 rounded-xl border border-rose-200 text-xs">
                                <div class="font-bold text-rose-900 flex items-center justify-between">
                                    <span x-text="'⛔ ' + alert.product_1 + ' ❌ ' + alert.product_2"></span>
                                    <span class="text-[10px] bg-rose-100 text-rose-700 px-2 py-0.5 rounded font-mono font-bold" x-text="alert.status"></span>
                                </div>
                                <div class="mt-1 text-slate-700 font-medium" x-text="alert.reason"></div>
                                <div class="mt-1 text-emerald-800 font-semibold" x-text="'💡 Hướng dẫn an toàn: ' + alert.advice"></div>
                                <template x-if="alert.source_reference">
                                    <div class="mt-1 text-[11px] text-slate-400 italic" x-text="'Dẫn chứng: ' + alert.source_reference"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Empty State Chuyên Nghiệp -->
    <div x-show="!cart.items || cart.items.length === 0"
         @if(!empty($summary['items'])) style="display: none;" @endif
         class="mt-10 text-center py-16 px-6 bg-white border border-slate-200 rounded-3xl shadow-sm">
        <div class="w-24 h-24 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-5xl mb-5 shadow-inner">
            🛒
        </div>
        <h3 class="text-xl font-extrabold text-slate-800">Giỏ hàng của bạn hiện đang trống</h3>
        <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">
            Chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá danh mục thuốc BVTV, phân bón và chế phẩm sinh học chính hãng của chúng tôi.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('thuoc.tra-cuu') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold px-7 py-3.5 rounded-xl transition shadow-md hover:shadow-lg text-sm">
                <span>🌱 Khám phá danh mục thuốc</span>
            </a>
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-6 py-3.5 rounded-xl transition text-sm">
                <span>🏠 Về trang chủ</span>
            </a>
        </div>
    </div>

    <!-- Cart Content (Items Table + Order Summary) -->
    <div x-show="cart.items && cart.items.length > 0" x-cloak
         @if(empty($summary['items'])) style="display: none;" @endif
         class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Danh sách sản phẩm (8 cols) -->
            <div class="lg:col-span-8 space-y-4">

                <!-- Thanh miễn phí vận chuyển -->
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="text-xl">🚚</span>
                        <div class="text-xs">
                            <template x-if="cart.subtotal >= 500000">
                                <span class="font-bold text-emerald-800">
                                    Đơn hàng của bạn đã đạt điều kiện <span class="text-emerald-600 uppercase">Miễn phí giao hàng</span> toàn quốc!
                                </span>
                            </template>
                            <template x-if="cart.subtotal < 500000">
                                <span class="text-slate-700">
                                    Mua thêm <strong class="text-emerald-700" x-text="formatVnd(500000 - cart.subtotal)"></strong> để nhận <strong>Miễn phí vận chuyển</strong> (Đơn từ 500.000₫)
                                </span>
                            </template>
                        </div>
                    </div>
                    <div class="hidden sm:block text-right shrink-0">
                        <span class="text-xs font-bold text-emerald-700" x-text="cart.subtotal >= 500000 ? '100%' : Math.round((cart.subtotal / 500000) * 100) + '%'"></span>
                    </div>
                </div>

                <!-- Card danh sách từng item -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden divide-y divide-slate-100">
                    <template x-for="item in cart.items" :key="item.variant_id">
                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:bg-slate-50/50">
                            <!-- Ảnh + Tên + Quy cách -->
                            <div class="flex items-center gap-4 min-w-0 flex-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-slate-50 border border-slate-200 shrink-0 p-1 flex items-center justify-center overflow-hidden">
                                    <template x-if="item.image_url">
                                        <img :src="item.image_url" :alt="item.name" class="max-w-full max-h-full object-contain">
                                    </template>
                                    <template x-if="!item.image_url">
                                        <span class="text-2xl text-slate-300">💊</span>
                                    </template>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a :href="'/thuoc/' + (item.pesticide ? item.pesticide.id : '')"
                                       class="text-sm sm:text-base font-bold text-slate-900 hover:text-emerald-700 transition line-clamp-1"
                                       x-text="item.name"></a>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md"
                                              x-text="item.specification"></span>
                                        <span class="text-[11px] text-slate-400 font-mono" x-text="'SKU: ' + item.sku"></span>
                                    </div>
                                    <div class="mt-1 text-xs font-extrabold text-emerald-600 sm:hidden" x-text="item.formatted_price"></div>
                                </div>
                            </div>

                            <!-- Đơn giá (desktop) -->
                            <div class="hidden sm:block text-right shrink-0 min-w-[100px]">
                                <div class="text-xs text-slate-400">Đơn giá</div>
                                <div class="text-sm font-bold text-slate-800" x-text="item.formatted_price"></div>
                            </div>

                            <!-- Bộ tăng giảm số lượng -->
                            <div class="flex items-center justify-between sm:justify-center gap-3 shrink-0">
                                <div class="flex items-center border border-slate-300 rounded-xl bg-white shadow-2xs overflow-hidden">
                                    <button type="button"
                                            @click="updateQty(item.variant_id, item.quantity - 1)"
                                            class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                                        -
                                    </button>
                                    <input type="number"
                                           :value="item.quantity"
                                           @change="updateQty(item.variant_id, parseInt($event.target.value) || 1)"
                                           class="w-12 h-8 text-center text-xs font-bold text-slate-800 border-x border-slate-200 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <button type="button"
                                            @click="updateQty(item.variant_id, item.quantity + 1)"
                                            class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                                        +
                                    </button>
                                </div>

                                <!-- Nút xóa -->
                                <button type="button"
                                        @click="removeItem(item.variant_id)"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                        title="Xóa khỏi giỏ">
                                    🗑️
                                </button>
                            </div>

                            <!-- Thành tiền -->
                            <div class="text-right shrink-0 min-w-[110px]">
                                <div class="text-xs text-slate-400 sm:hidden">Thành tiền:</div>
                                <div class="text-sm sm:text-base font-extrabold text-emerald-700" x-text="item.formatted_line_total"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tổng kết & Tiến hành đặt hàng (4 cols) -->
            <div class="lg:col-span-4 sticky top-6">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-5">
                    <h2 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Tóm tắt đơn hàng</span>
                        <span class="text-xs font-semibold text-slate-500" x-text="cart.count + ' sản phẩm'"></span>
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Tạm tính tiền hàng:</span>
                            <span class="font-bold text-slate-900" x-text="cart.formatted_subtotal"></span>
                        </div>

                        <div class="flex items-center justify-between text-slate-600">
                            <span class="flex items-center gap-1">
                                Phí vận chuyển:
                                <span class="text-xs text-slate-400" title="Giao hàng tiêu chuẩn">(chuẩn)</span>
                            </span>
                            <span class="font-bold"
                                  :class="cart.shipping_fee === 0 ? 'text-emerald-600 font-extrabold' : 'text-slate-900'"
                                  x-text="cart.formatted_shipping_fee"></span>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-baseline justify-between">
                            <span class="text-base font-bold text-slate-900">Tổng thanh toán:</span>
                            <span class="text-2xl font-black text-emerald-600 tracking-tight" x-text="cart.formatted_total"></span>
                        </div>
                    </div>

                    <!-- Cam kết dịch vụ -->
                    <div class="p-3 bg-slate-50 rounded-2xl space-y-2 text-xs text-slate-600 border border-slate-200/60">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>100% Thuốc chính hãng có nguồn gốc rõ ràng</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Kèm hướng dẫn liều lượng pha chuẩn nông nghiệp</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span>
                            <span>Được kiểm tra hàng trước khi thanh toán COD</span>
                        </div>
                    </div>

                    <!-- CTA button -->
                    <div>
                        <a href="{{ route('checkout.index') }}"
                           class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold rounded-2xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-base">
                            <span>Tiến hành đặt hàng</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
function cartView() {
    return {
        cart: @json($summary),
        isLoading: false,

        formatVnd(amount) {
            return new Intl.NumberFormat('vi-VN').format(Math.max(0, amount)) + ' ₫';
        },

        async updateQty(variantId, qty) {
            if (this.isLoading) return;
            this.isLoading = true;

            try {
                const res = await fetch("{{ route('ajax.cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ variant_id: variantId, quantity: qty })
                });
                const data = await res.json();
                if (data.success) {
                    this.cart = data.cart;
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart }));
                }
            } catch (err) {
                console.error(err);
            } finally {
                this.isLoading = false;
            }
        },

        async removeItem(variantId) {
            if (this.isLoading) return;
            this.isLoading = true;

            try {
                const res = await fetch("{{ route('ajax.cart.remove') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ variant_id: variantId })
                });
                const data = await res.json();
                if (data.success) {
                    this.cart = data.cart;
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart }));
                }
            } catch (err) {
                console.error(err);
            } finally {
                this.isLoading = false;
            }
        }
    };
}
</script>
</x-layouts.storefront>
