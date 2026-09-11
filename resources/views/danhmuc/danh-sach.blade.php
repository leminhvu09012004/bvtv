<x-layouts.app title="Quản lý danh mục">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-6xl">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Quản lý danh mục</span>
    </nav>

    <!-- Header & Button thêm mới -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
        <div>
            <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>📁</span> Quản lý danh mục thuốc
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Hiện có <span id="tong-so-dm" class="font-semibold text-green-700">{{ $categories->count() }}</span> danh mục phân loại thuốc BVTV
            </p>
        </div>
        <button onclick="moModalThemDanhMuc()"
            class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Thêm danh mục mới</span>
        </button>
    </div>

    <!-- Thanh thao tác chọn nhiều (ẩn khi chưa chọn gì) -->
    <div id="bulk-action-bar-dm" class="hidden mb-4 p-3 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between gap-3 shadow-sm transition-all duration-200">
        <div class="flex items-center gap-2 text-sm text-green-900 font-medium">
            <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-1.5 rounded-full bg-green-600 text-white text-xs font-bold" id="so-luong-da-chon-dm">0</span>
            <span>danh mục đã được chọn</span>
        </div>
        <div class="flex items-center gap-2">
            <button id="btn-bo-chon-dm" type="button" class="text-xs px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                Bỏ chọn
            </button>
            <button id="btn-xoa-da-chon-dm" type="button" class="inline-flex items-center gap-1.5 text-xs px-3.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Xóa các mục đã chọn</span>
            </button>
        </div>
    </div>

    <!-- Bảng danh mục -->
    <div id="bang-dm-container" class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="bang-danh-muc">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-center w-10">
                            <input type="checkbox" id="chon-tat-ca-dm" title="Chọn tất cả" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                        </th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-14">Thứ tự</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Đường dẫn (Slug)</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Mô tả</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Số thuốc</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="bang-dm-body" class="divide-y divide-gray-100">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $cat->id }}">
                            <td class="px-3 py-3 text-center w-10">
                                <input type="checkbox" class="chon-dm w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer"
                                    value="{{ $cat->id }}"
                                    data-has-pesticides="{{ $cat->pesticides_count > 0 ? 'true' : 'false' }}"
                                    data-pesticides-count="{{ $cat->pesticides_count }}"
                                    data-name="{{ $cat->name }}">
                            </td>
                            <td class="px-3 py-3 text-center text-gray-500 font-mono text-xs col-sort-order">
                                <span class="inline-block bg-gray-100 px-2 py-0.5 rounded font-semibold">{{ $cat->sort_order }}</span>
                            </td>
                            <td class="px-4 py-3 col-name">
                                <a href="{{ route('danhmuc.xem', $cat->slug) }}" class="font-medium text-gray-900 hover:text-green-700 flex items-center gap-2">
                                    <span class="text-xl col-emoji">{{ $cat->emoji }}</span>
                                    <span class="col-name-text">{{ $cat->name }}</span>
                                </a>
                            </td>
                            <td class="px-4 py-3 text-gray-500 font-mono text-xs hidden sm:table-cell col-slug">
                                {{ $cat->slug }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs hidden md:table-cell max-w-xs col-desc">
                                <span class="line-clamp-2">{{ $cat->description ?: '—' }}</span>
                            </td>
                            <td class="px-4 py-3 text-center col-count">
                                @if($cat->pesticides_count > 0)
                                    <a href="{{ route('danhmuc.xem', $cat->slug) }}"
                                       class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium transition-colors">
                                        {{ $cat->pesticides_count }} thuốc
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">0 thuốc</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('danhmuc.xem', $cat->slug) }}"
                                       class="text-xs px-2 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">
                                        Xem
                                    </a>
                                    <button type="button"
                                        onclick="moModalSuaDanhMuc({{ json_encode([
                                            'id' => $cat->id,
                                            'name' => $cat->name,
                                            'emoji' => $cat->emoji,
                                            'description' => $cat->description ?? '',
                                            'sort_order' => $cat->sort_order,
                                            'url_update' => route('ajax.danhmuc.cap-nhat', $cat),
                                        ]) }})"
                                        class="text-xs px-2 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">
                                        Sửa
                                    </button>
                                    <button type="button"
                                        onclick="xacNhanXoaDanhMuc('{{ route('ajax.danhmuc.xoa', $cat) }}', '{{ addslashes($cat->name) }}', {{ $cat->pesticides_count }}, this)"
                                        class="text-xs px-2 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="row-empty">
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Chưa có danh mục nào. Hãy bấm "Thêm danh mục mới" ở trên!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================== -->
<!-- Modal Thêm Danh Mục (AJAX)                                 -->
<!-- ========================================================== -->
<div id="modal-them-dm" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-900 flex items-center gap-1.5">
                <span>➕</span> Thêm danh mục mới
            </h3>
            <button onclick="dongModalThemDanhMuc()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>

        <form id="form-them-dm" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Tên danh mục <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required placeholder="Ví dụ: Thuốc trừ cỏ tiền nảy mầm"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                <span class="text-xs text-red-500 mt-1 block dm-error" data-field="name"></span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Biểu tượng (Emoji)
                </label>
                <div class="flex gap-2 items-center mb-2">
                    <input type="text" id="them-emoji-input" name="emoji" value="📦" maxlength="10"
                        class="w-20 text-center text-xl border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    <span class="text-xs text-gray-400">Chọn nhanh bên dưới:</span>
                </div>
                <div class="flex flex-wrap gap-1.5 p-2 bg-gray-50 border border-gray-200 rounded-lg">
                    @foreach(['💊', '🍄', '🌿', '🐛', '🐌', '🌱', '🧪', '🌾', '📦', '🐝', '🦠', '🎋', '🪴', '🌻'] as $emo)
                        <button type="button" onclick="chonEmoji('them-emoji-input', '{{ $emo }}')"
                            class="text-lg p-1 hover:bg-white rounded hover:shadow-sm transition-all">{{ $emo }}</button>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Thứ tự sắp xếp
                </label>
                <input type="number" name="sort_order" value="{{ ($categories->max('sort_order') ?? 0) + 1 }}" min="0"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Mô tả (tùy chọn)
                </label>
                <textarea name="description" rows="2" placeholder="Ghi chú về nhóm thuốc này..."
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="dongModalThemDanhMuc()"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Hủy
                </button>
                <button type="submit" id="btn-submit-them-dm"
                    class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors shadow-sm">
                    Lưu danh mục
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================== -->
<!-- Modal Sửa Danh Mục (AJAX)                                  -->
<!-- ========================================================== -->
<div id="modal-sua-dm" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-900 flex items-center gap-1.5">
                <span>✏️</span> Chỉnh sửa danh mục
            </h3>
            <button onclick="dongModalSuaDanhMuc()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>

        <form id="form-sua-dm" class="space-y-4">
            <input type="hidden" id="sua-id">
            <input type="hidden" id="sua-url">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Tên danh mục <span class="text-red-500">*</span>
                </label>
                <input type="text" id="sua-name" name="name" required
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                <span class="text-xs text-red-500 mt-1 block dm-error" data-field="name"></span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Biểu tượng (Emoji)
                </label>
                <div class="flex gap-2 items-center mb-2">
                    <input type="text" id="sua-emoji-input" name="emoji" maxlength="10"
                        class="w-20 text-center text-xl border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                    <span class="text-xs text-gray-400">Chọn nhanh bên dưới:</span>
                </div>
                <div class="flex flex-wrap gap-1.5 p-2 bg-gray-50 border border-gray-200 rounded-lg">
                    @foreach(['💊', '🍄', '🌿', '🐛', '🐌', '🌱', '🧪', '🌾', '📦', '🐝', '🦠', '🎋', '🪴', '🌻'] as $emo)
                        <button type="button" onclick="chonEmoji('sua-emoji-input', '{{ $emo }}')"
                            class="text-lg p-1 hover:bg-white rounded hover:shadow-sm transition-all">{{ $emo }}</button>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Thứ tự sắp xếp
                </label>
                <input type="number" id="sua-sort-order" name="sort_order" min="0"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Mô tả (tùy chọn)
                </label>
                <textarea id="sua-description" name="description" rows="2"
                    class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="dongModalSuaDanhMuc()"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Hủy
                </button>
                <button type="submit" id="btn-submit-sua-dm"
                    class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors shadow-sm">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Helper gọi API an toàn không phụ thuộc biến ngoài
async function goiApi(url, method = 'GET', body = null) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest',
    };
    try {
        const res = await fetch(url, {
            method,
            headers,
            ...(body ? { body: JSON.stringify(body) } : {})
        });
        let data = {};
        try {
            data = await res.json();
        } catch (e) {
            data = { message: 'Phản hồi từ máy chủ không hợp lệ.' };
        }
        return { ok: res.ok, status: res.status, data };
    } catch (err) {
        return { ok: false, status: 0, data: { message: 'Lỗi kết nối máy chủ.' } };
    }
}

function baoThongBao(msg, type = 'success') {
    if (window.BVTV && typeof window.BVTV.toast === 'function') {
        window.BVTV.toast(msg, type);
        return;
    }
    const container = document.getElementById('toast-container');
    if (!container) { alert(msg); return; }
    const toast = document.createElement('div');
    toast.className = (type === 'success' ? 'bg-green-600' : 'bg-red-600') + ' text-white text-sm px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 transition-all';
    toast.textContent = msg;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}

document.addEventListener('DOMContentLoaded', () => {
    initTichChonDanhMuc();
    initAjaxThemDanhMuc();
    initAjaxSuaDanhMuc();
});

function initTichChonDanhMuc() {
    const table = document.getElementById('bang-danh-muc');
    const chonTatCa = document.getElementById('chon-tat-ca-dm');
    const bar = document.getElementById('bulk-action-bar-dm');
    const countEl = document.getElementById('so-luong-da-chon-dm');
    const btnBoChon = document.getElementById('btn-bo-chon-dm');
    const btnXoaDaChon = document.getElementById('btn-xoa-da-chon-dm');

    if (!table) return;

    window.capNhatTichChonDM = function() {
        const checkboxes = document.querySelectorAll('.chon-dm');
        const checked = document.querySelectorAll('.chon-dm:checked');

        if (countEl) countEl.textContent = checked.length;
        if (bar) {
            if (checked.length > 0) bar.classList.remove('hidden');
            else bar.classList.add('hidden');
        }

        if (chonTatCa) {
            if (checkboxes.length === 0) {
                chonTatCa.checked = false;
                chonTatCa.indeterminate = false;
            } else if (checked.length === checkboxes.length) {
                chonTatCa.checked = true;
                chonTatCa.indeterminate = false;
            } else if (checked.length > 0) {
                chonTatCa.checked = false;
                chonTatCa.indeterminate = true;
            } else {
                chonTatCa.checked = false;
                chonTatCa.indeterminate = false;
            }
        }
    };

    chonTatCa?.addEventListener('change', () => {
        const isChecked = chonTatCa.checked;
        document.querySelectorAll('.chon-dm').forEach(cb => {
            cb.checked = isChecked;
            cb.closest('tr')?.classList.toggle('bg-green-50/70', isChecked);
        });
        window.capNhatTichChonDM();
    });

    table.addEventListener('change', (e) => {
        if (e.target.classList.contains('chon-dm')) {
            e.target.closest('tr')?.classList.toggle('bg-green-50/70', e.target.checked);
            window.capNhatTichChonDM();
        }
    });

    btnBoChon?.addEventListener('click', () => {
        document.querySelectorAll('.chon-dm').forEach(cb => {
            cb.checked = false;
            cb.closest('tr')?.classList.remove('bg-green-50/70');
        });
        if (chonTatCa) {
            chonTatCa.checked = false;
            chonTatCa.indeterminate = false;
        }
        window.capNhatTichChonDM();
    });

    // Xóa hàng loạt AJAX
    btnXoaDaChon?.addEventListener('click', () => {
        const checked = Array.from(document.querySelectorAll('.chon-dm:checked'));
        if (checked.length === 0) return;

        const ids = checked.map(cb => cb.value);
        const coThuoc = checked.filter(cb => cb.dataset.hasPesticides === 'true');
        const modal = document.getElementById('delete-modal');
        const modalText = document.getElementById('delete-modal-text');
        const xoaBtn = document.getElementById('ajax-xoa-btn');
        if (!modal || !xoaBtn) return;

        // Luôn đặt nút Xóa về trạng thái ban đầu
        xoaBtn.disabled = false;
        xoaBtn.textContent = 'Xóa';

        if (coThuoc.length > 0) {
            const danhSachCoThuoc = coThuoc.map(cb => `${cb.dataset.name} (${cb.dataset.pesticidesCount} thuốc)`).join(', ');
            modalText.innerHTML = `Bạn có chắc muốn xóa <strong>${ids.length} danh mục</strong> đã chọn?<br><span class="text-amber-600 text-xs mt-2 block p-2 bg-amber-50 rounded border border-amber-200">⚠️ <strong>Cảnh báo:</strong> Các danh mục: <em>${danhSachCoThuoc}</em> đang có thuốc. Toàn bộ thuốc thuộc các danh mục này cũng sẽ bị xóa.</span>`;
        } else {
            modalText.innerHTML = `Bạn có chắc muốn xóa <strong>${ids.length} danh mục</strong> đã chọn không?`;
        }
        modal.classList.remove('hidden');

        xoaBtn.onclick = async () => {
            xoaBtn.disabled = true;
            xoaBtn.textContent = 'Đang xóa...';

            try {
                const { ok, data } = await goiApi('{{ route('ajax.danhmuc.xoa-nhieu') }}', 'DELETE', { ids });

                if (ok && data.success) {
                    checked.forEach(cb => {
                        const row = cb.closest('tr');
                        if (row) {
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                    });

                    setTimeout(() => {
                        const remaining = document.querySelectorAll('#bang-dm-body tr[data-id]').length;
                        const tongEl = document.getElementById('tong-so-dm');
                        if (tongEl) tongEl.textContent = remaining;
                        window.capNhatTichChonDM();
                    }, 350);

                    baoThongBao(data.thong_bao, 'success');
                } else {
                    baoThongBao(data.message ?? 'Có lỗi xảy ra khi xóa.', 'error');
                }
            } catch (err) {
                console.error(err);
                baoThongBao('Lỗi kết nối khi xóa danh mục.', 'error');
            } finally {
                xoaBtn.disabled = false;
                xoaBtn.textContent = 'Xóa';
                document.getElementById('delete-modal')?.classList.add('hidden');
            }
        };
    });
}

function initAjaxThemDanhMuc() {
    const form = document.getElementById('form-them-dm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('btn-submit-them-dm');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang lưu...';

        form.querySelectorAll('.dm-error').forEach(el => el.textContent = '');

        const formData = new FormData(form);
        const body = {};
        formData.forEach((v, k) => body[k] = v);

        try {
            const { ok, status, data } = await goiApi('{{ route('ajax.danhmuc.them') }}', 'POST', body);

            if (ok && data.success) {
                dongModalThemDanhMuc();
                form.reset();
                document.getElementById('them-emoji-input').value = '📦';

                document.getElementById('row-empty')?.remove();

                const tableBody = document.getElementById('bang-dm-body');
                const d = data.danh_muc;
                const newTr = document.createElement('tr');
                newTr.className = 'hover:bg-gray-50 transition-colors';
                newTr.dataset.id = d.id;
                newTr.innerHTML = `
                    <td class="px-3 py-3 text-center w-10">
                        <input type="checkbox" class="chon-dm w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer"
                            value="${d.id}" data-has-pesticides="false" data-pesticides-count="0" data-name="${escapeHtml(d.name)}">
                    </td>
                    <td class="px-3 py-3 text-center text-gray-500 font-mono text-xs col-sort-order">
                        <span class="inline-block bg-gray-100 px-2 py-0.5 rounded font-semibold">${d.sort_order}</span>
                    </td>
                    <td class="px-4 py-3 col-name">
                        <a href="${d.url_xem}" class="font-medium text-gray-900 hover:text-green-700 flex items-center gap-2">
                            <span class="text-xl col-emoji">${escapeHtml(d.emoji)}</span>
                            <span class="col-name-text">${escapeHtml(d.name)}</span>
                        </a>
                    </td>
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs hidden sm:table-cell col-slug">${escapeHtml(d.slug)}</td>
                    <td class="px-4 py-3 text-gray-600 text-xs hidden md:table-cell max-w-xs col-desc">
                        <span class="line-clamp-2">${escapeHtml(d.description || '—')}</span>
                    </td>
                    <td class="px-4 py-3 text-center col-count">
                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-full">0 thuốc</span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1">
                            <a href="${d.url_xem}" class="text-xs px-2 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">Xem</a>
                            <button type="button" onclick='moModalSuaDanhMuc(${JSON.stringify(d)})'
                                class="text-xs px-2 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">Sửa</button>
                            <button type="button" onclick="xacNhanXoaDanhMuc('${d.url_xoa}', '${escapeHtml(d.name)}', 0, this)"
                                class="text-xs px-2 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors">Xóa</button>
                        </div>
                    </td>
                `;

                newTr.style.background = '#f0fdf4';
                tableBody.appendChild(newTr);
                setTimeout(() => newTr.style.background = '', 2000);

                const tongEl = document.getElementById('tong-so-dm');
                if (tongEl) tongEl.textContent = document.querySelectorAll('#bang-dm-body tr[data-id]').length;

                baoThongBao(data.thong_bao, 'success');
                window.capNhatTichChonDM();
            } else if (status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const err = form.querySelector(`.dm-error[data-field="${field}"]`);
                    if (err) err.textContent = msgs[0];
                });
            } else {
                baoThongBao(data.message ?? 'Có lỗi xảy ra.', 'error');
            }
        } catch (err) {
            console.error(err);
            baoThongBao('Lỗi kết nối khi thêm danh mục.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Lưu danh mục';
        }
    });
}

function initAjaxSuaDanhMuc() {
    const form = document.getElementById('form-sua-dm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('btn-submit-sua-dm');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang lưu...';

        form.querySelectorAll('.dm-error').forEach(el => el.textContent = '');

        const url = document.getElementById('sua-url').value;
        const id = document.getElementById('sua-id').value;
        const body = {
            name: document.getElementById('sua-name').value,
            emoji: document.getElementById('sua-emoji-input').value,
            sort_order: document.getElementById('sua-sort-order').value,
            description: document.getElementById('sua-description').value,
        };

        try {
            const { ok, status, data } = await goiApi(url, 'PUT', body);

            if (ok && data.success) {
                dongModalSuaDanhMuc();
                const d = data.danh_muc;
                const row = document.querySelector(`#bang-dm-body tr[data-id="${id}"]`);
                if (row) {
                    row.querySelector('.col-emoji').textContent = d.emoji;
                    row.querySelector('.col-name-text').textContent = d.name;
                    row.querySelector('.col-sort-order span').textContent = d.sort_order;
                    row.querySelector('.col-slug').textContent = d.slug;
                    row.querySelector('.col-desc span').textContent = d.description || '—';
                    const cb = row.querySelector('.chon-dm');
                    if (cb) cb.dataset.name = d.name;

                    row.style.background = '#f0fdf4';
                    setTimeout(() => row.style.background = '', 2000);
                }
                baoThongBao(data.thong_bao, 'success');
            } else if (status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const err = form.querySelector(`.dm-error[data-field="${field}"]`);
                    if (err) err.textContent = msgs[0];
                });
            } else {
                baoThongBao(data.message ?? 'Có lỗi xảy ra.', 'error');
            }
        } catch (err) {
            console.error(err);
            baoThongBao('Lỗi kết nối khi cập nhật danh mục.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Lưu thay đổi';
        }
    });
}

function xacNhanXoaDanhMuc(url, name, count, btn) {
    const modal = document.getElementById('delete-modal');
    const modalText = document.getElementById('delete-modal-text');
    const xoaBtn = document.getElementById('ajax-xoa-btn');
    if (!modal || !xoaBtn) return;

    xoaBtn.disabled = false;
    xoaBtn.textContent = 'Xóa';

    if (count > 0) {
        modalText.innerHTML = `Bạn có chắc muốn xóa danh mục <strong>"${name}"</strong>?<br><span class="text-amber-600 text-xs mt-2 block p-2 bg-amber-50 rounded border border-amber-200">⚠️ Danh mục này đang chứa <strong>${count} loại thuốc</strong>. Toàn bộ thuốc thuộc danh mục này cũng sẽ bị xóa.</span>`;
    } else {
        modalText.innerHTML = `Bạn có chắc muốn xóa danh mục <strong>"${name}"</strong> không?`;
    }
    modal.classList.remove('hidden');

    xoaBtn.onclick = async () => {
        xoaBtn.disabled = true;
        xoaBtn.textContent = 'Đang xóa...';

        try {
            const { ok, data } = await goiApi(url, 'DELETE');

            if (ok && data.success) {
                const row = btn?.closest('tr');
                if (row) {
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        const remaining = document.querySelectorAll('#bang-dm-body tr[data-id]').length;
                        const tongEl = document.getElementById('tong-so-dm');
                        if (tongEl) tongEl.textContent = remaining;
                        window.capNhatTichChonDM();
                    }, 300);
                }
                baoThongBao(data.thong_bao, 'success');
            } else {
                baoThongBao(data.message ?? 'Có lỗi xảy ra khi xóa.', 'error');
            }
        } catch (err) {
            console.error(err);
            baoThongBao('Lỗi kết nối khi xóa danh mục.', 'error');
        } finally {
            xoaBtn.disabled = false;
            xoaBtn.textContent = 'Xóa';
            document.getElementById('delete-modal')?.classList.add('hidden');
        }
    };
}

function moModalThemDanhMuc() {
    document.getElementById('modal-them-dm').classList.remove('hidden');
    document.getElementById('form-them-dm')?.querySelector('[name="name"]')?.focus();
}
function dongModalThemDanhMuc() {
    document.getElementById('modal-them-dm').classList.add('hidden');
}

function moModalSuaDanhMuc(cat) {
    document.getElementById('sua-id').value = cat.id;
    document.getElementById('sua-url').value = cat.url_update;
    document.getElementById('sua-name').value = cat.name;
    document.getElementById('sua-emoji-input').value = cat.emoji || '📦';
    document.getElementById('sua-sort-order').value = cat.sort_order;
    document.getElementById('sua-description').value = cat.description || '';
    document.getElementById('modal-sua-dm').classList.remove('hidden');
    document.getElementById('sua-name').focus();
}
function dongModalSuaDanhMuc() {
    document.getElementById('modal-sua-dm').classList.add('hidden');
}

function chonEmoji(inputId, emo) {
    document.getElementById(inputId).value = emo;
}

function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, s => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
    }[s]));
}
</script>
</x-layouts.app>
