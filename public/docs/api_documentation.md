# Tài Liệu Tích Hợp API - Telehub (Dành Cho Cộng Tác Viên)

Tài liệu này hướng dẫn cách kết nối hệ thống của bên thứ ba vào hệ thống Telehub để lấy danh sách sản phẩm, kiểm tra số dư và tự động mua tài khoản.

## Xác thực (Authentication)

Tất cả các API đều yêu cầu gửi kèm Header `X-API-KEY`.
API Key được cấp bởi Admin trong trang Quản lý Cộng Tác Viên.

**Ví dụ Header:**
```http
X-API-KEY: DLR_a94daf26342ddcbf0ba6843bbbbb125c
```

---

## 1. Lấy Thông Tin & Số Dư

- **URL:** `/api/v1/telehub/user`
- **Method:** `GET`
- **Headers:** `X-API-KEY`

### Response Mẫu (Thành công)
```json
{
    "success": true,
    "data": {
        "full_name": "Hương",
        "username": "ZeroBit2k4",
        "telegram_id": 7353915691,
        "balance": 393195000.0,
        "formatted_balance": "393.195.000 ₫"
    }
}
```

---

## 2. Lấy Danh Sách Sản Phẩm

- **URL:** `/api/v1/telehub/products`
- **Method:** `GET`
- **Headers:** `X-API-KEY`

Lưu ý: API sẽ tự động trả về **Giá Sỉ (Dealer Price)** nếu bạn đã được Admin cài đặt giá sỉ riêng cho sản phẩm đó. Cột `is_dealer_price` sẽ trả về `true` nếu đó là giá sỉ.

### Response Mẫu
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Tài khoản Telegram Trust",
            "price": 10000,
            "price_usd": null,
            "retail_price": 15000,
            "retail_price_usd": null,
            "is_dealer_price": true,
            "stock": 420
        },
        {
            "id": 66,
            "name": "Capcut Pro Team 7D",
            "price": 10000,
            "price_usd": null,
            "retail_price": 10000,
            "retail_price_usd": null,
            "is_dealer_price": false,
            "stock": 30
        }
    ]
}
```

---

## 3. Mua Tài Khoản

- **URL:** `/api/v1/telehub/buy`
- **Method:** `POST`
- **Headers:** `X-API-KEY`, `Content-Type: application/json`

### Body (JSON)
```json
{
    "product_id": 1,
    "quantity": 2
}
```

### Response Mẫu (Thành công)
```json
{
    "success": true,
    "message": "Mua hàng thành công!",
    "data": {
        "order_id": 109,
        "total_amount": 20000,
        "balance_left": 393175000.0,
        "accounts": [
            "0331234567 | pass123 | note 1",
            "0331234568 | pass456 | note 2"
        ]
    }
}
```

### Response Mẫu (Lỗi thiếu số dư)
```json
{
    "success": false,
    "message": "Số dư không đủ để thanh toán."
}
```

### Response Mẫu (Lỗi hết hàng)
```json
{
    "success": false,
    "message": "Số lượng tài khoản trong kho không đủ."
}
```
