@php
    $d = $result;
    $statusBg = 'bg-emerald-50 border-emerald-300 text-emerald-900';
    $statusBadge = '<span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold">🟢 AN TOÀN - CÓ THỂ PHỐI TRỘN</span>';
    $statusTitle = 'Hai sản phẩm này có tính tương thích tốt khi pha chung';

    if ($d['status'] === 'danger') {
        $statusBg = 'bg-red-50/90 border-red-300 text-red-950';
        $statusBadge = '<span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">🔴 CẤM KỴ - KHÔNG ĐƯỢC PHỐI TRỘN</span>';
        $statusTitle = 'CẢNH BÁO: Phát hiện phản ứng tương kỵ nguy hiểm!';
    } elseif ($d['status'] === 'warning') {
        $statusBg = 'bg-amber-50/90 border-amber-300 text-amber-950';
        $statusBadge = '<span class="bg-amber-600 text-white px-3 py-1 rounded-full text-xs font-bold">🟡 THẬN TRỌNG - LƯU Ý KHI PHỐI</span>';
        $statusTitle = 'Có thể phối nhưng cần tuân thủ lưu ý kỹ thuật';
    }
@endphp

<div class="p-6 rounded-3xl border-2 {{ $statusBg }} shadow-sm transition-all">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
        {!! $statusBadge !!}
        <span class="text-xs text-gray-500">Phân tích chuyên gia BVTV</span>
    </div>
    <h3 class="text-lg font-bold mt-2.5">{{ $statusTitle }}</h3>

    @if(!empty($d['conflicts']))
        <div class="mt-5 space-y-3">
            <h4 class="text-xs font-bold uppercase tracking-wider {{ $d['status'] === 'danger' ? 'text-red-900' : 'text-amber-900' }}">
                Chi tiết phản ứng tương kỵ phát hiện:
            </h4>
            @foreach($d['conflicts'] as $c)
                <div class="bg-white p-4 rounded-2xl border {{ $c['level'] === 'danger' ? 'border-red-200 shadow-2xs' : 'border-amber-200 shadow-2xs' }} space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="text-base">{{ $c['level'] === 'danger' ? '🚫' : '⚠️' }}</span>
                        <span class="font-bold text-sm {{ $c['level'] === 'danger' ? 'text-red-700' : 'text-amber-700' }}">{{ $c['title'] }}</span>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed"><strong>• Nguyên nhân:</strong> {{ $c['reason'] }}</p>
                    <p class="text-xs text-gray-700 leading-relaxed"><strong>• Hậu quả:</strong> {{ $c['consequence'] }}</p>
                    <p class="text-xs text-emerald-800 font-medium leading-relaxed bg-emerald-50/80 p-2 rounded-lg border border-emerald-200/50">
                        <strong>💡 Lời khuyên:</strong> {{ $c['advice'] }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    @if(!empty($d['mixing_order']))
        <div class="mt-6 pt-5 border-t border-gray-200/80">
            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                <span>💧</span> Hướng dẫn thứ tự pha vào phuy:
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($d['mixing_order'] as $m)
                    <div class="bg-white p-3 rounded-xl border border-gray-200 flex items-start gap-2.5 shadow-2xs">
                        <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                            {{ $m['step'] }}
                        </span>
                        <div class="text-xs">
                            <div class="font-bold text-gray-900">{{ $m['name'] }} <span class="text-[10px] text-gray-500 font-mono">({{ $m['form_type'] }})</span></div>
                            <div class="text-gray-600 mt-0.5 leading-relaxed">{{ $m['instruction'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
