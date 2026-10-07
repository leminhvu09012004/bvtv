// ============================================================
// Sổ Tay BVTV — app.js
// ============================================================

const BVTV = {

    // ----------------------------------------------------------
    // CSRF token dùng cho mọi request POST/DELETE
    // ----------------------------------------------------------
    csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content
            ?? document.querySelector('input[name="_token"]')?.value
            ?? '';
    },

    // ----------------------------------------------------------
    // Fetch helper: trả về Promise<{ok, data|error}>
    // ----------------------------------------------------------
    async fetchJSON(url, options = {}) {
        const defaultHeaders = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': this.csrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        };
        if (options.body && !(options.body instanceof FormData)) {
            defaultHeaders['Content-Type'] = 'application/json';
        }
        try {
            const res = await fetch(url, {
                headers: { ...defaultHeaders, ...(options.headers ?? {}) },
                ...options,
            });
            const data = await res.json();
            return { ok: res.ok, status: res.status, data };
        } catch (err) {
            return { ok: false, data: { message: 'Lỗi kết nối mạng.' } };
        }
    },

    // ----------------------------------------------------------
    // Toast notification
    // ----------------------------------------------------------
    toast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) { return; }

        const toast = document.createElement('div');
        const bg = type === 'success' ? 'bg-green-600' : 'bg-red-600';
        const icon = type === 'success' ? '✅' : '❌';
        toast.className = `${bg} text-white text-sm px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 transition-all duration-300 opacity-0 translate-y-2`;
        toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            });
        });

        // Auto remove
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    },

    // ----------------------------------------------------------
    // Live Search (debounced)
    // ----------------------------------------------------------
    searchTimeout: null,

    initLiveSearch() {
        const searchInput = document.getElementById('live-search-input');
        const searchUrl = document.getElementById('live-search-input')?.dataset.url;
        const tableBody = document.getElementById('bang-thuoc-body');
        const countEl = document.getElementById('so-luong-ket-qua');
        const emptyEl = document.getElementById('empty-state');
        const tableEl = document.getElementById('bang-thuoc');
        const loadingEl = document.getElementById('search-loading');
        const clearInputBtn = document.getElementById('clear-search-input');
        const filterPhamVi = document.getElementById('filter-pham-vi');
        const filterCategory = document.getElementById('filter-danh-muc');
        const filterHinhAnh = document.getElementById('filter-hinh-anh');
        const filterSapXep = document.getElementById('filter-sap-xep');
        const btnXoaBoLoc = document.getElementById('xoa-bo-loc');
        const activeTagsEl = document.getElementById('filter-active-tags');
        const tagChipsEl = document.getElementById('filter-tag-chips');

        if (!searchInput || !tableBody) { return; }

        const capNhatNutXoaBoLoc = () => {
            const q = searchInput ? searchInput.value.trim() : '';
            const cat = filterCategory ? filterCategory.value : '';
            const img = filterHinhAnh ? filterHinhAnh.value : '';
            const scope = filterPhamVi ? filterPhamVi.value : 'name';

            // CHỈ coi là có lọc khi có từ khóa q, chọn danh mục cat, hoặc chọn trạng thái ảnh img
            const hasFilter = Boolean(q || cat || img || (scope && scope !== 'name'));

            if (btnXoaBoLoc) {
                btnXoaBoLoc.style.display = hasFilter ? 'inline-flex' : 'none';
            }
            if (clearInputBtn) {
                clearInputBtn.style.display = q ? 'inline-flex' : 'none';
            }

            if (activeTagsEl && tagChipsEl) {
                if (!hasFilter) {
                    activeTagsEl.style.display = 'none';
                    tagChipsEl.innerHTML = '';
                } else {
                    activeTagsEl.style.display = 'flex';
                    const chips = [];
                    if (q) {
                        let labelPrefix = 'Tên: ';
                        if (scope === 'active_ingredient') labelPrefix = 'Hoạt chất: ';
                        else if (scope === 'all') labelPrefix = 'Tất cả: ';
                        chips.push(`<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-md text-[11px] font-medium">${labelPrefix}"${escapeHtml(q)}" <button type="button" onclick="document.getElementById('clear-search-input').click()" class="text-emerald-500 hover:text-emerald-800 font-bold ml-0.5">✕</button></span>`);
                    }
                    if (scope && scope !== 'name') {
                        const scopeText = filterPhamVi.options[filterPhamVi.selectedIndex]?.text || scope;
                        chips.push(`<span class="inline-flex items-center gap-1 bg-purple-50 text-purple-800 border border-purple-200 px-2 py-0.5 rounded-md text-[11px] font-medium">${escapeHtml(scopeText)} <button type="button" onclick="document.getElementById('filter-pham-vi').value='name';document.getElementById('filter-pham-vi').dispatchEvent(new Event('change'))" class="text-purple-500 hover:text-purple-800 font-bold ml-0.5">✕</button></span>`);
                    }
                    if (cat) {
                        const catText = filterCategory.options[filterCategory.selectedIndex]?.text || 'Danh mục';
                        chips.push(`<span class="inline-flex items-center gap-1 bg-blue-50 text-blue-800 border border-blue-200 px-2 py-0.5 rounded-md text-[11px] font-medium">${escapeHtml(catText)} <button type="button" onclick="document.getElementById('filter-danh-muc').value='';document.getElementById('filter-danh-muc').dispatchEvent(new Event('change'))" class="text-blue-500 hover:text-blue-800 font-bold ml-0.5">✕</button></span>`);
                    }
                    if (img === 'no') {
                        chips.push(`<span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 px-2 py-0.5 rounded-md text-[11px] font-medium">⚠️ Chưa có ảnh <button type="button" onclick="document.getElementById('filter-hinh-anh').value='';document.getElementById('filter-hinh-anh').dispatchEvent(new Event('change'))" class="text-amber-500 hover:text-amber-800 font-bold ml-0.5">✕</button></span>`);
                    } else if (img === 'yes') {
                        chips.push(`<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-md text-[11px] font-medium">✅ Đã có ảnh <button type="button" onclick="document.getElementById('filter-hinh-anh').value='';document.getElementById('filter-hinh-anh').dispatchEvent(new Event('change'))" class="text-emerald-500 hover:text-emerald-800 font-bold ml-0.5">✕</button></span>`);
                    }
                    tagChipsEl.innerHTML = chips.join(' ');
                }
            }
        };

        const doSearch = async () => {
            capNhatNutXoaBoLoc();
            const q = searchInput.value.trim();
            const searchBy = filterPhamVi?.value ?? 'name';
            const categoryId = filterCategory?.value ?? '';
            const hasImage = filterHinhAnh?.value ?? '';
            const sort = filterSapXep?.value ?? 'name_asc';

            const params = new URLSearchParams();
            if (q) { params.set('q', q); }
            if (searchBy && searchBy !== 'name') { params.set('search_by', searchBy); }
            if (categoryId) { params.set('category_id', categoryId); }
            if (hasImage) { params.set('has_image', hasImage); }
            if (sort && sort !== 'name_asc') { params.set('sort', sort); }

            // 1. Lưu trạng thái lọc vào sessionStorage để làm phương án dự phòng tin cậy
            try {
                if (q || (searchBy && searchBy !== 'name') || categoryId || hasImage || (sort && sort !== 'name_asc')) {
                    sessionStorage.setItem('bvtv_admin_filters', JSON.stringify({
                        q: q,
                        search_by: searchBy,
                        category_id: categoryId,
                        has_image: hasImage,
                        sort: sort
                    }));
                } else {
                    sessionStorage.removeItem('bvtv_admin_filters');
                }
            } catch(e) {}

            // 2. Đồng bộ bộ lọc vào URL của trình duyệt (giúp không mất lọc khi F5 hoặc sau khi lưu)
            try {
                const newQuery = params.toString() ? '?' + params.toString() : window.location.pathname;
                history.replaceState(null, '', newQuery);
            } catch(e) {}

            if (loadingEl) { loadingEl.classList.remove('hidden'); }

            const { ok, data } = await BVTV.fetchJSON(`${searchUrl}?${params.toString()}`);

            if (loadingEl) { loadingEl.classList.add('hidden'); }
            if (!ok) { return; }

            const totalHienThi = data.total;
            const totalAll = window.BVTV_TOTAL_COUNT || 157;
            const isFiltered = Boolean(q || categoryId || hasImage || sort !== 'name_asc');

            if (countEl) {
                if (isFiltered) {
                    countEl.innerHTML = `<span class="font-bold text-emerald-700">${totalHienThi}</span> / ${totalAll} sản phẩm tìm thấy • <span class="text-gray-400 text-[11px]">Đang áp dụng bộ lọc</span>`;
                } else {
                    countEl.innerHTML = `<span class="font-semibold text-gray-800">${totalAll}</span> sản phẩm • Quản lý thêm, sửa, xóa`;
                }
            }

            if (data.total === 0) {
                if (tableEl) { tableEl.classList.add('hidden'); }
                if (emptyEl) { emptyEl.classList.remove('hidden'); }
                BVTV.capNhatTichChon();
                return;
            }

            if (tableEl) { tableEl.classList.remove('hidden'); }
            if (emptyEl) { emptyEl.classList.add('hidden'); }

            tableBody.innerHTML = data.data.map((p) => BVTV.renderRow(p)).join('');
            BVTV.capNhatTichChon();
        };

        const debounced = () => {
            clearTimeout(BVTV.searchTimeout);
            BVTV.searchTimeout = setTimeout(doSearch, 250);
        };

        searchInput.addEventListener('input', () => {
            capNhatNutXoaBoLoc();
            debounced();
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                capNhatNutXoaBoLoc();
                doSearch();
            }
        });

        clearInputBtn?.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            capNhatNutXoaBoLoc();
            doSearch();
        });

        filterCategory?.addEventListener('change', () => {
            capNhatNutXoaBoLoc();
            doSearch();
        });

        filterHinhAnh?.addEventListener('change', () => {
            capNhatNutXoaBoLoc();
            doSearch();
        });

        filterPhamVi?.addEventListener('change', () => {
            const val = filterPhamVi.value;
            if (val === 'active_ingredient') {
                searchInput.placeholder = '🔍 Tìm kiếm theo hoạt chất (Ví dụ: Azoxystrobin, Mancozeb, Cypermethrin)...';
            } else if (val === 'all') {
                searchInput.placeholder = '🔍 Tìm tất cả: Tên thuốc, hoạt chất, quy cách, công dụng, ID (#54)...';
            } else {
                searchInput.placeholder = '🔍 Tìm kiếm theo tên thuốc (Ví dụ: 15-15-15, Kẽm EDTA, Huỳnh Lâm, Mancozeb, #54)...';
            }
            capNhatNutXoaBoLoc();
            doSearch();
        });

        filterSapXep?.addEventListener('change', () => {
            capNhatNutXoaBoLoc();
            doSearch();
        });

        btnXoaBoLoc?.addEventListener('click', () => {
            searchInput.value = '';
            if (filterPhamVi) {
                filterPhamVi.value = 'name';
                searchInput.placeholder = '🔍 Tìm kiếm theo tên thuốc (Ví dụ: 15-15-15, Kẽm EDTA, Huỳnh Lâm, Mancozeb, #54)...';
            }
            if (filterCategory) { filterCategory.value = ''; }
            if (filterHinhAnh) { filterHinhAnh.value = ''; }
            if (filterSapXep) { filterSapXep.value = 'name_asc'; }
            try {
                sessionStorage.removeItem('bvtv_admin_filters');
            } catch (e) {}
            capNhatNutXoaBoLoc();
            doSearch();
        });

        capNhatNutXoaBoLoc();
    },

    // ----------------------------------------------------------
    // Render một hàng bảng từ dữ liệu JSON (kèm checkbox tích chọn)
    // ----------------------------------------------------------
    renderRow(p) {
        const ten = escapeHtml(p.ten ?? '');
        const hoatChat = escapeHtml(p.hoat_chat ?? '');
        const hamLuong = p.ham_luong ? `<span class="text-xs text-gray-500 font-mono">${escapeHtml(p.ham_luong)}</span>` : '';
        const waterVolume = p.water_volume ? `<span class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded border border-blue-200/60 inline-flex items-center gap-0.5" title="Lượng nước pha khuyến cáo">💧 Pha: ${escapeHtml(p.water_volume)}</span>` : '';
        const congDung = escapeHtml(p.cong_dung ?? '');
        const cayTrong = escapeHtml(p.cay_trong ?? '');
        const danhMuc = p.danh_muc
            ? `<a href="/danh-muc/${encodeURIComponent(p.danh_muc_slug)}" class="inline-flex items-center gap-1 text-xs bg-gray-100 hover:bg-green-100 text-gray-600 hover:text-green-700 px-2.5 py-1 rounded-full transition-colors whitespace-nowrap font-medium">${escapeHtml(p.danh_muc)}</a>`
            : '';

        const anhThumb = p.image_url
            ? `<div class="relative w-16 h-16 rounded-xl overflow-hidden border border-gray-200 shrink-0 cursor-pointer shadow-xs hover:ring-2 hover:ring-green-500 transition-all group bg-white"
                    onclick="moModalAnh(document.getElementById('admin-img-${p.id}')?.src || '${p.image_url}', '${ten.replace(/'/g, "\\'")}')" title="Nhấp để xem ảnh lớn">
                   <img id="admin-img-${p.id}" src="${p.image_url}" alt="${ten}" class="w-full h-full object-contain group-hover:scale-105 transition-all">
               </div>`
            : `<div class="w-16 h-16 rounded-xl bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-lg" title="Chưa có hình">💊</div>`;

        return `
        <tr class="hover:bg-gray-50 transition-colors" data-id="${p.id}">
            <td class="px-3 py-3 text-center w-10">
                <input type="checkbox" class="chon-thuoc w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer" value="${p.id}">
            </td>
            <td class="px-4 py-3 min-w-[340px] md:min-w-[380px]">
                <div class="flex items-center gap-3">
                    ${anhThumb}
                    <div class="min-w-0 flex-1">
                        <a href="${p.url_xem}" class="font-medium text-green-700 hover:underline">${ten}</a>
                        <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                            ${hamLuong}
                            ${waterVolume}
                        </div>
                        ${hoatChat ? `<div class="text-xs text-gray-500 mt-0.5 md:hidden truncate">${hoatChat}</div>` : ''}
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 hidden sm:table-cell whitespace-nowrap">${danhMuc}</td>
            <td class="px-4 py-3 text-gray-600 hidden md:table-cell">${hoatChat || '—'}</td>
            <td class="px-4 py-3 text-gray-600 hidden lg:table-cell">
                <span class="line-clamp-2">${congDung || '—'}</span>
            </td>
            <td class="px-4 py-3 text-right whitespace-nowrap">
                <div class="flex items-center justify-end gap-1">
                    <a href="${p.url_xem}" class="text-xs px-2.5 py-1 rounded-md text-gray-600 hover:bg-gray-100 transition-colors">Xem</a>
                    <a href="${p.url_sua}" class="text-xs px-2.5 py-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors">Sửa</a>
                    <button onclick="BVTV.xacNhanXoaAjax('${p.url_xoa}', '${ten.replace(/'/g, "\\'")}', this)"
                            class="text-xs px-2.5 py-1 rounded-md text-red-600 hover:bg-red-50 transition-colors">Xóa</button>
                </div>
            </td>
        </tr>`;
    },

    // ----------------------------------------------------------
    // Quản lý tích chọn (checkbox & bulk actions)
    // ----------------------------------------------------------
    initTichChon() {
        const table = document.getElementById('bang-thuoc');
        const chonTatCa = document.getElementById('chon-tat-ca');
        const btnBoChon = document.getElementById('btn-bo-chon');
        const btnXoaDaChon = document.getElementById('btn-xoa-da-chon');

        if (!table) { return; }

        // Chọn / Bỏ chọn tất cả
        chonTatCa?.addEventListener('change', () => {
            const isChecked = chonTatCa.checked;
            document.querySelectorAll('.chon-thuoc').forEach(cb => {
                cb.checked = isChecked;
                const row = cb.closest('tr');
                if (row) {
                    row.classList.toggle('bg-green-50/70', isChecked);
                }
            });
            BVTV.capNhatTichChon();
        });

        // Click từng checkbox trong bảng (event delegation)
        table.addEventListener('change', (e) => {
            if (e.target.classList.contains('chon-thuoc')) {
                const row = e.target.closest('tr');
                if (row) {
                    row.classList.toggle('bg-green-50/70', e.target.checked);
                }
                BVTV.capNhatTichChon();
            }
        });

        // Bỏ chọn tất cả
        btnBoChon?.addEventListener('click', () => {
            document.querySelectorAll('.chon-thuoc').forEach(cb => {
                cb.checked = false;
                cb.closest('tr')?.classList.remove('bg-green-50/70');
            });
            if (chonTatCa) {
                chonTatCa.checked = false;
                chonTatCa.indeterminate = false;
            }
            BVTV.capNhatTichChon();
        });

        // Xóa các mục đã chọn qua AJAX
        btnXoaDaChon?.addEventListener('click', () => {
            const checkedBoxes = Array.from(document.querySelectorAll('.chon-thuoc:checked'));
            const ids = checkedBoxes.map(cb => cb.value);

            if (ids.length === 0) { return; }

            const modal = document.getElementById('delete-modal');
            const modalText = document.getElementById('delete-modal-text');
            const xoaBtn = document.getElementById('ajax-xoa-btn');
            if (!modal || !xoaBtn) { return; }

            xoaBtn.disabled = false;
            xoaBtn.textContent = 'Xóa';
            modalText.textContent = `Bạn có chắc muốn xóa ${ids.length} sản phẩm đã chọn không? Thao tác này không thể hoàn tác.`;
            modal.classList.remove('hidden');

            xoaBtn.onclick = async () => {
                xoaBtn.disabled = true;
                xoaBtn.textContent = 'Đang xóa...';

                try {
                    const { ok, data } = await BVTV.fetchJSON('/ajax/xoa-nhieu', {
                        method: 'DELETE',
                        body: JSON.stringify({ ids }),
                    });

                    if (ok && data.success) {
                        // Xóa các dòng khỏi bảng
                        checkedBoxes.forEach(cb => {
                            const row = cb.closest('tr');
                            if (row) {
                                row.style.transition = 'opacity 0.3s';
                                row.style.opacity = '0';
                                setTimeout(() => row.remove(), 300);
                            }
                        });

                        setTimeout(() => {
                            // Cập nhật số lượng
                            const countEl = document.getElementById('so-luong-ket-qua');
                            const remainingRows = document.querySelectorAll('#bang-thuoc-body tr').length;
                            if (countEl) {
                                countEl.textContent = `${remainingRows} sản phẩm tìm thấy`;
                            }

                            // Nếu không còn dòng nào, hiện empty state
                            if (remainingRows === 0) {
                                document.getElementById('bang-thuoc')?.classList.add('hidden');
                                document.getElementById('empty-state')?.classList.remove('hidden');
                            }

                            BVTV.capNhatTichChon();
                        }, 350);

                        BVTV.toast(data.thong_bao, 'success');
                    } else {
                        BVTV.toast(data.message ?? 'Có lỗi xảy ra khi xóa.', 'error');
                    }
                } catch (err) {
                    console.error(err);
                    BVTV.toast('Lỗi kết nối khi xóa thuốc.', 'error');
                } finally {
                    dongModalXoa();
                    xoaBtn.disabled = false;
                    xoaBtn.textContent = 'Xóa';
                }
            };
        });
    },

    // Cập nhật trạng thái thanh bulk action và checkbox chọn tất cả
    capNhatTichChon() {
        const checkboxes = document.querySelectorAll('.chon-thuoc');
        const checked = document.querySelectorAll('.chon-thuoc:checked');
        const chonTatCa = document.getElementById('chon-tat-ca');
        const bar = document.getElementById('bulk-action-bar');
        const countEl = document.getElementById('so-luong-da-chon');

        if (countEl) {
            countEl.textContent = checked.length;
        }

        if (bar) {
            if (checked.length > 0) {
                bar.classList.remove('hidden');
            } else {
                bar.classList.add('hidden');
            }
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
    },

    // ----------------------------------------------------------
    // AJAX Delete (1 sản phẩm)
    // ----------------------------------------------------------
    async xacNhanXoaAjax(url, ten, btn) {
        const modal = document.getElementById('delete-modal');
        const modalText = document.getElementById('delete-modal-text');
        const xoaBtn = document.getElementById('ajax-xoa-btn');
        if (!modal || !xoaBtn) { return; }

        xoaBtn.disabled = false;
        xoaBtn.textContent = 'Xóa';
        modalText.textContent = `Bạn có chắc muốn xóa sản phẩm "${ten}" không?`;
        modal.classList.remove('hidden');

        // Thay nút submit thành handler AJAX
        xoaBtn.onclick = async () => {
            xoaBtn.disabled = true;
            xoaBtn.textContent = 'Đang xóa...';

            try {
                const { ok, data } = await BVTV.fetchJSON(url, { method: 'DELETE' });

                if (ok && data.success) {
                    // Xóa hàng khỏi bảng
                    const row = btn?.closest('tr');
                    if (row) {
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            // Cập nhật số lượng
                            const countEl = document.getElementById('so-luong-ket-qua');
                            const remainingRows = document.querySelectorAll('#bang-thuoc-body tr').length;
                            if (countEl) {
                                countEl.textContent = `${remainingRows} sản phẩm tìm thấy`;
                            }
                            // Nếu không còn dòng nào, hiện empty state
                            if (remainingRows === 0) {
                                document.getElementById('bang-thuoc')?.classList.add('hidden');
                                document.getElementById('empty-state')?.classList.remove('hidden');
                            }
                            BVTV.capNhatTichChon();
                        }, 300);
                    }
                    BVTV.toast(data.thong_bao, 'success');
                } else {
                    BVTV.toast(data.message ?? 'Có lỗi xảy ra khi xóa.', 'error');
                }
            } catch (err) {
                console.error(err);
                BVTV.toast('Lỗi kết nối khi xóa thuốc.', 'error');
            } finally {
                dongModalXoa();
                xoaBtn.disabled = false;
                xoaBtn.textContent = 'Xóa';
            }
        };
    },

    // ----------------------------------------------------------
    // Quick-Add Modal (thêm thuốc nhanh qua AJAX)
    // ----------------------------------------------------------
    initQuickAdd() {
        const btn = document.getElementById('quick-add-btn');
        const modal = document.getElementById('quick-add-modal');
        const closeBtn = document.getElementById('quick-add-close');
        const form = document.getElementById('quick-add-form');
        if (!btn || !modal || !form) { return; }

        btn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            form.querySelector('[name="name"]')?.focus();
        });

        closeBtn?.addEventListener('click', () => modal.classList.add('hidden'));

        modal.addEventListener('click', (e) => {
            if (e.target === modal) { modal.classList.add('hidden'); }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang lưu...';

            // Clear errors
            form.querySelectorAll('.field-error').forEach(el => el.textContent = '');

            const formData = new FormData(form);
            const body = {};
            formData.forEach((v, k) => { body[k] = v; });

            const { ok, status, data } = await BVTV.fetchJSON(
                form.dataset.url,
                { method: 'POST', body: JSON.stringify(body) }
            );

            submitBtn.disabled = false;
            submitBtn.textContent = originalText;

            if (ok && data.success) {
                modal.classList.add('hidden');
                form.reset();
                BVTV.toast(data.thong_bao, 'success');

                // Thêm hàng vào đầu bảng nếu đang ở trang danh sách
                const tableBody = document.getElementById('bang-thuoc-body');
                const tableEl = document.getElementById('bang-thuoc');
                const emptyEl = document.getElementById('empty-state');

                if (tableBody) {
                    const newRow = document.createElement('tbody');
                    newRow.innerHTML = BVTV.renderRow(data.thuoc);
                    const firstRow = newRow.querySelector('tr');
                    firstRow.style.background = '#f0fdf4';
                    tableBody.prepend(firstRow);
                    setTimeout(() => { firstRow.style.background = ''; }, 2000);
                    if (tableEl) { tableEl.classList.remove('hidden'); }
                    if (emptyEl) { emptyEl.classList.add('hidden'); }
                    const countEl = document.getElementById('so-luong-ket-qua');
                    if (countEl) {
                        const cur = parseInt(countEl.textContent) || 0;
                        countEl.textContent = `${cur + 1} sản phẩm tìm thấy`;
                    }
                    BVTV.capNhatTichChon();
                }
            } else if (status === 422 && data.errors) {
                // Validation errors
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const errEl = form.querySelector(`.field-error[data-field="${field}"]`);
                    if (errEl) { errEl.textContent = msgs[0]; }
                });
            } else {
                BVTV.toast(data.message ?? 'Có lỗi xảy ra.', 'error');
            }
        });
    },
};

// ----------------------------------------------------------
// Helper: thoát HTML để tránh XSS
// ----------------------------------------------------------
function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, s => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
    }[s]));
}

// ----------------------------------------------------------
// Hàm toàn cục dùng trong Blade (gọi từ onclick)
// ----------------------------------------------------------
function dongModalXoa() {
    document.getElementById('delete-modal')?.classList.add('hidden');
}

// ----------------------------------------------------------
// Khởi chạy khi DOM sẵn sàng & gắn biến toàn cục cho Blade
// ----------------------------------------------------------
window.BVTV = BVTV;
window.escapeHtml = escapeHtml;
window.dongModalXoa = dongModalXoa;

document.addEventListener('DOMContentLoaded', () => {
    BVTV.initLiveSearch();
    BVTV.initQuickAdd();
    BVTV.initTichChon();
});
