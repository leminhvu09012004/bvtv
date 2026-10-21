<x-layouts.app title="Chuyển Kho Liên Chi Nhánh">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Chuyển kho</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>🚚</span> Điều Chuyển Kho Liên Chi Nhánh (Stock Transfers)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Quy trình 2 bước chuẩn: Xuất kho chuyển đi (Dispatched) ➔ Nhận kho đích (Received), đảm bảo hạch toán sổ cái chính xác.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    🏢 Quay lại kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.receipts') }}" variant="secondary" size="sm">
                    📥 Nhập kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.issues') }}" variant="secondary" size="sm">
                    📤 Xuất kho
                </x-ui.button>
                <x-ui.button type="button" variant="primary" size="sm" onclick="openCreateTransferModal()">
                    ➕ Tạo Phiếu Chuyển Kho
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

        @if(isset($errors) && $errors->any())
            <x-ui.alert variant="danger" :dismissible="true">
                <ul class="list-disc pl-5 space-y-1 text-xs">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <!-- Transfers Table -->
        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Mã chuyển kho</th>
                            <th class="px-5 py-3.5">Từ kho xuất</th>
                            <th class="px-5 py-3.5">Đến kho đích</th>
                            <th class="px-5 py-3.5">Chi tiết sản phẩm</th>
                            <th class="px-5 py-3.5 text-center">Trạng thái</th>
                            <th class="px-5 py-3.5 text-right">Thao tác xử lý</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($transfers as $tf)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="font-mono text-xs font-bold text-slate-800">{{ $tf->transfer_code }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $tf->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs">{{ $tf->fromWarehouse->name }}</span>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $tf->fromWarehouse->code }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs text-sky-700">{{ $tf->toWarehouse->name }}</span>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $tf->toWarehouse->code }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs">
                                    <div class="space-y-1">
                                        @foreach($tf->items as $it)
                                            <div>
                                                <span class="font-medium text-slate-800">{{ $it->variant->pesticide->name }}</span>
                                                <span class="text-slate-500 font-mono">({{ $it->variant->sku }}):</span>
                                                <b class="text-emerald-600 tabular-nums">{{ number_format($it->quantity) }}</b> cái
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($tf->notes)
                                        <div class="text-[11px] text-slate-400 italic mt-1">"{{ $tf->notes }}"</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap status-badge-cell">
                                    @php
                                        $st = match($tf->status) {
                                            'draft' => ['variant' => 'neutral', 'label' => 'Bản nháp'],
                                            'dispatched' => ['variant' => 'avoid', 'label' => '🚚 Đang vận chuyển'],
                                            'received' => ['variant' => 'compatible', 'label' => '✓ Đã hoàn tất'],
                                            'cancelled' => ['variant' => 'forbidden', 'label' => 'Đã hủy'],
                                            default => ['variant' => 'neutral', 'label' => $tf->status],
                                        };
                                    @endphp
                                    <x-ui.badge :variant="$st['variant']" size="xs">
                                        {{ $st['label'] }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    @if($tf->status === 'draft')
                                        <form method="POST" action="{{ route('admin.inventory.transfers.dispatch', $tf) }}" class="ajax-action-form inline" onsubmit="return confirm('Xác nhận xuất kho chuyển đi? Tồn kho xuất sẽ được trừ và ghi Sổ Cái.')">
                                            @csrf
                                            <x-ui.button type="submit" variant="primary" size="xs">
                                                Xuất kho chuyển đi ➔
                                            </x-ui.button>
                                        </form>
                                    @elseif($tf->status === 'dispatched')
                                        <form method="POST" action="{{ route('admin.inventory.transfers.receive', $tf) }}" class="ajax-action-form inline" onsubmit="return confirm('Xác nhận đã nhận đủ hàng tại kho đích? Tồn kho nhận sẽ được cộng và ghi Sổ Cái.')">
                                            @csrf
                                            <x-ui.button type="submit" variant="success" size="xs">
                                                ✓ Xác nhận nhập kho
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
                                    Chưa có phiếu chuyển kho nào. Bấm nút "Tạo Phiếu Chuyển Kho" để lập phiếu mới.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transfers->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                    {{ $transfers->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    <!-- Modal Tạo Phiếu Chuyển Kho Mới -->
    <x-ui.modal id="modal-create-transfer" title="🚚 Lập Phiếu Điều Chuyển Kho Liên Chi Nhánh" size="xl">
        <form method="POST" action="{{ route('admin.inventory.transfers.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kho xuất hàng (Nguồn) <span class="text-rose-500">*</span></label>
                    <select name="from_warehouse_id" required class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Chọn kho xuất chuyển đi --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kho tiếp nhận (Đích) <span class="text-rose-500">*</span></label>
                    <select name="to_warehouse_id" required class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Chọn kho đích tiếp nhận --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ghi chú điều chuyển</label>
                <input 
                    type="text" 
                    name="notes" 
                    placeholder="Biển số xe vận chuyển, lái xe, lý do điều chuyển hàng giữa các chi nhánh..." 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
            </div>

            <!-- Danh sách mặt hàng chuyển -->
            <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase text-slate-700 tracking-wider">Danh Sách Mặt Hàng Điều Chuyển</span>
                    <button type="button" onclick="addTransferItemRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        ➕ Thêm mặt hàng
                    </button>
                </div>

                <div id="transfer-items-container" class="space-y-2">
                    <div class="grid grid-cols-12 gap-2 items-center transfer-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs">
                        <div class="col-span-12 sm:col-span-8">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                            <input type="hidden" name="items[0][variant_id]" id="transfer_variant_id_0" required>
                            
                            <div class="variant-search-wrapper relative">
                                <div id="transfer_search_container_0" class="relative">
                                    <input 
                                        type="text" 
                                        id="transfer_search_input_0" 
                                        autocomplete="off"
                                        placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                        oninput="initVariantSearch(this, 0, 'transfer')"
                                        onfocus="initVariantSearch(this, 0, 'transfer')"
                                    >
                                </div>
                                <div id="transfer_selected_badge_0" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                                    <div class="truncate mr-2 font-medium">
                                        <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                                        <span class="stock-info ml-1 text-[11px]"></span>
                                    </div>
                                    <button type="button" onclick="changeVariant(0, 'transfer')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                        Đổi
                                    </button>
                                </div>
                                <div id="transfer_dropdown_0" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng</label>
                            <input 
                                type="number" 
                                name="items[0][quantity]" 
                                value="5" 
                                min="1" 
                                required 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                            >
                        </div>
                        <div class="col-span-6 sm:col-span-1 flex justify-end items-end pt-1 sm:pt-0">
                            <button type="button" onclick="removeTransferRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium py-1 px-2">
                                🗑
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tùy chọn xuất chuyển đi ngay -->
            <div class="flex items-center gap-2 pt-2 bg-sky-50/60 p-3 rounded-lg border border-sky-100">
                <input 
                    type="checkbox" 
                    name="dispatch_now" 
                    id="transfer_dispatch_now" 
                    value="1" 
                    checked 
                    class="rounded border-sky-300 text-sky-600 focus:ring-sky-500"
                >
                <label for="transfer_dispatch_now" class="text-xs font-semibold text-sky-900">
                    Xuất hàng vận chuyển đi ngay (Dispatched - Trừ tồn kho nguồn ngay)
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <x-ui.button type="button" variant="secondary" size="sm" onclick="closeModal('modal-create-transfer')">
                    Hủy bỏ
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="sm">
                    💾 Tạo Phiếu Chuyển Kho
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <script>
        let transferItemIndex = 1;
        let searchDebounceTimers = {};

        function openCreateTransferModal() {
            document.getElementById('modal-create-transfer').classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function initVariantSearch(inputEl, rowIndex, formType) {
            const query = inputEl.value.trim();
            const dropdown = document.getElementById(`${formType}_dropdown_${rowIndex}`);
            const warehouseSelect = document.querySelector(`#modal-create-${formType} select[name*="from_warehouse_id"]`) || document.querySelector(`#modal-create-${formType} select[name*="warehouse_id"]`);
            const warehouseId = warehouseSelect ? warehouseSelect.value : 0;

            clearTimeout(searchDebounceTimers[`${formType}_${rowIndex}`]);

            searchDebounceTimers[`${formType}_${rowIndex}`] = setTimeout(() => {
                dropdown.innerHTML = '<div class="p-3 text-center text-xs text-slate-400">⏳ Đang tìm kiếm sản phẩm...</div>';
                dropdown.classList.remove('hidden');

                fetch(`/quan-ly/kho/ajax/tim-kiem-san-pham?q=${encodeURIComponent(query)}&warehouse_id=${warehouseId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.results || data.results.length === 0) {
                            dropdown.innerHTML = '<div class="p-3 text-center text-xs text-slate-400">Không tìm thấy sản phẩm nào.</div>';
                            return;
                        }

                        let html = '';
                        data.results.forEach(item => {
                            const stock = item.stock || 0;
                            const stockBadge = warehouseId > 0 ? `<span class="text-[10px] px-1.5 py-0.5 rounded font-mono font-bold ${stock > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">Tồn kho nguồn: ${stock}</span>` : '';

                            const itemJson = JSON.stringify(item).replace(/"/g, '&quot;');
                            html += `
                                <div 
                                    class="p-2.5 hover:bg-emerald-50/70 cursor-pointer transition flex items-center justify-between text-xs border-b border-slate-100 last:border-b-0"
                                    onclick="selectVariant(${rowIndex}, '${formType}', ${itemJson})"
                                >
                                    <div class="min-w-0 pr-2">
                                        <div class="font-bold text-slate-800 truncate">${item.name}</div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <span class="font-mono text-emerald-700 bg-emerald-50 px-1 rounded">[${item.sku}]</span>
                                            <span>${item.specification || ''}</span>
                                            ${item.active_ingredient ? `<span class="text-slate-400">(${item.active_ingredient})</span>` : ''}
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        ${stockBadge}
                                    </div>
                                </div>
                            `;
                        });
                        dropdown.innerHTML = html;
                    })
                    .catch(() => {
                        dropdown.innerHTML = '<div class="p-3 text-center text-xs text-rose-500">Lỗi khi tải danh sách sản phẩm.</div>';
                    });
            }, 180);
        }

        function selectVariant(rowIndex, formType, item) {
            document.getElementById(`${formType}_variant_id_${rowIndex}`).value = item.id;
            
            const searchContainer = document.getElementById(`${formType}_search_container_${rowIndex}`);
            const selectedBadge = document.getElementById(`${formType}_selected_badge_${rowIndex}`);
            
            selectedBadge.querySelector('.selected-name').textContent = item.name + ' - ' + (item.specification || '');
            selectedBadge.querySelector('.selected-sku').textContent = `[${item.sku}]`;
            
            const stockInfo = selectedBadge.querySelector('.stock-info');
            if (stockInfo && item.stock !== undefined) {
                stockInfo.innerHTML = `<b class="${item.stock > 0 ? 'text-emerald-700' : 'text-rose-600'}">(Tồn: ${item.stock})</b>`;
            }

            searchContainer.classList.add('hidden');
            selectedBadge.classList.remove('hidden');
            selectedBadge.classList.add('flex');

            document.getElementById(`${formType}_dropdown_${rowIndex}`).classList.add('hidden');
        }

        function changeVariant(rowIndex, formType) {
            document.getElementById(`${formType}_variant_id_${rowIndex}`).value = '';
            
            const searchContainer = document.getElementById(`${formType}_search_container_${rowIndex}`);
            const selectedBadge = document.getElementById(`${formType}_selected_badge_${rowIndex}`);
            
            selectedBadge.classList.add('hidden');
            selectedBadge.classList.remove('flex');
            searchContainer.classList.remove('hidden');
            
            const input = document.getElementById(`${formType}_search_input_${rowIndex}`);
            input.value = '';
            input.focus();
            initVariantSearch(input, rowIndex, formType);
        }

        function addTransferItemRow() {
            const container = document.getElementById('transfer-items-container');
            const row = document.createElement('div');
            const currentIndex = transferItemIndex;
            row.className = 'grid grid-cols-12 gap-2 items-center transfer-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs';
            row.innerHTML = `
                <div class="col-span-12 sm:col-span-8">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                    <input type="hidden" name="items[${currentIndex}][variant_id]" id="transfer_variant_id_${currentIndex}" required>
                    
                    <div class="variant-search-wrapper relative">
                        <div id="transfer_search_container_${currentIndex}" class="relative">
                            <input 
                                type="text" 
                                id="transfer_search_input_${currentIndex}" 
                                autocomplete="off"
                                placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                oninput="initVariantSearch(this, ${currentIndex}, 'transfer')"
                                onfocus="initVariantSearch(this, ${currentIndex}, 'transfer')"
                            >
                        </div>
                        <div id="transfer_selected_badge_${currentIndex}" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                            <div class="truncate mr-2 font-medium">
                                <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                                <span class="stock-info ml-1 text-[11px]"></span>
                            </div>
                            <button type="button" onclick="changeVariant(${currentIndex}, 'transfer')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                Đổi
                            </button>
                        </div>
                        <div id="transfer_dropdown_${currentIndex}" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng</label>
                    <input 
                        type="number" 
                        name="items[${currentIndex}][quantity]" 
                        value="5" 
                        min="1" 
                        required 
                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                    >
                </div>
                <div class="col-span-6 sm:col-span-1 flex justify-end items-end pt-1 sm:pt-0">
                    <button type="button" onclick="removeTransferRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium py-1 px-2">
                        🗑
                    </button>
                </div>
            `;
            container.appendChild(row);
            transferItemIndex++;
        }

        function removeTransferRow(button) {
            const rows = document.querySelectorAll('.transfer-item-row');
            if (rows.length > 1) {
                button.closest('.transfer-item-row').remove();
            } else {
                alert('Phiếu chuyển kho phải có ít nhất 1 mặt hàng!');
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.variant-search-wrapper')) {
                document.querySelectorAll('.variant-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });
    </script>
</x-layouts.app>
