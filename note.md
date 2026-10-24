Chào Hương, đây là bản thiết kế Full Stack A-Z cho hệ thống SaaS Bot Telegram bán hàng của bạn. Bản này kết hợp tất cả các ý tưởng từ: Quản lý khách thuê (Tenant), Ví tiền, Kho hàng tự động, Webhook Ngân hàng và tích hợp VietQR.

1. Mục đích & Mô hình Hoạt động (Business Logic)
   Hệ thống hoạt động theo mô hình tự động hóa hoàn toàn:
1. Chủ hệ thống (Bạn): Cung cấp Website quản lý cho người thuê.
1. Người thuê (Tenant - VD: Hương MMO): Đăng nhập -> Nhập Bot Token -> Cấu hình STK Ngân hàng -> Thêm sản phẩm & Kho hàng.
1. Khách mua hàng (End-user): Vào Bot Telegram -> Nạp tiền (Quét mã VietQR) -> Tiền cộng vào Ví Bot -> Chọn mua sản phẩm -> Bot tự gửi tài khoản/key.

1. Cấu trúc Database Chi tiết (Full Schema)
   Bạn có thể sử dụng Schema này để tạo bảng trong MySQL/PostgreSQL.
   A. Nhóm Quản lý Người thuê (Tenants & Config)
   Bảng Cột Mô tả
   tenants id, username, password, email, status Tài khoản đăng nhập Web Admin.
   bot_configs id, tenant_id, bot_token, bank_code, bank_num, bank_name, qr_template Cấu hình Bot và thông tin VietQR của từng chủ Bot.
   B. Nhóm Sản phẩm & Kho hàng (Inventory)
   Bảng Cột Mô tả
   categories id, tenant_id, name Danh mục (Ví dụ: Tool AI, Netflix...).
   products id, category_id, name, price, description Thông tin sản phẩm.
   product_items id, product_id, content, is_sold, order_id Kho hàng: Lưu dữ liệu thực tế (User|Pass) để bán.
   C. Nhóm Khách hàng & Ví tiền (Customer & Wallet)
   Bảng Cột Mô tả
   bot_customers id, tenant_id, telegram_id, fullname, balance Thông tin khách và số dư ví trên Bot.
   balance_logs id, customer_id, type (IN/OUT), amount, note Lịch sử biến động tiền (Nạp/Tiêu).
   D. Nhóm Giao dịch & Webhook (Payment)
   Bảng Cột Mô tả
   deposit_requests id, customer_id, amount, payment_code, status Lưu yêu cầu nạp tiền để chờ khớp Webhook.
   bank_webhooks id, tenant_id, tran_id_bank, amount, description, raw_json Lưu lịch sử từ thueapibank.vn để chống nạp trùng.
1. Quy trình Xử lý Kỹ thuật (Workflow)
   Bước 1: Tạo Mã QR Nạp Tiền (VietQR)
   Khi khách gõ lệnh nạp tiền trên Bot:
1. Hệ thống tạo mã payment_code duy nhất (VD: NAP14838).
1. Tạo Link ảnh VietQR:https://img.vietqr.io/image/mbbank-0932507102-compact.png?amount=100000&addInfo=NAP14838&accountName=PHAM HOANG HUONG
1. Bot gửi ảnh này kèm hướng dẫn chuyển khoản.
   Bước 2: Xử lý Webhook (Dựa trên Data Demo)
   Khi có tiền vào, thueapibank.vn gọi đến API của bạn:
1. Duyệt mảng transactions: Lấy transactionID, amount, description.
1. Kiểm tra trùng: Check transactionID trong bảng bank_webhooks. Nếu đã có -> Bỏ qua.
1. Khớp mã: Dùng Regex tách mã NAP14838 từ description.
1. Cập nhật:
   _ Chuyển deposit_requests.status thành success.
   _ Cộng tiền vào bot_customers.balance. \* Bot gửi tin nhắn Telegram thông báo cho khách.
   Bước 3: Mua hàng & Trả Code
1. Khách chọn Sản phẩm -> Nhấn "Mua".
1. Hệ thống trừ tiền trong ví (balance).
1. Lấy 1 dòng từ product_items (nơi is_sold = 0).
1. Gửi content (tài khoản) cho khách và đánh dấu is_sold = 1.

1. Các Công nghệ Đề xuất (Tech Stack)

- Backend: Node.js (Express hoặc NestJS) + TypeScript.
- Database: MySQL (Dễ quản lý quan hệ bảng).
- Telegram Library: telegraf (Phổ biến và mạnh mẽ).
- Frontend Admin: React + TailwindCSS + Lucide Icons (Cho giao diện đẹp).
- QR API: VietQR.io (Miễn phí tạo link ảnh).
- Webhook Source: thueapibank.vn.

5. Lưu ý cho "Pro"

- Bảo mật: Luôn kiểm tra IP hoặc Secret Key của Webhook gửi tới để tránh người khác giả mạo giao dịch nạp tiền.
- Transaction: Khi trừ tiền ví và lấy code, hãy dùng SQL Transaction để đảm bảo nếu lấy code lỗi thì tiền không bị trừ (và ngược lại).
- Cronjob: Viết một script nhỏ để tự động hủy các deposit_requests quá 30 phút mà khách không chuyển khoản.
  Với bộ tài liệu từ A-Z này, Hương đã có một bản thiết kế hệ thống SaaS hoàn chỉnh. Bạn có muốn mình viết mẫu đoạn code Regex để bóc tách mã nạp từ cái description mẫu bạn gửi không?
