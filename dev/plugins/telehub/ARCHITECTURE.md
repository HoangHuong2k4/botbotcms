# Thiết Kế Kiến Trúc & Quy Tắc Lập Trình Telehub

Tài liệu này trình bày cấu trúc kỹ thuật và các quy tắc phát triển cho plugin Telehub nhằm đảm bảo tính nhất quán trong toàn bộ mã nguồn.

## 🏗️ Kiến Trúc Cốt Lõi & Luồng Logic

Logic của Telehub xoay quanh mô hình SaaS đa người thuê (multi-tenant) cho việc bán hàng qua Telegram Bot.

### 1. Luồng Thanh Toán & Webhook
- **Tạo VietQR**: Mỗi yêu cầu nạp tiền sẽ tạo một `payment_code` duy nhất và một liên kết ảnh VietQR động sử dụng `img.vietqr.io`.
- **Quy trình Webhook Ngân hàng**: 
    1.  Nhận giao dịch từ `thueapibank.vn`.
    2.  Kiểm tra trùng lặp `tran_id_bank` trong bảng `telehub_bank_webhooks`.
    3.  Khớp `payment_code` từ mô tả giao dịch bằng Regex.
    4.  Cập nhật trạng thái `telehub_deposit_requests` và cộng số dư vào `telehub_bot_customers.balance`.
- **Luồng Mua Hàng**: Khách hàng sử dụng số dư để mua sản phẩm. Hệ thống chọn một mục chưa bán từ `telehub_product_items`, gửi qua bot và đánh dấu là đã bán.

---

## 🛠️ Quy Tắc Mã Nguồn & Tiêu Chuẩn

### 1. Quy Tắc Đặt Tên Bảng Cơ Sở Dữ Liệu
> [!IMPORTANT]
> Tất cả các bảng cơ sở dữ liệu liên quan đến plugin này **BẮT BUỘC** phải sử dụng tiền tố `telehub_`. Điều này đảm bảo sự cách ly hoàn toàn với các bảng cốt lõi của CMS và các plugin khác.

- **Sai**: `tenants`, `bot_configs`
- **Đúng**: `telehub_tenants`, `telehub_bot_configs`

### 2. Cách Ly Logic (Logic Isolation)
> [!CAUTION]
> Tất cả logic backend, bao gồm business logic, helpers, và handlers, **PHẢI** nằm trong thư mục `dev/plugins/telehub`. Tuyệt đối không sửa đổi các file cốt lõi của hệ thống.

- Sử dụng namespace `Dev\Telehub\`.
- Tất cả các file Model đặt trong `src/Models/`.
- Tất cả logic Form/Table đặt trong `src/Forms/` và `src/Tables/`.

### 3. Hướng Dẫn Lập Trình
- **Tính Nhất Quán Giao Dịch**: Luôn sử dụng SQL Transaction khi thay đổi nhiều bảng dữ liệu cùng lúc (ví dụ: trừ tiền và gửi mã sản phẩm).
- **Bảo Mật**: Kiểm tra IP nguồn của Webhook và sử dụng secret key để xác thực.
- **Cronjobs**: Tự động hóa việc dọn dẹp các yêu cầu nạp tiền đã hết hạn (ví dụ: > 30 phút).

---

## 📊 Chi Tiết Cấu Trúc Bảng (Đã Tối Ưu)

Tất cả các bảng đều sử dụng tiền tố `telehub_` theo quy tắc lập trình.

| Tên Bảng | Mô Tả | Các Cột Chính |
| :--- | :--- | :--- |
| `telehub_tenants` | Thông tin đăng nhập của người thuê (Admin Web). | `id`, `username`, `email`, `status` |
| `telehub_bot_configs` | Cấu hình Bot và thông tin VietQR/Ngân hàng. | `id`, `tenant_id`, `bot_token`, `bank_code` |
| `telehub_products` | Thông tin chi tiết và giá cả sản phẩm. | `id`, `name`, `price` |
| `telehub_product_items` | Kho hàng thực tế (Tài khoản/Mật khẩu hoặc Key). | `id`, `product_id`, `content`, `is_sold` |
| `telehub_bot_customers` | Thông tin khách hàng Telegram và số dư. | `id`, `tenant_id`, `telegram_id`, `balance` |
| `telehub_balance_logs` | Lịch sử biến động số dư (Nạp/Tiêu). | `id`, `customer_id`, `type`, `amount` |
| `telehub_deposit_requests` | Các yêu cầu nạp tiền đang chờ khớp Webhook. | `id`, `customer_id`, `amount`, `payment_code`, `status` |
| `telehub_bank_webhooks` | Lịch sử nhận thông báo ngân hàng (chống nạp trùng). | `id`, `tenant_id`, `tran_id_bank`, `raw_json` |

---

*Lưu ý: Để phát triển tiếp, hãy tuân theo các pattern Repository/Service của Botble để duy trì tính tương thích.*
