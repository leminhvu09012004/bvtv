<x-layouts.app title="Kiểm Kê Kho & Cân Đối Chênh Lệch">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Kiểm kê kho</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📋</span> Kiểm Kê Kho & Cân Đối Sổ Cái (Inventory Counts)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Đối chiếu số tồn hệ thống và thực tế đếm tại kho; hệ thống sẽ sinh bút toán điều chỉnh sổ cái (count_adjustment).
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    🏢 Quay lại kho
                </x-ui.button>
            </div>
        </div>

        @if(session('success'))
            <x-ui.alert variant="success" :dismissible="true">
                {{ session('success') }}
            </x-ui.alert>
        @endif

        @if(session('error'))
            <x-ui.alert variant="danger" :dismissible="true">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Mã phiếu kiểm kê</th>
                            <th class="px-5 py-3.5">Kho kiểm kê</th>
                            <th class="px-5 py-3.5">Số lượng mặt hàng</th>
                            <th class="px-5 py-3.5">Ghi chú</th>
                            <th class="px-5 py-3.5 text-center">Trạng thái</th>
                            <th class="px-5 py-3.5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($counts as $cnt)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="font-mono text-xs font-bold text-slate-800">{{ $cnt->count_code }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $cnt->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs">{{ $cnt->warehouse->name }}</span>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $cnt->warehouse->code }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-slate-700 tabular-nums">
                                    {{ $cnt->items->count() }} mặt hàng
                                </td>
                                <td class="px-5 py-3.5 text-xs text-slate-500">
                                    {{ $cnt->notes ?? 'Kiểm kê định kỳ' }}
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap status-badge-cell">
                                    @php
                                        $st = match($cnt->status) {
                                            'draft' => ['variant' => 'neutral', 'label' => 'Bản nháp'],
                                            'in_progress' => ['variant' => 'avoid', 'label' => 'Đang đếm kho'],
                                            'reconciled' => ['variant' => 'compatible', 'label' => 'Đã cân đối sổ cái'],
                                            'cancelled' => ['variant' => 'forbidden', 'label' => 'Đã hủy'],
                                            default => ['variant' => 'neutral', 'label' => $cnt->status],
                                        };
                                    @endphp
                                    <x-ui.badge :variant="$st['variant']" size="xs">
                                        {{ $st['label'] }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    @if(in_array($cnt->status, ['draft', 'in_progress'], true))
                                        <form method="POST" action="{{ route('admin.inventory.counts.reconcile', $cnt) }}" class="ajax-action-form inline">
                                            @csrf
                                            <x-ui.button type="submit" variant="primary" size="xs">
                                                ⚖️ Cân đối chênh lệch
                                            </x-ui.button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">Đã chốt sổ</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-xs">
                                    Chưa có phiếu kiểm kê nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($counts->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                    {{ $counts->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>
</x-layouts.app>
