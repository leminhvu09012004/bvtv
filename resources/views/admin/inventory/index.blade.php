<x-layouts.app title="Quản Lý Tồn Kho Đa Điểm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản trị</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Kho vận</span>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Tồn kho đa điểm</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>🏢</span> Quản Lý Tồn Kho Đa Chi Nhánh
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Theo dõi số lượng tồn thực tế, hàng đang giữ và điểm đặt hàng lại theo từng vị trí kho.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.movements') }}" variant="secondary" size="sm">
                    📜 Sổ cái biến động kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.transfers') }}" variant="secondary" size="sm">
                    🚚 Chuyển kho nội bộ
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.receipts') }}" variant="secondary" size="sm">
                    📥 Nhập kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.issues') }}" variant="secondary" size="sm">
                    📤 Xuất kho
                </x-ui.button>
                <x-ui.button href="{{ route('admin.inventory.counts') }}" variant="secondary" size="sm">
                    📋 Kiểm kê kho
                </x-ui.button>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.card :padding="true">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tổng sản phẩm tồn</p>
                        <p id="kpi-total-items" class="text-2xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ number_format($totalItems) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        📦
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :padding="true">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cảnh báo sắp hết</p>
                        <p id="kpi-low-stock" class="text-2xl font-extrabold text-amber-600 mt-1 tabular-nums">{{ number_format($lowStockCount) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                        ⚠️
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :padding="true">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kho đang hoạt động</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ $warehouses->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                        🏬
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :padding="true">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mã sản phẩm / SKU</p>
                        <p id="kpi-total-skus" class="text-2xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ number_format($totalSkuCount) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                        🏷️
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Filter & Search Toolbar (AJAX Live Filter) -->
        <x-ui.card :padding="true">
            <form id="inventory-filter-form" method="GET" action="{{ route('admin.inventory.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <div class="sm:col-span-5 relative">
                    <x-ui.input 
                        id="filter-q"
                        label="Tìm kiếm theo Tên, SKU, Barcode, Hoạt chất" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Nhập từ khóa tìm kiếm..." 
                    />
                    <div id="filter-spinner" class="hidden absolute right-3 top-8 text-xs text-emerald-600 animate-spin">
                        ⏳
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lọc theo kho</label>
                    <select id="filter-warehouse" name="warehouse_id" class="w-full rounded-xl text-sm border border-slate-300 py-2.5 px-3 bg-white text-slate-800 focus:outline-hidden focus:border-emerald-500">
                        <option value="">-- Tất cả các kho --</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->name }} ({{ $w->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer pb-2 text-xs font-medium text-slate-700">
                        <input id="filter-low-stock" type="checkbox" name="low_stock" value="1" {{ request('low_stock') === '1' ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span>Chỉ hàng chạm đáy tồn</span>
                    </label>
                </div>

                <div class="sm:col-span-2 flex gap-2">
                    <x-ui.button type="submit" variant="primary" size="md" class="w-full">
                        Lọc dữ liệu
                    </x-ui.button>
                    <a id="filter-reset-btn" href="{{ route('admin.inventory.index') }}" class="px-3 py-2 text-xs rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center transition" title="Đặt lại bộ lọc">
                        Đặt lại
                    </a>
                </div>
            </form>
        </x-ui.card>

        <!-- Inventory Data Table Container -->
        <x-ui.card :padding="false">
            <div id="inventory-table-container" class="relative">
                @include('admin.inventory.partials.table', ['inventories' => $inventories])
            </div>
        </x-ui.card>
    </div>

    <!-- Client-side AJAX Live Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('inventory-filter-form');
            const inputQ = document.getElementById('filter-q');
            const selectWarehouse = document.getElementById('filter-warehouse');
            const checkLowStock = document.getElementById('filter-low-stock');
            const tableContainer = document.getElementById('inventory-table-container');
            const spinner = document.getElementById('filter-spinner');
            const resetBtn = document.getElementById('filter-reset-btn');

            const kpiTotalItems = document.getElementById('kpi-total-items');
            const kpiLowStock = document.getElementById('kpi-low-stock');
            const kpiTotalSkus = document.getElementById('kpi-total-skus');

            let debounceTimer = null;
            let currentAbortController = null;

            async function fetchInventory(url = null) {
                if (currentAbortController) {
                    currentAbortController.abort();
                }
                currentAbortController = new AbortController();

                const formData = new FormData(form);
                const params = new URLSearchParams(formData);

                let requestUrl;
                if (url) {
                    const parsedUrl = new URL(url, window.location.origin);
                    for (const [key, value] of formData.entries()) {
                        if (value && !parsedUrl.searchParams.has(key)) {
                            parsedUrl.searchParams.set(key, value);
                        }
                    }
                    requestUrl = parsedUrl.toString();
                } else {
                    requestUrl = `${form.action}?${params.toString()}`;
                }

                if (spinner) spinner.classList.remove('hidden');
                tableContainer.classList.add('opacity-50');

                try {
                    const response = await fetch(requestUrl, {
                        signal: currentAbortController.signal,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success && data.html) {
                        tableContainer.innerHTML = data.html;

                        if (data.stats) {
                            if (kpiTotalItems) kpiTotalItems.textContent = data.stats.totalItems;
                            if (kpiLowStock) kpiLowStock.textContent = data.stats.lowStockCount;
                            if (kpiTotalSkus) kpiTotalSkus.textContent = data.stats.totalSkuCount;
                        }

                        // Cập nhật URL trên thanh địa chỉ không reload trang
                        window.history.replaceState({}, '', requestUrl);
                    }
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        console.error('Lỗi tải dữ liệu tồn kho:', err);
                    }
                } finally {
                    if (spinner) spinner.classList.add('hidden');
                    tableContainer.classList.remove('opacity-50');
                }
            }

            // Live search với debounce 300ms
            inputQ?.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fetchInventory(), 300);
            });

            selectWarehouse?.addEventListener('change', () => fetchInventory());
            checkLowStock?.addEventListener('change', () => fetchInventory());

            form?.addEventListener('submit', function (e) {
                e.preventDefault();
                fetchInventory();
            });

            resetBtn?.addEventListener('click', function (e) {
                e.preventDefault();
                if (inputQ) inputQ.value = '';
                if (selectWarehouse) selectWarehouse.value = '';
                if (checkLowStock) checkLowStock.checked = false;
                fetchInventory(form.action);
            });

            // Bắt sự kiện click phân trang để load AJAX
            document.addEventListener('click', function (e) {
                const pageLink = e.target.closest('.inventory-pagination a');
                if (pageLink && pageLink.href) {
                    e.preventDefault();
                    fetchInventory(pageLink.href);
                }
            });
        });
    </script>
</x-layouts.app>
