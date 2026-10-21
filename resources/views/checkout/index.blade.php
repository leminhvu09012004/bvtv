<x-layouts.storefront title="Thanh toán & Đặt hàng">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-6xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('cart.index') }}" class="hover:text-emerald-600 transition">Giỏ hàng</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Đặt hàng & Thanh toán</span>
    </nav>

    <!-- Page Title -->
    <div class="pb-6 border-b border-slate-200">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
            <span>📦</span> Thông tin nhận hàng & Thanh toán
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Vui lòng điền địa chỉ giao hàng chính xác để chúng tôi gửi thuốc BVTV tận vườn cho bà con.
        </p>
    </div>

    @if ($errors->any())
        <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-bold mb-1">Vui lòng kiểm tra lại thông tin:</div>
            <ul class="list-disc list-inside space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf

        <!-- CỘT TRÁI: FORM ĐỊA CHỈ & HÌNH THỨC THANH TOÁN (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Địa chỉ giao hàng -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>📍</span> 1. Địa chỉ nhận hàng
                    </h2>
                    <span class="text-xs text-rose-600 font-medium">* Bắt buộc</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Họ tên người nhận -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Họ và tên người nhận <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="shipping_recipient_name"
                               required
                               placeholder="VD: Nguyễn Văn Nông"
                               value="{{ old('shipping_recipient_name') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Số điện thoại -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Số điện thoại liên hệ <span class="text-rose-500">*</span></label>
                        <input type="tel"
                               name="shipping_phone"
                               required
                               placeholder="VD: 0988 123 456"
                               value="{{ old('shipping_phone') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Tỉnh / Thành phố -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Tỉnh / Thành phố <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="shipping_province"
                               required
                               placeholder="VD: Đắk Lắk"
                               value="{{ old('shipping_province', 'Đắk Lắk') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Quận / Huyện -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Quận / Huyện <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="shipping_district"
                               required
                               placeholder="VD: Krông Pắk"
                               value="{{ old('shipping_district') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Phường / Xã -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Phường / Xã / Thôn</label>
                        <input type="text"
                               name="shipping_ward"
                               placeholder="VD: Xã Ea Kly"
                               value="{{ old('shipping_ward') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Chi nhánh kho xuất phát -->
                    <div class="space-y-1.5 sm:col-span-1">
                        <label class="block text-xs font-bold text-slate-700">Chi nhánh xuất kho gần nhất</label>
                        <select name="warehouse_id"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition bg-white">
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ old('warehouse_id') == $wh->id ? 'selected' : '' }}>
                                    {{ $wh->name }} ({{ $wh->address }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Địa chỉ chi tiết -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700">Địa chỉ cụ thể (Số nhà, tên đường, thôn, buôn) <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="shipping_address_line"
                               required
                               placeholder="VD: Thôn 12, gần ngã 3 chợ nông sản"
                               value="{{ old('shipping_address_line') }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                    </div>

                    <!-- Ghi chú đơn hàng -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700">Ghi chú cho nhà thuốc / shipper (tùy chọn)</label>
                        <textarea name="notes"
                                  rows="2"
                                  placeholder="VD: Giao hàng vào buổi sáng, gọi trước 15 phút..."
                                  class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Card 2: Phương thức thanh toán -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>💳</span> 2. Phương thức thanh toán
                    </h2>
                </div>

                <div class="space-y-2.5">
                    <!-- COD -->
                    <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40 border-slate-200 hover:border-slate-300">
                        <input type="radio" name="payment_method" value="cash" class="sr-only" checked>
                        <div class="flex items-center gap-3.5 w-full">
                            <span class="text-2xl shrink-0">💵</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-slate-900">Thanh toán khi nhận hàng (COD)</div>
                                <div class="text-xs text-slate-500">Được kiểm tra thuốc, hạn sử dụng và niêm phong trước khi thanh toán cho nhân viên giao hàng.</div>
                            </div>
                            <span class="text-emerald-600 font-bold text-xs uppercase px-2 py-0.5 rounded-full bg-emerald-100 shrink-0">Phổ biến</span>
                        </div>
                    </label>

                    <!-- Chuyển khoản QR -->
                    <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40 border-slate-200 hover:border-slate-300">
                        <input type="radio" name="payment_method" value="bank_transfer" class="sr-only">
                        <div class="flex items-center gap-3.5 w-full">
                            <span class="text-2xl shrink-0">📲</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-slate-900">Chuyển khoản Ngân hàng (VietQR 24/7)</div>
                                <div class="text-xs text-slate-500">Quét mã QR tự động điền số tiền và nội dung chuyển khoản, xử lý tức thì.</div>
                            </div>
                        </div>
                    </label>

                    <!-- VNPAY -->
                    <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40 border-slate-200 hover:border-slate-300">
                        <input type="radio" name="payment_method" value="vnpay" class="sr-only">
                        <div class="flex items-center gap-3.5 w-full">
                            <span class="text-2xl shrink-0">🏛️</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-slate-900">Cổng VNPAY / Thẻ ATM Nội địa / Visa</div>
                                <div class="text-xs text-slate-500">Thanh toán an toàn qua cổng kết nối ngân hàng VNPAY.</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- CỘT PHẢI: TỔNG KẾT ĐƠN HÀNG & CTA (5 cols) -->
        <div class="lg:col-span-5 sticky top-6 space-y-6">

            <!-- Card Tóm tắt sản phẩm trong đơn -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900">Đơn hàng của bạn</h2>
                    <a href="{{ route('cart.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline">Sửa giỏ hàng</a>
                </div>

                <!-- Danh sách sản phẩm rút gọn -->
                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto pr-1">
                    @foreach($summary['items'] as $item)
                        <div class="py-3 flex items-center justify-between gap-3 text-xs">
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-slate-800 truncate">{{ $item['name'] }}</div>
                                <div class="text-slate-500 flex items-center gap-2 mt-0.5">
                                    <span>{{ $item['specification'] }}</span>
                                    <span>&times;</span>
                                    <span class="font-bold text-slate-700">{{ $item['quantity'] }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0 font-extrabold text-slate-900">
                                {{ $item['formatted_line_total'] }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cảnh báo tương kỵ nếu có -->
                @if(!empty($summary['mixing_alerts']))
                    <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900">
                        <div class="font-bold flex items-center gap-1.5 text-rose-950">
                            <span>⚠️ Lưu ý kỹ thuật phối trộn:</span>
                        </div>
                        <p class="mt-1 leading-relaxed">
                            Đơn hàng có cặp thuốc tương kỵ tank-mix. Hệ thống đã tự động ghi chú vào phiếu gửi hàng để chuyên viên kỹ thuật dặn dò khi giao.
                        </p>
                    </div>
                @endif

                <!-- Tiền hàng, Phí ship, Tổng cộng -->
                <div class="pt-3 border-t border-slate-100 space-y-2.5 text-sm">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Tiền hàng:</span>
                        <span class="font-bold text-slate-900">{{ $summary['formatted_subtotal'] }}</span>
                    </div>

                    <div class="flex items-center justify-between text-slate-600">
                        <span>Phí vận chuyển:</span>
                        <span class="font-bold {{ $summary['shipping_fee'] === 0 ? 'text-emerald-600 font-extrabold' : 'text-slate-900' }}">
                            {{ $summary['formatted_shipping_fee'] }}
                        </span>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-baseline justify-between">
                        <span class="text-base font-bold text-slate-900">Tổng thanh toán:</span>
                        <span class="text-2xl font-black text-emerald-600 tracking-tight">
                            {{ $summary['formatted_total'] }}
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 px-5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-extrabold rounded-2xl transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-base">
                        <span>Xác nhận Đặt hàng ngay</span>
                        <span>➔</span>
                    </button>
                    <p class="text-[11px] text-center text-slate-400 mt-2.5">
                        Bằng việc bấm đặt hàng, bạn đồng ý với chính sách bán hàng và bảo hành thuốc BVTV của chúng tôi.
                    </p>
                </div>
            </div>

            <!-- Cam kết giao dịch an toàn -->
            <div class="p-4 bg-emerald-50/70 border border-emerald-200/60 rounded-2xl text-xs text-emerald-900 space-y-1.5">
                <div class="font-bold flex items-center gap-1.5">
                    <span>🛡️ Bảo hộ người nông dân:</span>
                </div>
                <p class="text-[11px] text-emerald-800 leading-relaxed">
                    Hàng được xuất trực tiếp từ kho đạt chuẩn nhiệt độ & độ ẩm. Có tem QR truy xuất nguồn gốc lô sản xuất từ Cục BVTV.
                </p>
            </div>

        </div>

    </form>

</div>
</x-layouts.storefront>
