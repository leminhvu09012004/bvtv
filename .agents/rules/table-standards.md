# Quy chuẩn Bảng Dữ Liệu & AJAX (Bắt buộc cho mọi trang)

Theo yêu cầu của người dùng, **TẤT CẢ các trang có bảng dữ liệu** (như Danh sách thuốc, Quản lý danh mục, Chi tiết danh mục...) đều PHẢI tuân thủ các nguyên tắc sau:

## 1. Tích chọn (Checkbox)
- Cột đầu tiên của bảng luôn là checkbox:
  - Header: Checkbox "Chọn tất cả" (`#chon-tat-ca`).
  - Mỗi dòng: Checkbox riêng (`.chon-...`) mang ID bản ghi.
- Khi tích chọn: dòng được chọn phải đổi màu nền nhẹ (`bg-green-50/70`) để nhận diện trực quan.
- Tự động đồng bộ trạng thái: khi tích chọn hết thì "Chọn tất cả" được chọn, khi bỏ chọn một dòng thì "Chọn tất cả" thành indeterminate hoặc bỏ chọn.

## 2. Thanh thao tác hàng loạt (Bulk Action Bar)
- Khi có từ 1 checkbox trở lên được tích, thanh thao tác nổi (`#bulk-action-bar`) sẽ hiện lên:
  - Hiển thị số lượng mục đã chọn.
  - Nút "Bỏ chọn": Hủy chọn toàn bộ.
  - Nút "Xóa các mục đã chọn": Xóa hàng loạt bằng AJAX qua API endpoint.

## 3. Thao tác không tải lại trang (AJAX)
- Mọi thao tác Thêm, Sửa, Xóa (cả xóa 1 và xóa nhiều) đều phải chạy qua AJAX (Fetch API / JSON response).
- Không reload toàn bộ trang:
  - Xóa: Hàng mờ dần và tự biến mất khỏi bảng, cập nhật lại STT và tổng số lượng.
  - Thêm / Sửa: Cập nhật DOM ngay lập tức kèm hiệu ứng highlight 2 giây.
- Hiển thị thông báo Toast thành công (màu xanh) hoặc lỗi (màu đỏ).

## 4. Định hướng Cây trồng Tây Nguyên (Bắt buộc)
Cửa hàng chuyên biệt cho nông nghiệp **Tây Nguyên**, tập trung vào 4 cây trồng chủ lực:
- 🍈 **Sầu riêng** (Rầy xanh, rệp sáp, xì mủ Phytophthora, thán thư...)
- ☕ **Cà phê** (Rỉ sắt, rệp sáp rễ & chùm, mọt đục cành, ve sầu, tuyến trùng...)
- 🌿 **Hồ tiêu** (Bệnh chết nhanh Phytophthora, chết chậm tuyến trùng/Fusarium, bọ xít lưới...)
- 🟣 **Chanh dây** (Đốm dầu vi khuẩn, bã trầu, phấn trắng, bọ trĩ, nhện đỏ...)
- 🥑 Các cây Tây Nguyên khác: **Bơ, Mắc ca, Điều**.

Mọi trang danh sách, bộ lọc, form thêm/sửa, và gợi ý đều phải ưu tiên các cây trồng này.

