<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
            <tr>
                <th class="px-5 py-3.5 text-center w-20">Hình ảnh</th>
                <th class="px-5 py-3.5">Sản phẩm & Biến thể</th>
                <th class="px-5 py-3.5 text-right">Tồn thực tế</th>
                <th class="px-5 py-3.5 text-center">Trạng thái</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-normal">
            @forelse($inventories as $inv)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-5 py-3.5 text-center whitespace-nowrap">
                        @php
                            $imageUrl = $inv->variant->image ? asset('storage/' . $inv->variant->image) : ($inv->variant->pesticide->image_url ?? null);
                        @endphp
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $inv->variant->pesticide->name }}" class="w-12 h-12 rounded-xl object-cover bg-white border border-slate-200 shadow-2xs mx-auto" loading="lazy" onerror="this.onerror=null; this.classList.add('hidden'); if(this.nextElementSibling) this.nextElementSibling.classList.remove('hidden');">
                            <div class="hidden w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-lg mx-auto">
                                📦
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-lg mx-auto">
                                📦
                            </div>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="font-semibold text-slate-800 text-xs">
                            {{ $inv->variant->pesticide->name }}
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5">
                            Quy cách: <span class="font-medium text-slate-700">{{ $inv->variant->specification }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap font-bold text-slate-800 tabular-nums">
                        {{ number_format($inv->quantity_on_hand) }}
                    </td>
                    <td class="px-5 py-3.5 text-center whitespace-nowrap">
                        @if($inv->quantity_available <= 0)
                            <x-ui.badge variant="forbidden" size="xs" :dot="true">Hết hàng</x-ui.badge>
                        @elseif($inv->quantity_available <= $inv->reorder_point)
                            <x-ui.badge variant="avoid" size="xs" :dot="true">Chạm điểm đặt lại (≤{{ $inv->reorder_point }})</x-ui.badge>
                        @else
                            <x-ui.badge variant="compatible" size="xs" :dot="true">Đủ hàng</x-ui.badge>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-10 text-center text-slate-400 text-xs">
                        Không tìm thấy dữ liệu tồn kho nào thỏa mãn điều kiện lọc.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($inventories->hasPages())
    <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50 inventory-pagination">
        {{ $inventories->links() }}
    </div>
@endif
