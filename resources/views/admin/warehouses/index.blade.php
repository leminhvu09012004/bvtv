<x-layouts.app title="Quản Lý Chi Nhánh / Kho Hàng">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('admin.inventory.index') }}" class="hover:text-emerald-600">Quản lý kho</a>
                    <span>/</span>
                    <span class="text-emerald-700 font-semibold">Chi nhánh</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                    <span>🏢</span> Quản Lý Chi Nhánh & Kho Hàng (Warehouses)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Thiết lập danh sách chi nhánh, kho chứa đa điểm trong chuỗi cung ứng vật tư nông nghiệp Tây Nguyên.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.inventory.index') }}" variant="secondary" size="sm">
                    📦 Xem Tồn Kho
                </x-ui.button>
                <x-ui.button type="button" variant="primary" size="sm" onclick="openCreateModal()">
                    ➕ Thêm Chi Nhánh Mới
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

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-ui.card>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">Tổng số chi nhánh</div>
                        <div class="text-2xl font-black text-slate-800 mt-1">{{ $totalWarehouses }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                        🏢
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">Đang hoạt động</div>
                        <div class="text-2xl font-black text-emerald-600 mt-1">{{ $activeWarehouses }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold">
                        ✓
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-medium text-slate-500 uppercase tracking-wider">Tổng hàng lưu kho</div>
                        <div class="text-2xl font-black text-indigo-600 mt-1">{{ number_format($totalStockAll) }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold">
                        📦
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Table Warehouses -->
        <x-ui.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Mã kho</th>
                            <th class="px-5 py-3.5">Tên chi nhánh / Kho</th>
                            <th class="px-5 py-3.5">Địa chỉ & Liên hệ</th>
                            <th class="px-5 py-3.5 text-center">SKU / Tồn kho</th>
                            <th class="px-5 py-3.5 text-center">Trạng thái</th>
                            <th class="px-5 py-3.5 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-normal">
                        @forelse($warehouses as $wh)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ $wh->code }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                                        {{ $wh->name }}
                                        @if($wh->is_active)
                                            <span class="w-2 h-2 rounded-full bg-emerald-500" title="Hoạt động"></span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-slate-300" title="Tạm dừng"></span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">Khởi tạo: {{ $wh->created_at ? $wh->created_at->format('d/m/Y') : 'Hệ thống' }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="text-xs text-slate-700 font-medium line-clamp-1">
                                        {{ $wh->address ?: 'Chưa cập nhật địa chỉ' }}
                                    </div>
                                    @if($wh->phone)
                                        <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1 font-mono">
                                            <span>📞</span> {{ $wh->phone }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    <div class="text-xs font-bold text-slate-800">
                                        {{ number_format($wh->total_stock ?? 0) }} <span class="font-normal text-slate-500">sp</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">
                                        ({{ $wh->inventories_count ?? 0 }} mặt hàng)
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                    @if($wh->is_active)
                                        <x-ui.badge variant="compatible" size="xs">
                                            ✓ Đang hoạt động
                                        </x-ui.badge>
                                    @else
                                        <x-ui.badge variant="neutral" size="xs">
                                            ⏸ Tạm dừng
                                        </x-ui.badge>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Nút Sửa -->
                                        <x-ui.button 
                                            type="button" 
                                            variant="secondary" 
                                            size="xs"
                                            onclick="openEditModal({{ json_encode([
                                                'id' => $wh->id,
                                                'name' => $wh->name,
                                                'code' => $wh->code,
                                                'address' => $wh->address,
                                                'phone' => $wh->phone,
                                                'is_active' => (bool)$wh->is_active,
                                            ]) }})"
                                        >
                                            ✏️ Sửa
                                        </x-ui.button>

                                        <!-- Toggle Bật/Tắt -->
                                        <form method="POST" action="{{ route('admin.warehouses.toggle', $wh) }}" class="inline">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="px-2 py-1 text-xs rounded font-medium transition {{ $wh->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}"
                                                title="{{ $wh->is_active ? 'Tạm dừng hoạt động' : 'Kích hoạt lại' }}"
                                            >
                                                {{ $wh->is_active ? '⏸ Tạm dừng' : '▶ Kích hoạt' }}
                                            </button>
                                        </form>

                                        <!-- Xóa -->
                                        <form method="POST" action="{{ route('admin.warehouses.destroy', $wh) }}" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chi nhánh [{{ $wh->name }}]? Hệ thống sẽ bảo vệ dữ liệu nếu đã có tồn kho.')">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="px-2 py-1 text-xs text-rose-600 hover:bg-rose-50 rounded font-medium border border-rose-200 transition"
                                                title="Xóa chi nhánh"
                                            >
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-xs">
                                    Chưa có chi nhánh / kho hàng nào trên hệ thống.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    </div>

    <!-- Modal Thêm Chi Nhánh Mới -->
    <x-ui.modal id="modal-create-warehouse" title="➕ Thêm Chi Nhánh / Kho Hàng Mới" size="md">
        <form method="POST" action="{{ route('admin.warehouses.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tên chi nhánh / Kho <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    required 
                    placeholder="Ví dụ: Kho Tổng Buôn Ma Thuột, Đại lý Krông Pắc..." 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mã chi nhánh (Code)</label>
                <input 
                    type="text" 
                    name="code" 
                    placeholder="Ví dụ: KHO-BMT, KHO-DL1 (để trống tự sinh)" 
                    class="w-full text-sm font-mono uppercase rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
                <p class="text-[11px] text-slate-400 mt-0.5">Mã duy nhất dùng trong chứng từ sổ cái kho.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại liên hệ</label>
                <input 
                    type="text" 
                    name="phone" 
                    placeholder="Ví dụ: 0912 345 678" 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ kho hàng</label>
                <textarea 
                    name="address" 
                    rows="2" 
                    placeholder="Địa chỉ số nhà, thôn xã, huyện, tỉnh..." 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                ></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    id="create_is_active" 
                    value="1" 
                    checked 
                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="create_is_active" class="text-xs font-medium text-slate-700">Kích hoạt hoạt động ngay sau khi tạo</label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <x-ui.button type="button" variant="secondary" size="sm" onclick="closeModal('modal-create-warehouse')">
                    Hủy bỏ
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="sm">
                    💾 Lưu Chi Nhánh
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Modal Chỉnh Sửa Chi Nhánh -->
    <x-ui.modal id="modal-edit-warehouse" title="✏️ Chỉnh Sửa Thông Tin Chi Nhánh" size="md">
        <form id="form-edit-warehouse" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tên chi nhánh / Kho <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    id="edit_name"
                    required 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mã chi nhánh (Code) <span class="text-rose-500">*</span></label>
                <input 
                    type="text" 
                    name="code" 
                    id="edit_code"
                    required 
                    class="w-full text-sm font-mono uppercase rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại liên hệ</label>
                <input 
                    type="text" 
                    name="phone" 
                    id="edit_phone"
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                >
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ kho hàng</label>
                <textarea 
                    name="address" 
                    id="edit_address"
                    rows="2" 
                    class="w-full text-sm rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-xs"
                ></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    id="edit_is_active" 
                    value="1" 
                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="edit_is_active" class="text-xs font-medium text-slate-700">Trạng thái: Đang hoạt động</label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <x-ui.button type="button" variant="secondary" size="sm" onclick="closeModal('modal-edit-warehouse')">
                    Hủy bỏ
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" size="sm">
                    💾 Cập Nhật Chi Nhánh
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <script>
        function openCreateModal() {
            document.getElementById('modal-create-warehouse').classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(wh) {
            const form = document.getElementById('form-edit-warehouse');
            form.action = `/quan-ly/chi-nhanh/${wh.id}`;

            document.getElementById('edit_name').value = wh.name || '';
            document.getElementById('edit_code').value = wh.code || '';
            document.getElementById('edit_phone').value = wh.phone || '';
            document.getElementById('edit_address').value = wh.address || '';
            document.getElementById('edit_is_active').checked = Boolean(wh.is_active);

            document.getElementById('modal-edit-warehouse').classList.remove('hidden');
        }
    </script>
</x-layouts.app>
