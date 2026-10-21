<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Phiếu Xuất Kho - {{ $issue->issue_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 10mm !important;
            }
        }
        @page {
            size: A4;
            margin: 10mm;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 p-4 sm:p-8 min-h-screen">

    <!-- Thanh công cụ in (Ẩn khi in) -->
    <div class="no-print max-w-4xl mx-auto mb-4 flex items-center justify-between bg-white p-4 rounded-xl shadow-xs border border-slate-200">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.inventory.issues') }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                ← Quay lại danh sách
            </a>
            <span class="text-xs text-slate-400">|</span>
            <span class="text-xs font-mono font-bold text-slate-700">{{ $issue->issue_code }}</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                🖨️ In Phiếu Ngay (A4)
            </button>
        </div>
    </div>

    <!-- Khung mẫu Phiếu Xuất Kho A4 -->
    <div class="print-container max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-md border border-slate-200">
        
        <!-- Header đơn vị -->
        <div class="flex justify-between items-start pb-6 border-b border-slate-200">
            <div>
                <div class="text-base font-black uppercase text-emerald-800 tracking-wide">CỬA HÀNG VẬT TƯ NÔNG NGHIỆP TÂY NGUYÊN</div>
                <div class="text-xs text-slate-600 mt-1 font-medium">Chi nhánh: <b class="text-slate-900">{{ $issue->warehouse->name }}</b></div>
                <div class="text-xs text-slate-500">Địa chỉ: {{ $issue->warehouse->address ?: 'Đắk Lắk' }}</div>
                @if($issue->warehouse->phone)
                    <div class="text-xs text-slate-500">Điện thoại: {{ $issue->warehouse->phone }}</div>
                @endif
            </div>
            <div class="text-right">
                <div class="text-xs font-bold uppercase text-slate-500 tracking-wider">Mẫu số: 02 - VT</div>
                <div class="text-[11px] text-slate-400 mt-0.5">(Ban hành theo TT số 200/2014/TT-BTC)</div>
                <div class="mt-2 text-xs font-mono font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded inline-block border border-slate-200">
                    Mã: {{ $issue->issue_code }}
                </div>
            </div>
        </div>

        <!-- Tiêu đề chứng từ -->
        <div class="text-center my-6">
            <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900">PHIẾU XUẤT KHO</h1>
            <p class="text-xs text-slate-500 mt-1 italic">
                Ngày {{ $issue->created_at->format('d') }} tháng {{ $issue->created_at->format('m') }} năm {{ $issue->created_at->format('Y') }}
            </p>
        </div>

        <!-- Thông tin xuất kho -->
        <div class="grid grid-cols-2 gap-4 text-xs mb-6 bg-slate-50/70 p-4 rounded-xl border border-slate-100">
            <div class="space-y-1.5">
                <div>
                    <span class="text-slate-500 font-medium">Người lập phiếu:</span>
                    <span class="font-bold text-slate-800 ml-1">{{ $issue->creator->name ?? 'Quản trị viên' }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Kho xuất hàng:</span>
                    <span class="font-bold text-slate-800 ml-1">{{ $issue->warehouse->name }} ({{ $issue->warehouse->code }})</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Lý do xuất kho:</span>
                    @php
                        $reasonLabel = match($issue->reason) {
                            'damage_writeoff' => 'Xuất hủy hàng hỏng / hết hạn sử dụng',
                            'supplier_return' => 'Xuất trả hàng nhà phân phối / nhà sản xuất',
                            'internal_use'    => 'Xuất sử dụng nội bộ tại cửa hàng / trang trại',
                            'sample'          => 'Xuất hàng mẫu thử nghiệm kỹ thuật',
                            default           => $issue->reason,
                        };
                    @endphp
                    <span class="font-bold text-emerald-800 ml-1">{{ $reasonLabel }}</span>
                </div>
            </div>
            <div class="space-y-1.5">
                <div>
                    <span class="text-slate-500 font-medium">Thời gian lập:</span>
                    <span class="font-semibold text-slate-800 ml-1">{{ $issue->created_at->format('H:i - d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Trạng thái duyệt:</span>
                    <span class="font-bold {{ $issue->status === 'approved' ? 'text-emerald-700' : 'text-amber-700' }} ml-1">
                        {{ $issue->status === 'approved' ? 'Đã duyệt xuất kho (Đã ghi Sổ Cái)' : 'Bản nháp' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Ghi chú diễn giải:</span>
                    <span class="italic text-slate-700 ml-1">{{ $issue->notes ?: 'Không có ghi chú' }}</span>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách hàng hóa xuất kho -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-xs text-left border border-slate-300 divide-y divide-slate-300">
                <thead class="bg-slate-100 font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="border border-slate-300 px-3 py-2 text-center w-12">STT</th>
                        <th class="border border-slate-300 px-3 py-2">Tên sản phẩm & Quy cách</th>
                        <th class="border border-slate-300 px-3 py-2 text-center w-24">Mã SKU</th>
                        <th class="border border-slate-300 px-3 py-2 text-center w-20">ĐVT</th>
                        <th class="border border-slate-300 px-3 py-2 text-right w-24">Số lượng</th>
                        <th class="border border-slate-300 px-3 py-2 text-right w-28">Đơn giá vốn</th>
                        <th class="border border-slate-300 px-3 py-2 text-right w-32">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300">
                    @php 
                        $totalQty = 0; 
                        $totalAmount = 0; 
                    @endphp
                    @foreach($issue->items as $idx => $item)
                        @php
                            $lineTotal = (int)$item->quantity * (int)$item->unit_cost;
                            $totalQty += $item->quantity;
                            $totalAmount += $lineTotal;
                        @endphp
                        <tr>
                            <td class="border border-slate-300 px-3 py-2.5 text-center font-mono">{{ $idx + 1 }}</td>
                            <td class="border border-slate-300 px-3 py-2.5">
                                <div class="font-bold text-slate-900">{{ $item->variant->pesticide->name ?? 'Thuốc BVTV' }}</div>
                                @if(!empty($item->variant->pesticide->active_ingredient))
                                    <div class="text-[10px] text-slate-500">Hoạt chất: {{ $item->variant->pesticide->active_ingredient }}</div>
                                @endif
                                <div class="text-[11px] text-slate-600 font-medium">Quy cách: {{ $item->variant->specification ?? '-' }}</div>
                            </td>
                            <td class="border border-slate-300 px-3 py-2.5 text-center font-mono text-[11px]">{{ $item->variant->sku }}</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-center">{{ $item->variant->unit ?: 'Chai/Gói' }}</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-right font-bold text-slate-900 text-sm tabular-nums">{{ number_format($item->quantity) }}</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-right font-mono tabular-nums">{{ number_format($item->unit_cost) }} ₫</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-right font-bold text-slate-900 font-mono tabular-nums">{{ number_format($lineTotal) }} ₫</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50 font-bold text-slate-900 text-xs">
                    <tr>
                        <td colspan="4" class="border border-slate-300 px-3 py-2.5 text-right uppercase tracking-wider">Cộng tổng cộng:</td>
                        <td class="border border-slate-300 px-3 py-2.5 text-right font-extrabold text-sm tabular-nums text-emerald-800">{{ number_format($totalQty) }}</td>
                        <td class="border border-slate-300 px-3 py-2.5"></td>
                        <td class="border border-slate-300 px-3 py-2.5 text-right font-extrabold text-sm font-mono tabular-nums text-emerald-800">{{ number_format($totalAmount) }} ₫</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-xs text-slate-600 italic mb-8">
            * Tổng số lượng xuất: <b class="text-slate-900">{{ number_format($totalQty) }}</b> đơn vị sản phẩm. Tổng giá trị xuất kho: <b class="text-slate-900">{{ number_format($totalAmount) }} đồng</b>.
        </div>

        <!-- Chữ ký các bên -->
        <div class="grid grid-cols-4 gap-4 text-center text-xs mt-10 pb-16">
            <div>
                <div class="font-bold uppercase text-slate-800">Người Lập Phiếu</div>
                <div class="text-[11px] text-slate-400 italic mt-0.5">(Ký, họ tên)</div>
                <div class="mt-16 font-semibold text-slate-800">{{ $issue->creator->name ?? 'Admin' }}</div>
            </div>
            <div>
                <div class="font-bold uppercase text-slate-800">Người Nhận Hàng</div>
                <div class="text-[11px] text-slate-400 italic mt-0.5">(Ký, họ tên)</div>
                <div class="mt-16 text-slate-400 italic">...........................</div>
            </div>
            <div>
                <div class="font-bold uppercase text-slate-800">Thủ Kho Xuất</div>
                <div class="text-[11px] text-slate-400 italic mt-0.5">(Ký, họ tên)</div>
                <div class="mt-16 text-slate-400 italic">...........................</div>
            </div>
            <div>
                <div class="font-bold uppercase text-slate-800">Kế Toán / Thủ Trưởng</div>
                <div class="text-[11px] text-slate-400 italic mt-0.5">(Ký, đóng dấu)</div>
                <div class="mt-16 text-slate-400 italic">...........................</div>
            </div>
        </div>

    </div>

</body>
</html>
