<x-layouts.app title="Sổ Cái Biến Động Kho Bất Biến">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Sổ cái biến động kho</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📜</span> Sổ Cái Biến Động Kho Bất Biến (Immutable Stock Ledger)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Nhật ký ghi sổ append-only lưu vết mọi hoạt động nhập, xuất, chuyển kho, kiểm kê với số dư tức thời.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    🏢 Xem tồn kho hiện tại
                </x-ui.button>
            </div>
        </div>

        <!-- Filter Toolbar -->
        <x-ui.card :padding="true">
            <form method="GET" action="{{ route('admin.inventory.movements') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <div class="sm:col-span-5">
                    <x-ui.input 
                        label="Tìm theo Mã biến động, SKU, Tên thuốc" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="VD: INIT-, VIR-, ..." 
                    />
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kho hàng</label>
                    <select name="warehouse_id" class="w-full rounded-xl text-sm border border-slate-300 py-2.5 px-3 bg-white text-slate-800 focus:outline-hidden focus:border-emerald-500">
                        <option value="">-- Tất cả kho --</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->name }} ({{ $w->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Loại giao dịch</label>
                    <select name="type" class="w-full rounded-xl text-sm border border-slate-300 py-2.5 px-3 bg-white text-slate-800 focus:outline-hidden focus:border-emerald-500">
                        <option value="">-- Tất cả loại --</option>
                        <option value="purchase_receipt" {{ request('type') === 'purchase_receipt' ? 'selected' : '' }}>Nhập hàng</option>
                        <option value="pos_sale" {{ request('type') === 'pos_sale' ? 'selected' : '' }}>Bán tại POS</option>
                        <option value="online_sale" {{ request('type') === 'online_sale' ? 'selected' : '' }}>Bán Online</option>
                        <option value="stock_transfer_out" {{ request('type') === 'stock_transfer_out' ? 'selected' : '' }}>Chuyển kho xuất</option>
                        <option value="stock_transfer_in" {{ request('type') === 'stock_transfer_in' ? 'selected' : '' }}>Chuyển kho nhập</option>
                        <option value="count_adjustment" {{ request('type') === 'count_adjustment' ? 'selected' : '' }}>Cân đối kiểm kê</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex gap-2">
                    <x-ui.button type="submit" variant="primary" size="md" class="w-full">
                        Lọc
                    </x-ui.button>
                    @if(request()->hasAny(['q', 'warehouse_id', 'type']))
                        <x-ui.button href="{{ route('admin.inventory.movements') }}" variant="ghost" size="md">
                            Đặt lại
                        </x-ui.button>
                    @endif
                </div>
            </form>
        </x-ui.card>

        <!-- Ledger Table -->
        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Thời gian & Mã sổ cái</th>
                            <th class="px-5 py-3.5">Kho</th>
                            <th class="px-5 py-3.5">Sản phẩm & SKU</th>
                            <th class="px-5 py-3.5 text-center">Nghiệp vụ</th>
                            <th class="px-5 py-3.5 text-right">Biến động</th>
                            <th class="px-5 py-3.5 text-right">Trước ➔ Sau</th>
                            <th class="px-5 py-3.5 text-right">Giá vốn</th>
                            <th class="px-5 py-3.5">Chứng từ / Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($movements as $m)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="font-mono text-xs font-bold text-slate-800">{{ $m->movement_code }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $m->created_at->format('d/m/Y H:i:s') }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-semibold text-xs text-slate-700">{{ $m->warehouse->name }}</span>
                                    @if($m->destinationWarehouse)
                                        <div class="text-[11px] text-sky-600 mt-0.5">➔ Đến: {{ $m->destinationWarehouse->name }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-slate-800 text-xs line-clamp-1">
                                        {{ $m->variant->pesticide->name }}
                                    </div>
                                    <div class="font-mono text-[11px] text-slate-500 mt-0.5">
                                        SKU: {{ $m->variant->sku }} ({{ $m->variant->specification }})
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @php
                                        $typeBadge = match($m->type) {
                                            'purchase_receipt' => ['variant' => 'compatible', 'label' => 'Nhập hàng'],
                                            'pos_sale' => ['variant' => 'brand', 'label' => 'Bán tại POS'],
                                            'online_sale' => ['variant' => 'info', 'label' => 'Bán Online'],
                                            'stock_transfer_out' => ['variant' => 'avoid', 'label' => 'Chuyển đi'],
                                            'stock_transfer_in' => ['variant' => 'compatible', 'label' => 'Nhận chuyển'],
                                            'count_adjustment' => ['variant' => 'purple', 'label' => 'Kiểm kê'],
                                            default => ['variant' => 'neutral', 'label' => $m->type],
                                        };
                                    @endphp
                                    <x-ui.badge :variant="$typeBadge['variant']" size="xs">
                                        {{ $typeBadge['label'] }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap font-extrabold tabular-nums {{ $m->quantity_change > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $m->quantity_change > 0 ? '+' : '' }}{{ number_format($m->quantity_change) }}
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap tabular-nums text-xs font-mono text-slate-600">
                                    {{ number_format($m->balance_before) }} ➔ <span class="font-bold text-slate-900">{{ number_format($m->balance_after) }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap tabular-nums text-xs text-slate-600">
                                    {{ number_format($m->unit_cost) }} ₫
                                </td>
                                <td class="px-5 py-3.5 text-xs text-slate-500">
                                    <span class="font-mono text-slate-700 font-medium">[{{ $m->reference_type }} #{{ $m->reference_id }}]</span>
                                    @if($m->notes)
                                        <div class="text-[11px] text-slate-400 mt-0.5 truncate max-w-xs">{{ $m->notes }}</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-400 text-xs">
                                    Chưa có giao dịch sổ cái nào được ghi nhận.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($movements->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                    {{ $movements->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>
</x-layouts.app>
