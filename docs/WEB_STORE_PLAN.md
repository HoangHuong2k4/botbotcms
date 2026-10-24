# Kế Hoạch Xây Dựng Web App (cataishop.shop)

Tài liệu này mô tả chi tiết các thay đổi cần thiết về cơ sở dữ liệu (Database), API và kiến trúc thư mục để xây dựng trang web bán hàng (E-commerce). Hệ thống Web sẽ chạy chung Database với Botble CMS & Bot Telegram nhưng nội dung hiển thị được **tách biệt hoàn toàn**.

## 1. Kiến Trúc Thư Mục (Monorepo thu nhỏ)

Để tiện quản lý, backup và đẩy code (git), thư mục chứa source code của Frontend Web (Next.js) sẽ được đặt trực tiếp bên trong thư mục dự án hiện tại của bạn:

```text
/opt/1panel/apps/openresty/openresty/www/sites/cms.cataishop.shop/index/
 ├── app/                   # Source gốc Botble CMS
 ├── plugins/telehub/       # Plugin Telegram Bot 
 ├── api-tele/              # Source Nodejs Webhook & Ngân hàng
 ├── docs/                  # Tài liệu hệ thống
 └── web-frontend/          # [MỚI] Source Frontend Web (Next.js)
```

Trên 1Panel, bạn chỉ việc tạo Website Node.js mới, trỏ Domain `cataishop.shop` vào đúng đường dẫn `.../index/web-frontend` là xong.

---

## 2. Nâng Cấp Cơ Sở Dữ Liệu (CMS) - Tách Biệt Hoàn Toàn Tele/Web

Tất cả thông tin dành cho Web sẽ được tạo ở **các cột riêng biệt có hậu tố `_web`**. Điều này đảm bảo: **0% rủi ro ảnh hưởng tới Bot Telegram đang chạy.**

### A. Quản lý Sản Phẩm (`telehub_products`)
Tạo Migration thêm các cột sau với hậu tố `_web` (mặc định là `nullable()`):
- `name_web` (string): Tên sản phẩm chuẩn SEO (không emoji).
- `image_web` (string): Ảnh đại diện chính trên trang chủ.
- `images_web` (json): Danh sách các ảnh phụ (Gallery).
- `description_web` (text): Mô tả ngắn (Meta description).
- `content_web` (longtext): Nội dung chi tiết bài viết sản phẩm (Rich Text/HTML).
- `price_web` (decimal): Giá bán trên Web.
- `status_web` (boolean, default: false): Cờ bật/tắt hiển thị sản phẩm này trên Web.
- **Slug:** Tận dụng bảng `slugs` của Botble để quản lý tự động.

### B. Quản lý Khách Hàng Web (`telehub_web_customers`)
Khách mua trên Web sẽ được quản lý ở một bảng hoàn toàn mới:
- Bảng `telehub_web_customers`: `name`, `email`, `phone`, `password`, `avatar`.

### C. Đơn Hàng & Giỏ Hàng (`telehub_orders`)
Tiếp tục sử dụng bảng đơn hàng hiện tại nhưng thêm các cột riêng cho Web:
- `web_customer_id` (bigint, nullable): Liên kết với bảng khách hàng web.
- `source` (string, default: 'telegram'): Đánh dấu nguồn đơn hàng (`'telegram'` hoặc `'web'`).
- `payment_method_web` (string, nullable): Phương thức thanh toán riêng của web (qr_vnd, usdt).
- `shipping_address_web` (text, nullable): Địa chỉ nhận hàng.
- `tracking_code_web` (string, nullable): Mã vận đơn.

---

## 3. Quy trình thực hiện (Workflow)

Theo yêu cầu, quy trình sẽ diễn ra như sau:
1. **Bước 1: Khởi tạo UI Frontend (Fake Data)**
   - Khởi tạo Next.js trong thư mục `web-frontend`.
   - Code giao diện (Trang chủ, Chi tiết SP, Giỏ hàng, Đăng nhập) sử dụng dữ liệu giả (mock data).
   - Đảm bảo thiết kế siêu đẹp, màu sắc hài hoà, có animation hiện đại.
2. **Bước 2: Cập nhật CMS Backend**
   - Tạo Migration thêm cột `_web`.
   - Update giao diện Admin Botble (thêm Tab "Cấu hình Web" trong phần chỉnh sửa Product).
3. **Bước 3: Đấu nối API**
   - Viết API lấy dữ liệu sản phẩm, xử lý giỏ hàng, thanh toán.
   - Gọi API từ Frontend để thay thế Mock Data bằng Dữ liệu thật.

### FIXED ISSUES
- **Telegram Bot Timeout (ETIMEDOUT):** Fixed by forcing IPv4 resolution for `api.telegram.org` in `/etc/hosts`. The VPS IPv6 network is unreachable.
