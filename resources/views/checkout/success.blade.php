<x-layouts.storefront title="Đặt hàng thành công — {{ $order->code }}">
<div class="px-4 py-8 lg:px-8 lg:py-12 max-w-4xl mx-auto">

    <!-- Success Hero -->
    <div class="text-center pb-8 border-b border-slate-200">
        <div class="w-20 h-20 mx-auto rounded-3xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl mb-4 shadow-sm animate-bounce">
            🎉
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Đặt hàng thành công!
        </h1>
        <p class="text-sm text-slate-600 mt-2 max-w-lg mx-auto">
            Cảm ơn quý bà con đã tin tưởng đặt mua thuốc bảo vệ thực vật tại hệ thống. Đơn hàng của bạn đã được ghi nhận vào hệ thống kho và chuẩn bị đóng gói.
        </p>
        <div class="mt-4 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-xs text-slate-700 font-mono">
            <span>Mã đơn hàng:</span>
            <strong class="text-emerald-700 text-sm font-bold">{{ $order->code }}</strong>
        </div>
    </div>

    <!-- Invoice Card / Printable Area -->
    <div class="mt-8 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-8" id="printable-order">

        <!-- Header thông tin đơn -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="text-xs uppercase tracking-wider text-slate-400 font-bold">Chi nhánh xuất kho</div>
                <div class="text-base font-bold text-slate-900 mt-0.5">
                    {{ $order->warehouse ? $order->warehouse->name : 'Kho Tổng' }}
                </div>
                <div class="text-xs text-slate-500 mt-0.5">
                    {{ $order->warehouse ? $order->warehouse->address : '' }}
                </div>
            </div>

            <div class="sm:text-right">
                <div class="text-xs text-slate-400">Thời gian tạo:</div>
                <div class="text-xs font-semibold text-slate-700 mt-0.5">
                    {{ $order->created_at->format('H:i, d/m/Y') }}
                </div>
                <div class="mt-2 flex items-center sm:justify-end gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        ✓ Đã xác nhận
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Thông tin giao hàng & Người nhận -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50/70 p-5 rounded-2xl border border-slate-100">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Thông tin người nhận</h3>
                <div class="text-sm font-bold text-slate-900">{{ $order->shipping_recipient_name }}</div>
                <div class="text-xs text-slate-600 mt-1">📞 {{ $order->shipping_phone }}</div>
                <div class="text-xs text-slate-600 mt-1">
                    🏠 {{ $order->shipping_address_line }}
                    @if($order->shipping_ward), {{ $order->shipping_ward }} @endif
                    @if($order->shipping_district), {{ $order->shipping_district }} @endif
                    @if($order->shipping_province), {{ $order->shipping_province }} @endif
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Thanh toán & Giao vận</h3>
                <div class="text-xs text-slate-700">
                    <span class="text-slate-400">Phương thức:</span>
                    <strong class="text-slate-900 uppercase">
                        @if($order->payments->isNotEmpty() && $order->payments->first()->transactions->isNotEmpty())
                            {{ $order->payments->first()->transactions->first()->method }}
                        @else
                            TIỀN MẶT / COD
                        @endif
                    </strong>
                </div>
                <div class="text-xs text-slate-700 mt-1">
                    <span class="text-slate-400">Kênh đặt hàng:</span>
                    <strong class="text-slate-900">Website Trực Tuyến</strong>
                </div>
                @if($order->notes)
                    <div class="text-xs text-slate-600 mt-2 p-2 bg-white rounded-lg border border-slate-200">
                        <span class="font-bold text-slate-700">Ghi chú:</span> {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Bảng danh sách sản phẩm trong đơn -->
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Chi tiết sản phẩm</h3>
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="py-3 px-4">Tên sản phẩm & Quy cách</th>
                            <th class="py-3 px-3 text-center">Số lượng</th>
                            <th class="py-3 px-3 text-right">Đơn giá</th>
                            <th class="py-3 px-4 text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900">{{ $item->product_name }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $item->specification }} &bull; SKU: {{ $item->variant_sku }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 text-center font-bold text-slate-800">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-3.5 px-3 text-right text-slate-700 tabular-nums">
                                    {{ $item->formatted_price }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-extrabold text-emerald-700 tabular-nums">
                                    {{ $item->formatted_total }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng tính tổng tiền -->
        <div class="flex justify-end">
            <div class="w-full sm:w-72 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Tạm tính tiền hàng:</span>
                    <span class="font-bold text-slate-900">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Phí vận chuyển:</span>
                    <span class="font-bold text-slate-900">{{ $order->shipping_fee === 0 ? 'Miễn phí' : number_format($order->shipping_fee, 0, ',', '.') . ' ₫' }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-rose-600">
                        <span>Chiết khấu:</span>
                        <span class="font-bold">-{{ number_format($order->discount_amount, 0, ',', '.') }} ₫</span>
                    </div>
                @endif
                <div class="pt-2 border-t border-slate-200 flex justify-between text-sm font-black text-slate-900">
                    <span>Tổng tiền thanh toán:</span>
                    <span class="text-base text-emerald-600">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Nút hành động cuối trang -->
    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
        <button onclick="window.print()"
                class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition shadow-2xs flex items-center justify-center gap-2">
            <span>🖨️ In hóa đơn / Lưu PDF</span>
        </button>

        <a href="{{ route('thuoc.tra-cuu') }}"
           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-md flex items-center justify-center gap-2">
            <span>🌱 Tiếp tục mua sắm thuốc</span>
        </a>

        <a href="{{ route('home') }}"
           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-2">
            <span>🏠 Về trang chủ</span>
        </a>
    </div>

</div>
</x-layouts.storefront>
