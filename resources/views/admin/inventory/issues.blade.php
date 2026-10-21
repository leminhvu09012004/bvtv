<x-layouts.app title="Phiếu Xuất Kho Hàng Hóa">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Xuất kho</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📤</span> Phiếu Xuất Kho Hàng Hóa (Stock Issues)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Quản lý các chứng từ xuất kho: xuất hủy hàng hỏng/hết hạn, trả nhà cung cấp, xuất dùng nội bộ, hàng mẫu.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    🏢 Quay lại kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.receipts') }}" variant="secondary" size="sm">
                    📥 Nhập kho
                </x-ui.button>
                <x-ui.button type="button" variant="primary" size="sm" onclick="openCreateIssueModal()">
                    ➕ Tạo Phiếu Xuất Kho
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

        <!-- Filter Bar -->
        <x-ui.card>
            <form method="GET" action="{{ route('admin.inventory.issues') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kho xuất hàng</label>
                    <select name="warehouse_id" class="w-full text-xs rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">-- Tất cả kho --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}" {{ request('warehouse_id') == $wh->id ? 'selected' : '' }}>
                                {{ $wh->name }} ({{ $wh->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Lý do xuất</label>
                    <select name="reason" class="w-full text-xs rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">-- Tất cả lý do --</option>
                        <option value="damage_writeoff" {{ request('reason') == 'damage_writeoff' ? 'selected' : '' }}>Hao hụt / Xuất hủy</option>
                        <option value="supplier_return" {{ request('reason') == 'supplier_return' ? 'selected' : '' }}>Trả hàng nhà phân phối</option>
                        <option value="internal_use" {{ request('reason') == 'internal_use' ? 'selected' : '' }}>Sử dụng nội bộ</option>
                        <option value="sample" {{ request('reason') == 'sample' ? 'selected' : '' }}>Hàng mẫu thử nghiệm</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Trạng thái phiếu</label>
                    <select name="status" class="w-full text-xs rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt xuất</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <x-ui.button type="submit" variant="secondary" size="sm" class="w-full justify-center">
                        🔍 Lọc dữ liệu
                    </x-ui.button>
                    @if(request()->hasAny(['warehouse_id', 'reason', 'status']))
                        <x-ui.button href="{{ route('admin.inventory.issues') }}" variant="neutral" size="sm">
                            ✕ Xóa lọc
                        </x-ui.button>
                    @endif
                </div>
            </form>
        </x-ui.card>

        <!-- Table Danh Sách Xuất Kho -->
        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Mã chứng từ</th>
                            <th class="px-5 py-3.5">Kho xuất hàng</th>
                            <th class="px-5 py-3.5">Lý do xuất</th>
                            <th class="px-5 py-3.5">Sản phẩm xuất</th>
                            <th class="px-5 py-3.5 text-center">Trạng thái</th>
                            <th class="px-5 py-3.5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($issues as $issue)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="font-mono text-xs font-bold text-slate-800">{{ $issue->issue_code }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $issue->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="text-[11px] text-slate-500">Người lập: {{ $issue->creator->name ?? 'Admin' }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs">{{ $issue->warehouse->name }}</span>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $issue->warehouse->code }}</div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @php
                                        $reasonData = match($issue->reason) {
                                            'damage_writeoff' => ['label' => '🗑 Xuất hủy hàng hỏng', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'],
                                            'supplier_return' => ['label' => '↩ Trả hàng NCC', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                            'internal_use'    => ['label' => '🏢 Dùng nội bộ', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                            'sample'          => ['label' => '🧪 Mẫu thử nghiệm', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
                                            default           => ['label' => $issue->reason, 'class' => 'bg-slate-50 text-slate-700 border-slate-200'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold border {{ $reasonData['class'] }}">
                                        {{ $reasonData['label'] }}
                                    </span>
                                    @if($issue->notes)
                                        <div class="text-[11px] text-slate-500 italic mt-1 line-clamp-1" title="{{ $issue->notes }}">
                                            "{{ $issue->notes }}"
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="space-y-1 max-w-xs">
                                        @foreach($issue->items as $item)
                                            <div class="text-xs flex items-center justify-between text-slate-800 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                                <div class="truncate mr-2 font-medium" title="{{ $item->variant->pesticide->name ?? 'Sản phẩm' }}">
                                                    {{ $item->variant->pesticide->name ?? 'SKU #' . $item->variant_id }}
                                                    <span class="text-[11px] text-slate-400 font-mono">({{ $item->variant->specification ?? '' }})</span>
                                                </div>
                                                <span class="font-bold text-rose-600 whitespace-nowrap tabular-nums">-{{ $item->quantity }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @php
                                        $st = match($issue->status) {
                                            'draft'     => ['variant' => 'neutral', 'label' => 'Bản nháp'],
                                            'approved'  => ['variant' => 'compatible', 'label' => '✓ Đã xuất kho'],
                                            'cancelled' => ['variant' => 'forbidden', 'label' => 'Đã hủy'],
                                            default     => ['variant' => 'neutral', 'label' => $issue->status],
                                        };
                                    @endphp
                                    <x-ui.badge :variant="$st['variant']" size="xs">
                                        {{ $st['label'] }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a 
                                            href="{{ route('admin.inventory.issues.print', $issue) }}" 
                                            target="_blank"
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300 transition"
                                            title="In phiếu xuất kho A4"
                                        >
                                            🖨️ In phiếu
                                        </a>

                                        @if($issue->status === 'draft')
                                            <form method="POST" action="{{ route('admin.inventory.issues.approve', $issue) }}" class="inline" onsubmit="return confirm('Xác nhận phê duyệt xuất kho? Thao tác này sẽ ghi sổ cái và trừ trực tiếp số lượng tồn kho!')">
                                                @csrf
                                                <x-ui.button type="submit" variant="primary" size="xs">
                                                    ✓ Duyệt xuất
                                                </x-ui.button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">Đã chốt sổ</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-xs">
                                    Chưa có phiếu xuất kho nào. Bấm nút "Tạo Phiếu Xuất Kho" để lập phiếu mới.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($issues->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                    {{ $issues->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    <!-- Modal Tạo Phiếu Xuất Kho Mới -->
    <x-ui.modal id="modal-create-issue" title="📤 Lập Phiếu Xuất Kho Hàng Hóa Mới" size="xl">
        <form method="POST" action="{{ route('admin.inventory.issues.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kho xuất hàng <span class="text-rose-500">*</span></label>
                    <select name="warehouse_id" required class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Chọn chi nhánh xuất kho --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lý do xuất kho <span class="text-rose-500">*</span></label>
                    <select name="reason" required class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="damage_writeoff">Xuất hủy hàng hỏng / hết hạn sử dụng</option>
                        <option value="supplier_return">Xuất trả hàng nhà phân phối / nhà sản xuất</option>
                        <option value="internal_use">Xuất dùng nội bộ tại trang trại / cửa hàng</option>
                        <option value="sample">Xuất làm hàng mẫu thử nghiệm kỹ thuật</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ghi chú chứng từ</label>
                <input 
                    type="text" 
                    name="notes" 
                    placeholder="Lý do cụ thể, biên bản kiểm định, số hóa đơn liên quan..." 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
            </div>

            <!-- Danh sách mặt hàng xuất -->
            <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase text-slate-700 tracking-wider">Danh Sách Mặt Hàng Xuất Kho</span>
                    <button type="button" onclick="addIssueItemRow()" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        ➕ Thêm mặt hàng
                    </button>
                </div>

                <div id="issue-items-container" class="space-y-2">
                    <div class="grid grid-cols-12 gap-2 items-center issue-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs">
                        <div class="col-span-12 sm:col-span-7">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                            <input type="hidden" name="items[0][variant_id]" id="issue_variant_id_0" required>
                            
                            <div class="variant-search-wrapper relative">
                                <div id="issue_search_container_0" class="relative">
                                    <input 
                                        type="text" 
                                        id="issue_search_input_0" 
                                        autocomplete="off"
                                        placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                        oninput="initVariantSearch(this, 0, 'issue')"
                                        onfocus="initVariantSearch(this, 0, 'issue')"
                                    >
                                </div>
                                <div id="issue_selected_badge_0" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                                    <div class="truncate mr-2 font-medium">
                                        <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                                        <span class="stock-info ml-1 text-[11px]"></span>
                                    </div>
                                    <button type="button" onclick="changeVariant(0, 'issue')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                        Đổi
                                    </button>
                                </div>
                                <div id="issue_dropdown_0" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng xuất</label>
                            <input 
                                type="number" 
                                name="items[0][quantity]" 
                                value="1" 
                                min="1" 
                                required 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                            >
                        </div>
                        <div class="col-span-6 sm:col-span-2 flex justify-end items-end pt-1 sm:pt-0">
                            <button type="button" onclick="removeIssueRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium py-1 px-2">
                                🗑 Xóa
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
                    id="issue_approve_now" 
                    value="1" 
                    checked 
                    class="rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="issue_approve_now" class="text-xs font-semibold text-emerald-900">
                    Phê duyệt và trừ tồn kho ngay vào Sổ Cái (Khuyên dùng)
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <x-ui.button type="button" variant="secondary" size="sm" onclick="closeModal('modal-create-issue')">
                    Hủy bỏ
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="sm">
                    💾 Tạo Phiếu Xuất Kho
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <script>
        let issueItemIndex = 1;
        let searchDebounceTimers = {};

        function openCreateIssueModal() {
            document.getElementById('modal-create-issue').classList.remove('hidden');
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
                            const stock = item.stock || 0;
                            const stockBadge = `<span class="text-[10px] px-1.5 py-0.5 rounded font-mono font-bold ${stock > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'}">Tồn: ${stock}</span>`;

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
            if (stockInfo) {
                stockInfo.innerHTML = `<b class="${item.stock > 0 ? 'text-emerald-700' : 'text-rose-600'}">(Tồn kho: ${item.stock})</b>`;
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

        function addIssueItemRow() {
            const container = document.getElementById('issue-items-container');
            const row = document.createElement('div');
            const currentIndex = issueItemIndex;
            row.className = 'grid grid-cols-12 gap-2 items-center issue-item-row bg-white p-2.5 rounded-lg border border-slate-200 shadow-2xs';
            row.innerHTML = `
                <div class="col-span-12 sm:col-span-7">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Sản phẩm / Biến thể <span class="text-rose-500">*</span></label>
                    <input type="hidden" name="items[${currentIndex}][variant_id]" id="issue_variant_id_${currentIndex}" required>
                    
                    <div class="variant-search-wrapper relative">
                        <div id="issue_search_container_${currentIndex}" class="relative">
                            <input 
                                type="text" 
                                id="issue_search_input_${currentIndex}" 
                                autocomplete="off"
                                placeholder="🔍 Gõ tên thuốc, hoạt chất, SKU để tìm..." 
                                class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-2xs py-1.5 px-2.5"
                                oninput="initVariantSearch(this, ${currentIndex}, 'issue')"
                                onfocus="initVariantSearch(this, ${currentIndex}, 'issue')"
                            >
                        </div>
                        <div id="issue_selected_badge_${currentIndex}" class="hidden items-center justify-between p-1.5 rounded-md bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                            <div class="truncate mr-2 font-medium">
                                <b class="selected-name"></b> <span class="text-[10px] text-emerald-700 font-mono selected-sku"></span>
                                <span class="stock-info ml-1 text-[11px]"></span>
                            </div>
                            <button type="button" onclick="changeVariant(${currentIndex}, 'issue')" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold shrink-0">
                                Đổi
                            </button>
                        </div>
                        <div id="issue_dropdown_${currentIndex}" class="variant-dropdown absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-56 overflow-y-auto hidden divide-y divide-slate-100"></div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label class="block text-[11px] font-medium text-slate-500 mb-0.5">Số lượng xuất</label>
                    <input 
                        type="number" 
                        name="items[${currentIndex}][quantity]" 
                        value="1" 
                        min="1" 
                        required 
                        class="w-full text-xs rounded-md border-slate-300 focus:border-emerald-500 shadow-2xs"
                    >
                </div>
                <div class="col-span-6 sm:col-span-2 flex justify-end items-end pt-1 sm:pt-0">
                    <button type="button" onclick="removeIssueRow(this)" class="text-xs text-rose-500 hover:text-rose-700 font-medium py-1 px-2">
                        🗑 Xóa
                    </button>
                </div>
            `;
            container.appendChild(row);
            issueItemIndex++;
        }

        function removeIssueRow(button) {
            const rows = document.querySelectorAll('.issue-item-row');
            if (rows.length > 1) {
                button.closest('.issue-item-row').remove();
            } else {
                alert('Phiếu xuất kho phải có ít nhất 1 mặt hàng!');
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.variant-search-wrapper')) {
                document.querySelectorAll('.variant-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });
    </script>
</x-layouts.app>
