import { test, expect } from '@playwright/test';
import { LoginPage } from './pages/LoginPage';
import { EngineerDiseasePage } from './pages/EngineerDiseasePage';

test.describe('E2E — Phân Hệ Kỹ Sư: Cẩm Nang Bệnh Hại & Bộ Lọc Thư Mục', () => {
  let loginPage: LoginPage;
  let diseasePage: EngineerDiseasePage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
    diseasePage = new EngineerDiseasePage(page);

    // 1. Đăng nhập hệ thống với tài khoản Quản trị viên
    await loginPage.login('admin', '1');
  });

  test('TC01 — Navbar Kỹ Sư hiển thị chuẩn, không bị bẻ đôi dòng chữ', async ({ page }) => {
    await diseasePage.goto();

    // Tiêu đề phân hệ
    await expect(diseasePage.brandTitle).toBeVisible();

    // 3 tabs chức năng chính
    await expect(diseasePage.navPhoiTron).toBeVisible();
    await expect(diseasePage.navHoatChat).toBeVisible();
    await expect(diseasePage.navBenhHai).toBeVisible();

    // Tab Bệnh Hại đang được active
    await expect(diseasePage.navBenhHai).toHaveClass(/bg-teal-600/);

    // Kiểm tra không bị ngắt dòng: chữ hiển thị đầy đủ
    await expect(diseasePage.navPhoiTron).toContainText('Kỵ Phối Trộn');
    await expect(diseasePage.navHoatChat).toContainText('Tra Cứu Hoạt Chất');
    await expect(diseasePage.navBenhHai).toContainText('Bệnh Hại & Phác Đồ');
  });

  test('TC02 — Thanh tìm kiếm realtime & Nút xóa ✕ hoạt động chính xác', async ({ page }) => {
    await diseasePage.goto();

    const initialCount = await diseasePage.getVisibleCardsCount();
    
    if (initialCount > 0) {
      // Tìm kiếm khi có dữ liệu
      await diseasePage.search('a');
      const filteredCount = await diseasePage.getVisibleCardsCount();
      expect(filteredCount).toBeLessThanOrEqual(initialCount);

      const displayedText = await diseasePage.getDisplayedCounterText();
      expect(displayedText).toBe(String(filteredCount));

      // Nút xóa '✕' xuất hiện và hoạt động
      await expect(diseasePage.clearSearchBtn).toBeVisible();
      await diseasePage.clearSearch();

      const restoredCount = await diseasePage.getVisibleCardsCount();
      expect(restoredCount).toBe(initialCount);
    } else {
      // Khi đã xóa hết bệnh (DB trống)
      const displayedText = await diseasePage.getDisplayedCounterText();
      expect(displayedText).toBe('0');
      await expect(page.getByText('Chưa có dữ liệu bệnh hại cho tiêu chí đã chọn.')).toBeVisible();
    }
  });

  test('TC03 — Hàng bộ lọc phân loại dịch hại dạng dropdown đồng bộ (4 nhóm + tác nhân)', async ({ page }) => {
    await diseasePage.goto();

    // Kiểm tra dropdown cây trồng và dropdown phân loại dịch hại đều hiển thị dạng dropdown
    await expect(page.locator('#selectCropFilter')).toBeVisible();
    await expect(page.locator('#selectDichHaiFilter')).toBeVisible();

    const initialCount = await diseasePage.getVisibleCardsCount();

    if (initialCount > 0) {
      // 1. Lọc nhóm I: Nấm & Bệnh hại
      await diseasePage.clickFilter('nam_benh');
      await expect(page.locator('#selectDichHaiFilter')).toHaveValue('nam_benh');

      // 2. Lọc nhóm II: Côn trùng chích hút
      await diseasePage.clickFilter('chich_hut');
      await expect(page.locator('#selectDichHaiFilter')).toHaveValue('chich_hut');

      // 3. Lọc nhóm III: Sâu cắn phá & Ruồi
      await diseasePage.clickFilter('sau_hai');
      await expect(page.locator('#selectDichHaiFilter')).toHaveValue('sau_hai');

      // 4. Lọc nhóm IV: Nhện & Tuyến trùng
      await diseasePage.clickFilter('nhen_tuyen_trung');
      await expect(page.locator('#selectDichHaiFilter')).toHaveValue('nhen_tuyen_trung');

      // 5. Quay lại toàn bộ
      await diseasePage.clickFilter('all');
      await expect(page.locator('#selectDichHaiFilter')).toHaveValue('all');
    } else {
      // Khi đã xóa hết bệnh: số lượng trên tất cả các option của dropdown phải là (0), không được có số ảo
      const selectHtml = await page.locator('#selectDichHaiFilter').innerHTML();
      expect(selectHtml).toContain('(0)');
      expect(selectHtml).not.toContain('(14)');
      expect(selectHtml).not.toContain('(6)');
      expect(selectHtml).not.toContain('(4)');
      expect(selectHtml).not.toContain('(2)');

      // Dropdown cây trồng cũng không có số ảo
      const cropHtml = await page.locator('#selectCropFilter').innerHTML();
      expect(cropHtml).not.toContain('8 Bệnh Chuẩn');
      expect(cropHtml).not.toContain('20 Đối Tượng');
    }
  });

  test('TC04 — Xem chi tiết bệnh toàn màn hình hoặc trạng thái danh sách bệnh', async ({ page }) => {
    // Kiểm tra trang danh sách bệnh tải thành công HTTP 200
    const listResponse = await page.goto('/ky-su/benh-hai');
    expect(listResponse?.status()).toBe(200);

    // Kiểm tra nếu có bệnh trong DB thì xem trang chi tiết
    let cardLink = page.locator('.disease-card a[href*="/ky-su/benh-hai/"]').first();
    if (!await cardLink.isVisible()) {
      // Chuyển sang xem Tất cả cây trồng để tìm thẻ bệnh
      await page.goto('/ky-su/benh-hai?crop=all');
      cardLink = page.locator('.disease-card a[href*="/ky-su/benh-hai/"]').first();
    }

    if (await cardLink.isVisible()) {
      const href = await cardLink.getAttribute('href');
      if (href) {
        const detailResponse = await page.goto(href);
        expect(detailResponse?.status()).toBe(200);
        await expect(page.locator('h1')).toBeVisible();
      }
    } else {
      await expect(page.locator('#noSearchResults, .col-span-full').first()).toBeVisible();
    }
  });

  test('TC05 — Nút Chỉnh Sửa Bệnh chuyển hướng sang trang riêng và có phần Quản lý hình ảnh (CRUD)', async ({ page }) => {
    await page.goto('/ky-su/benh-hai?crop=all');
    const cardLink = page.locator('.disease-card a[href*="/ky-su/benh-hai/"]').first();

    if (await cardLink.isVisible()) {
      const href = await cardLink.getAttribute('href');
      if (href) {
        await page.goto(href);
        
        // Nút Chỉnh Sửa Bệnh trên trang chi tiết
        const btnEdit = page.getByRole('link', { name: /Chỉnh Sửa Bệnh/i });
        await expect(btnEdit).toBeVisible();
        await btnEdit.click();

        // Chuyển hướng đến URL chứa /chinh-sua
        await expect(page).toHaveURL(/.*\/chinh-sua/);
        await expect(page.locator('h1')).toContainText('Chỉnh Sửa Thông Tin Bệnh');

        // Xác nhận có phần quản lý hình ảnh và ô chọn file upload
        await expect(page.locator('#cardQuanLyAnh')).toBeVisible();
        await expect(page.locator('input[type="file"]')).toHaveCount(1);
      }
    }
  });
});
