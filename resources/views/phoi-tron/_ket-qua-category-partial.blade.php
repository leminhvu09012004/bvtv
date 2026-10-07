@php
    $d = $catResult ?? [];
    if (empty($d) || ($d['status'] ?? '') === 'empty' || empty($d['category_1']) || empty($d['category_2'])) {
@endphp
    <div class="p-6 rounded-3xl border border-gray-200 bg-gray-50 text-gray-700 text-sm">
        ⚠️ {{ $d['message'] ?? 'Không tìm thấy thông tin danh mục hoặc dữ liệu kiểm tra không hợp lệ.' }}
    </div>
@php
        return;
    }

    $statusBg = 'bg-emerald-50 border-emerald-300 text-emerald-900';
    $statusBadge = '<span class="bg-emerald-600 text-white px-3.5 py-1 rounded-full text-xs font-bold">🟢 TƯƠNG THÍCH TỐT - CÓ THỂ PHỐI TRỘN</span>';

    if (($d['status'] ?? '') === 'danger') {
        $statusBg = 'bg-red-50/90 border-red-300 text-red-950';
        $statusBadge = '<span class="bg-red-600 text-white px-3.5 py-1 rounded-full text-xs font-bold animate-pulse">🔴 CẤM KỴ - PHÁT HIỆN SẢN PHẨM KHÔNG ĐƯỢC TRỘN</span>';
    } elseif (($d['status'] ?? '') === 'warning') {
        $statusBg = 'bg-amber-50/90 border-amber-300 text-amber-950';
        $statusBadge = '<span class="bg-amber-600 text-white px-3.5 py-1 rounded-full text-xs font-bold">🟡 THẬN TRỌNG - CẦN LƯU Ý KỸ THUẬT</span>';
    }
@endphp

<div class="p-6 rounded-3xl border-2 {{ $statusBg }} shadow-sm transition-all">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-200/60">
        <div>
            {!! $statusBadge !!}
            <div class="flex items-center gap-2 mt-2 font-extrabold text-base lg:text-lg text-gray-900">
                <span>{{ $d['category_1']->emoji ?? '📁' }} {{ $d['category_1']->name }}</span>
                <span class="text-gray-400">⟷</span>
                <span>{{ $d['category_2']->emoji ?? '📁' }} {{ $d['category_2']->name }}</span>
            </div>
        </div>
        <div class="text-right text-xs">
            <span class="font-bold text-red-700 bg-red-100 px-3 py-1 rounded-full border border-red-200">
                {{ $d['total_conflicts'] }} cặp sản phẩm xung đột
            </span>
        </div>
    </div>

    <p class="text-xs sm:text-sm font-semibold mt-3 text-gray-800 leading-relaxed">
        {{ $d['summary'] }}
    </p>

    @if(!empty($d['conflict_pairs']))
        <div class="mt-6 space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-red-900 flex items-center gap-1.5">
                <span>🚫</span> DANH SÁCH CÁC SẢN PHẨM KHÔNG ĐƯỢC TRỘN VỚI NHAU GIỮA 2 DANH MỤC:
            </h4>

            <div class="space-y-3.5">
                @foreach($d['conflict_pairs'] as $idx => $pair)
                    @php
                        $p1 = $pair['product_1'];
                        $p2 = $pair['product_2'];
                    @endphp
                    <div class="bg-white rounded-2xl border {{ $pair['level'] === 'danger' ? 'border-red-200 shadow-xs' : 'border-amber-200 shadow-xs' }} p-4.5 space-y-3">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 bg-gray-50/80 p-3 rounded-xl border border-gray-200/70">
                            <!-- Sản phẩm 1 -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                @if($p1->image_url)
                                    <img src="{{ $p1->image_url }}" alt="{{ $p1->name }}" class="w-12 h-12 rounded-xl object-contain bg-white border border-gray-200 shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-lg shrink-0">💊</div>
                                @endif
                                <div class="min-w-0">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Danh mục: {{ $d['category_1']->name }}</span>
                                    <a href="{{ route('thuoc.xem', $p1) }}" target="_blank" class="font-bold text-xs sm:text-sm text-gray-900 hover:text-emerald-700 hover:underline truncate block">
                                        {{ $p1->name }}
                                    </a>
                                    <span class="text-[11px] text-gray-500 block truncate">Hoạt chất: {{ $p1->active_ingredient ?: 'Chưa rõ' }}</span>
                                </div>
                            </div>

                            <!-- Dấu Kỵ Nhau -->
                            <div class="shrink-0 flex items-center justify-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-black self-center border border-red-200 shadow-2xs">
                                ⚡ KHÔNG ĐƯỢC TRỘN ⚡
                            </div>

                            <!-- Sản phẩm 2 -->
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                @if($p2->image_url)
                                    <img src="{{ $p2->image_url }}" alt="{{ $p2->name }}" class="w-12 h-12 rounded-xl object-contain bg-white border border-gray-200 shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-lg shrink-0">💊</div>
                                @endif
                                <div class="min-w-0">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Danh mục: {{ $d['category_2']->name }}</span>
                                    <a href="{{ route('thuoc.xem', $p2) }}" target="_blank" class="font-bold text-xs sm:text-sm text-gray-900 hover:text-emerald-700 hover:underline truncate block">
                                        {{ $p2->name }}
                                    </a>
                                    <span class="text-[11px] text-gray-500 block truncate">Hoạt chất: {{ $p2->active_ingredient ?: 'Chưa rõ' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Giải thích nguyên nhân & hậu quả -->
                        <div class="text-xs space-y-1.5 pt-1 pl-1">
                            <div class="font-bold {{ $pair['level'] === 'danger' ? 'text-red-700' : 'text-amber-700' }} flex items-center gap-1.5">
                                <span>{{ $pair['level'] === 'danger' ? '🚫' : '⚠️' }}</span>
                                <span>{{ $pair['title'] }}</span>
                            </div>
                            <p class="text-gray-700 leading-relaxed"><strong>• Nguyên nhân hóa sinh:</strong> {{ $pair['reason'] }}</p>
                            <p class="text-gray-700 leading-relaxed"><strong>• Hậu quả thực tế:</strong> {{ $pair['consequence'] }}</p>
                            <p class="text-emerald-900 bg-emerald-50/80 p-2 rounded-lg border border-emerald-200/60 leading-relaxed font-medium">
                                <strong>💡 Lời khuyên nông học:</strong> {{ $pair['advice'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-5 bg-white p-5 rounded-2xl border border-emerald-200 text-center text-xs text-emerald-800">
            <span class="text-2xl block mb-1">🎉</span>
            <strong>Tuyệt vời!</strong> Toàn bộ các sản phẩm giữa hai danh mục này không phát hiện xung đột cấm kỵ nào. Bạn có thể phối hợp an toàn nếu tuân thủ liều lượng và thứ tự hòa tan.
        </div>
    @endif
</div>
