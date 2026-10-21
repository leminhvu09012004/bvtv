<x-layouts.app title="Phiếu Nhập Hàng Từ Nhà Cung Cấp">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Nhập kho</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📥</span> Phiếu Nhập Hàng Nhà Cung Cấp (Purchase Receipts)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Quản lý chứng từ nhập kho từ nhà phân phối; khi phê duyệt sẽ tự động tăng tồn kho và ghi sổ cái bất biến.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    🏢 Quay lại kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.issues') }}" variant="secondary" size="sm">
                    📤 Xuất kho
                </x-ui.button>
                <x-ui.button type="button" variant="primary" size="sm" onclick="openCreateReceiptModal()">
                    ➕ Lập Phiếu Nhập Hàng
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

        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Mã phiếu</th>
                            <th class="px-5 py-3.5">Kho nhập</th>
                            <th class="px-5 py-3.5">Ghi chú / Chứng từ</th>
                            <th class="px-5 py-3.5 text-right">Tổng tiền</th>
                            <th class="px-5 py-3.5 text-center">Trạng thái</th>
                            <th class="px-5 py-3.5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($receipts as $rc)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="font-mono text-xs font-bold text-slate-800">{{ $rc->receipt_code }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $rc->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs">{{ $rc->warehouse->name }}</span>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $rc->warehouse->code }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs font-medium text-slate-700">
                                    {{ $rc->notes ?: 'Nhập kho hàng hóa' }}
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap font-bold text-slate-900 tabular-nums">
                                    {{ number_format($rc->total_amount ?? $rc->total_cost ?? 0) }} ₫
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap status-badge-cell">
                                    @php
                                        $st = match($rc->status) {
                                            'draft' => ['variant' => 'neutral', 'label' => 'Bản nháp'],
                                            'approved' => ['variant' => 'compatible', 'label' => '✓ Đã duyệt nhập kho'],
                                            'cancelled' => ['variant' => 'forbidden', 'label' => 'Đã hủy'],
                                            default => ['variant' => 'neutral', 'label' => $rc->status],
                                        };
                                    @endphp
                                    <x-ui.badge :variant="$st['variant']" size="xs">
                                        {{ $st['label'] }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    @if($rc->status === 'draft')
                                        <form method="POST" action="{{ route('admin.inventory.receipts.approve', $rc) }}" class="inline" onsubmit="return confirm('Xác nhận duyệt nhập kho? Tồn kho thực tế sẽ được tăng lên và ghi vào Sổ Cái.')">
                                            @csrf
                                            <x-ui.button type="submit" variant="primary" size="xs">
                                                ✓ Duyệt nhập kho
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
                                    Chưa có phiếu nhập hàng nào. Bấm nút "Lập Phiếu Nhập Hàng" để tạo phiếu mới.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($receipts->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                    {{ $receipts->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    <!-- Modal Tạo Phiếu Nhập Hàng Mới -->
    <x-ui.modal id="modal-create-receipt" title="📥 Lập Phiếu Nhập Hàng Hóa" size="xl">
        <form method="POST" action="{{ route('admin.inventory.receipts.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kho nhập hàng <span class="text-rose-500">*</span></label>
                    <select name="warehouse_id" required class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Chọn chi nhánh nhận hàng --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ghi chú chứng từ nhập</label>
                    <input 
                        type="text" 
                        name="notes" 
                        placeholder="Số hóa đơn VAT, chứng từ hoặc ghi chú nhập kho..." 
                        class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                    >
                </div>
            </div>

            <!-- Danh sách mặt hàng nhập -->
            <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase text-slate-700 tracking-wider">Danh Sách Mặt Hàng Nhập Kho</span>
                    <button type="button" onclick="addReceiptItemRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        ➕ Thêm mặt hàng
                    </button>
                </div>

                <div id="receipt-items-container" class="space-y-2">
                    <div class="grid grid-cols-12 gap-2 items-center receipt-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs">
                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                            <input type="hidden" name="items[0][variant_id]" id="receipt_variant_id_0" required>
                            
                            <div class="variant-search-wrapper relative">
                                <div id="receipt_search_container_0" class="relative">
                                    <input 
                                        type="text" 
                                        id="receipt_search_input_0" 
                                        autocomplete="off"
                                        placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                        oninput="initVariantSearch(this, 0, 'receipt')"
                                        onfocus="initVariantSearch(this, 0, 'receipt')"
                                    >
                                </div>
                                <div id="receipt_selected_badge_0" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                                    <div class="truncate mr-2 font-medium">
                                        <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                                    </div>
                                    <button type="button" onclick="changeVariant(0, 'receipt')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                        Đổi
                                    </button>
                                </div>
                                <div id="receipt_dropdown_0" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                            </div>
                        </div>
                        <div class="col-span-5 sm:col-span-2">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng</label>
                            <input 
                                type="number" 
                                name="items[0][quantity]" 
                                value="10" 
                                min="1" 
                                required 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                            >
                        </div>
                        <div class="col-span-5 sm:col-span-3">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Đơn giá nhập (₫)</label>
                            <input 
                                type="number" 
                                name="items[0][unit_cost]" 
                                id="receipt_cost_0"
                                value="0" 
                                min="0" 
                                step="1000"
                                required 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                            >
                        </div>
                        <div class="col-span-2 sm:col-span-1 flex justify-end items-end pt-1 sm:pt-0">
                            <button type="button" onclick="removeReceiptRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium">
                                🗑
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tùy chọn duyệt ngay -->
            <div class="flex items-center gap-2 pt-2 bg-emerald-50/60 p-3 rounded-lg border border-emerald-100">
                <input 
                    type="checkbox" 
                    name="approve_now" 
                    id="receipt_approve_now" 
                    value="1" 
                    checked 
                    class="rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="receipt_approve_now" class="text-xs font-semibold text-emerald-900">
                    Phê duyệt và tăng tồn kho ngay vào Sổ Cái (Khuyên dùng)
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <x-ui.button type="button" variant="secondary" size="sm" onclick="closeModal('modal-create-receipt')">
                    Hủy bỏ
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="sm">
                    💾 Tạo Phiếu Nhập Hàng
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <script>
        let receiptItemIndex = 1;
        let searchDebounceTimers = {};

        function openCreateReceiptModal() {
            document.getElementById('modal-create-receipt').classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function initVariantSearch(inputEl, rowIndex, formType) {
            const query = inputEl.value.trim();
            const dropdown = document.getElementById(`${formType}_dropdown_${rowIndex}`);
            const warehouseSelect = document.querySelector(`#modal-create-${formType} select[name*="warehouse_id"]`);
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
                            const costPrice = item.cost_price || 0;
                            const costText = `<span class="text-[10px] text-slate-500 font-mono">Giá vốn: ${new Intl.NumberFormat().format(costPrice)} ₫</span>`;

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
                                        ${costText}
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
            
            searchContainer.classList.add('hidden');
            selectedBadge.classList.remove('hidden');
            selectedBadge.classList.add('flex');
            
            const costInput = document.getElementById(`receipt_cost_${rowIndex}`);
            if (costInput && (!costInput.value || costInput.value == '0')) {
                costInput.value = item.cost_price || 0;
            }

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

        function addReceiptItemRow() {
            const container = document.getElementById('receipt-items-container');
            const row = document.createElement('div');
            const currentIndex = receiptItemIndex;
            row.className = 'grid grid-cols-12 gap-2 items-center receipt-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs';
            row.innerHTML = `
                <div class="col-span-12 sm:col-span-6">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                    <input type="hidden" name="items[${currentIndex}][variant_id]" id="receipt_variant_id_${currentIndex}" required>
                    
                    <div class="variant-search-wrapper relative">
                        <div id="receipt_search_container_${currentIndex}" class="relative">
                            <input 
                                type="text" 
                                id="receipt_search_input_${currentIndex}" 
                                autocomplete="off"
                                placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                oninput="initVariantSearch(this, ${currentIndex}, 'receipt')"
                                onfocus="initVariantSearch(this, ${currentIndex}, 'receipt')"
                            >
                        </div>
                        <div id="receipt_selected_badge_${currentIndex}" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                            <div class="truncate mr-2 font-medium">
                                <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                            </div>
                            <button type="button" onclick="changeVariant(${currentIndex}, 'receipt')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                Đổi
                            </button>
                        </div>
                        <div id="receipt_dropdown_${currentIndex}" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                    </div>
                </div>
                <div class="col-span-5 sm:col-span-2">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng</label>
                    <input 
                        type="number" 
                        name="items[${currentIndex}][quantity]" 
                        value="10" 
                        min="1" 
                        required 
                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                    >
                </div>
                <div class="col-span-5 sm:col-span-3">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Đơn giá nhập (₫)</label>
                    <input 
                        type="number" 
                        name="items[${currentIndex}][unit_cost]" 
                        id="receipt_cost_${currentIndex}"
                        value="0" 
                        min="0" 
                        step="1000"
                        required 
                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                    >
                </div>
                <div class="col-span-2 sm:col-span-1 flex justify-end items-end pt-1 sm:pt-0">
                    <button type="button" onclick="removeReceiptRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium">
                        🗑
                    </button>
                </div>
            `;
            container.appendChild(row);
            receiptItemIndex++;
        }

        function removeReceiptRow(button) {
            const rows = document.querySelectorAll('.receipt-item-row');
            if (rows.length > 1) {
                button.closest('.receipt-item-row').remove();
            } else {
                alert('Phiếu nhập kho phải có ít nhất 1 mặt hàng!');
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.variant-search-wrapper')) {
                document.querySelectorAll('.variant-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });
    </script>
</x-layouts.app>
