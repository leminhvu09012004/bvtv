# 🌿 Sổ Tay Thuốc Bảo Vệ Thực Vật (BVTV) — Tây Nguyên

Hệ thống tra cứu, quản lý danh mục và cơ sở dữ liệu thuốc Bảo vệ thực vật (BVTV) điện tử, chuyên biệt cho các nhà vườn và đại lý nông nghiệp khu vực **Tây Nguyên** tập trung vào 4 loại cây trồng chủ lực: **Sầu riêng, Cà phê, Hồ tiêu, Chanh dây** (cùng Bơ và Mắc ca).

---

## 🚀 Tính năng nổi bật

- **⚡ Tìm kiếm trực tiếp (Live Search AJAX)**: Gõ từ khóa tên thuốc, hoạt chất, công dụng, cây trồng — kết quả hiển thị tức thì không cần tải lại trang (debounce 350ms).
- **🌾 Bộ lọc chuyên biệt Tây Nguyên**: Thanh lọc nhanh theo Sầu riêng, Cà phê, Tiêu, Chanh dây.
- **📁 Quản lý Danh mục phân loại**: Quản lý nhóm thuốc (Thuốc trừ sâu, trừ bệnh, trừ cỏ, trừ nhện, v.v.) qua AJAX kèm emoji trực quan.
- **☑️ Checkbox & Thao tác hàng loạt (Bulk Actions)**: Tích chọn từng dòng hoặc chọn tất cả, xóa hàng loạt qua AJAX mượt mà.
- **📷 Quản lý Hình ảnh bao bì & nhãn thuốc**:
  - Hỗ trợ tải lên ảnh bao bì thuốc thực tế (JPG, PNG, WEBP).
  - Xem trước ảnh trực tiếp (Live preview) trước khi lưu.
  - Hiển thị ảnh đại diện (Thumbnail) trên bảng danh sách.
  - Modal phóng to (Lightbox) xem rõ chi tiết nhãn thuốc, quy cách đóng gói và liều lượng.
  - Tự động dọn dẹp file ảnh trên ổ đĩa khi xóa hoặc cập nhật thuốc.
- **📊 Bảng thống kê tổng quan (Dashboard)**: Thống kê số lượng thuốc theo từng cây trồng chủ lực Tây Nguyên.
- **📑 Xuất/Nhập dữ liệu CSV**: Hỗ trợ xuất và nhập danh sách thuốc BVTV ra file Excel/CSV chuẩn UTF-8 BOM.

---

## 🛠️ Công nghệ sử dụng

- **Backend**: PHP 8.2+, Laravel 12
- **Database**: MySQL (hỗ trợ cascade deletion)
- **Frontend**: Blade Templates, TailwindCSS, Vanilla JavaScript (ES Modules qua Vite)
- **Storage**: Laravel Public Storage Symlink (`public/storage`)

---

## 💻 Cài đặt và chạy dự án

### 1. Yêu cầu môi trường
- PHP >= 8.2 (kèm các extension: `pdo_mysql`, `gd`, `fileinfo`, `curl`, `mbstring`)
- Composer
- Node.js & npm
- MySQL Server

### 2. Các bước cài đặt
```bash
# 1. Clone repository
git clone https://github.com/leminhvu09012004/bvtv.git
cd bvtv

# 2. Cài đặt các thư viện PHP & JS
composer install
npm install

# 3. Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# 4. Cấu hình Database trong file .env
# DB_DATABASE=baovethucvat
# DB_USERNAME=root
# DB_PASSWORD=...

# 5. Chạy Migration và nạp dữ liệu mẫu Tây Nguyên
php artisan migrate
php artisan db:seed

# 6. Tạo liên kết lưu trữ ảnh
php artisan storage:link

# 7. Biên dịch assets
npm run build

# 8. Khởi chạy server phát triển
php artisan serve
```

Truy cập hệ thống tại: `http://localhost:8000`

---

## 📄 Bản quyền
Phát triển bởi **Lê Minh Vũ** — Dành cho nông nghiệp Tây Nguyên.
