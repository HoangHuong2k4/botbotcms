# Telehub - Telegram Sales Bot SaaS

Telehub là một hệ thống SaaS mạnh mẽ, tự động hóa hoàn toàn quy trình bán hàng qua Telegram Bot. Plugin này tích hợp mượt mà với Botble CMS để cung cấp nền tảng quản lý cho các chủ bot (Tenants) quản lý kho hàng, thanh toán và tương tác với khách hàng.

## 🚀 Tính Năng Chính

- **Hỗ Trợ Đa Người Thuê (Multi-Tenant)**: Mỗi người thuê có thể quản lý bot, sản phẩm và cấu hình riêng biệt.
- **Kho Hàng Tự Động**: Bán tài khoản, mã bản quyền hoặc bất kỳ sản phẩm số nào với tính năng tự động gửi hàng.
- **Tích Hợp Thanh Toán VietQR**: Hệ thống nạp tiền tự động với mã QR động và Webhook ngân hàng thời gian thực.
- **Bảng Quản Trị Chuyên Nghiệp**: Giao diện thân thiện để quản lý bot, danh mục, sản phẩm và lịch sử bán hàng.
- **Quản Lý Webhook**: Hỗ trợ lưu trữ log webhook ngân hàng và chống nạp trùng giao dịch.

## 🛠️ Công Nghệ Sử Dụng

- **Framework**: Laravel 7.x / 10.x (Botble CMS Core)
- **Cơ Sở Dữ Liệu**: MySQL / PostgreSQL
- **Bot Engine**: Telegram Bot API / Telegraf
- **Frontend**: Blade + Vanilla JS + CSS (Rich Aesthetics)
- **Thanh Toán**: VietQR.io + thueapibank.vn (Webhook)

## 📦 Cài Đặt

Để cài đặt plugin Telehub, hãy đảm bảo bạn đã cài đặt Botble CMS và làm theo các bước sau:

1. Sao chép thư mục `telehub` vào `dev/plugins/`.
2. Chạy migration: `php artisan migrate`.
3. Kích hoạt plugin trong bảng quản trị Botble Admin Panel.

---

Để biết thêm chi tiết kỹ thuật, vui lòng xem [ARCHITECTURE.md](./ARCHITECTURE.md).
