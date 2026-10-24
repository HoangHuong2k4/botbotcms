# Phương án tối ưu hóa hiệu năng Website: tlfparts.nl (Mobile)

Tài liệu này tổng hợp các vấn đề kỹ thuật đang gây ảnh hưởng nghiêm trọng đến trải nghiệm người dùng và điểm chất lượng trên Google (Core Web Vitals).

## 📊 Chỉ số hiện tại
| Chỉ số | Kết quả | Trạng thái | Mục tiêu |
| :--- | :--- | :--- | :--- |
| **Performance Score** | **42/100** | 🔴 Kém | > 90 |
| **Largest Contentful Paint (LCP)** | **14.7s** | 🔴 Rất chậm | < 2.5s |
| **Cumulative Layout Shift (CLS)** | **0.146** | 🟠 Cần cải thiện | < 0.1 |
| **Total Blocking Time (TBT)** | **370ms** | 🟠 Trung bình | < 200ms |

---

## 🔴 1. Lỗi Ưu tiên Cao (Cần xử lý ngay)

### 1.1. Loại bỏ các tài nguyên chặn hiển thị (Eliminate render-blocking resources)
*   **Vấn đề:** Các tệp CSS (FontAwesome, Style chính) và JavaScript đang ngăn cản trình duyệt vẽ trang ngay lập tức. Tiết kiệm ước tính: **3.3 giây**.
*   **Cách tối ưu chi tiết:**
    *   **Trích xuất Critical CSS:** Tách phần CSS cần thiết để hiển thị phần đầu trang (Above the Fold) và nhúng trực tiếp vào thẻ `<style>` trong `<head>`.
    *   **Trì hoãn Load CSS non-critical:** Sử dụng `rel="preload"` cho các tệp CSS còn lại và chuyển chúng xuống cuối trang hoặc load bất đồng bộ.
    *   **Defer JavaScript:** Đảm bảo tất cả các thẻ `<script>` không thiết yếu đều có thuộc tính `defer` hoặc `async`.

### 1.2. Hiển thị Font chữ trong quá trình tải (Font display)
*   **Vấn đề:** Văn bản bị ẩn cho đến khi font chữ (Google Fonts, FontAwesome) được tải xong, gây hiện tượng nhấp nháy hoặc khoảng trắng.
*   **Cách tối ưu chi tiết:**
    *   Thêm quy tắc `font-display: swap;` vào tất cả các khai báo `@font-face` trong tệp CSS. Điều này cho phép trình duyệt sử dụng font hệ thống thay thế trong lúc chờ font web tải về.

### 1.3. Thời gian thực thi JavaScript & Công việc luồng chính (Main-thread work)
*   **Vấn đề:** JavaScript chiếm dụng luồng chính quá lâu (**2.1s - 3.2s**), đặc biệt là từ các bên thứ ba như Google reCAPTCHA và Cloudflare Rocket Loader.
*   **Cách tối ưu chi tiết:**
    *   **Kiểm tra Script bên thứ ba:** Chỉ tải reCAPTCHA khi người dùng bắt đầu tương tác với Form (Lazy load scripts).
    *   **Chia nhỏ Tasks:** Sử dụng `Web Workers` cho các tác vụ tính toán nặng hoặc chia nhỏ các hàm JS dài để tránh khóa luồng chính.

---

## 🟠 2. Lỗi Ưu tiên Trung bình (Giảm dung lượng trang)

### 2.1. Sử dụng định dạng hình ảnh hiện đại (Next-gen formats)
*   **Vấn đề:** Nhiều ảnh vẫn đang dùng định dạng PNG/JPG cũ. Tiết kiệm ước tính: **~2.8 MB**.
*   **Cách tối ưu chi tiết:**
    *   Sử dụng công cụ (như ImageMagick hoặc plugin CMS) để chuyển đổi toàn bộ ảnh sang định dạng **WebP** hoặc **AVIF**.
    *   Cấu hình Server để tự động trả về định dạng ảnh phù hợp tùy theo trình duyệt.

### 2.2. Phân phối ảnh có kích thước phù hợp (Properly size images)
*   **Vấn đề:** Tải ảnh có kích thước lớn hơn nhiều so với khung hiển thị trên điện thoại.
*   **Cách tối ưu chi tiết:**
    *   Sử dụng thuộc tính `srcset` trong thẻ `<img>` để trình duyệt tự chọn ảnh có kích thước phù hợp nhất với độ phân giải màn hình.

### 2.3. Thiếu kích thước cố định cho ảnh (Explicit width/height)
*   **Vấn đề:** Đây là nguyên nhân chính gây ra lỗi CLS (nhảy bố cục).
*   **Cách tối ưu chi tiết:**
    *   Luôn khai báo thuộc tính `width` và `height` trong thẻ HTML của ảnh. Trình duyệt sẽ dành sẵn khoảng trống cho ảnh trước khi nó tải xong.

---

## 🛡️ 3. Quyền truy cập & SEO (Accessibility & Best Practices)

### 3.1. Tên hiển thị cho Nút và Liên kết (Accessible name)
*   **Vấn đề:** Các nút Menu, tìm kiếm hoặc Icon mạng xã hội không có văn bản đi kèm.
*   **Cách tối ưu:** Thêm thuộc tính `aria-label` cho các phần tử chỉ có icon (Ví dụ: `<button aria-label="Open Menu">`).

### 3.2. Thuộc tính Alt cho hình ảnh
*   **Vấn đề:** Nhiều ảnh thiếu mô tả nội dung.
*   **Cách tối ưu:** Bổ sung thuộc tính `alt="..."` cho tất cả các thẻ ảnh để hỗ trợ người khiếm thị và cải thiện SEO hình ảnh.

---

## 🚀 Lộ trình triển khai (Action Plan)
1.  **Giai đoạn 1 (Ngày 1-2):** Tối ưu hóa ảnh (chuyển sang WebP) và cố định kích thước ảnh để fix CLS.
2.  **Giai đoạn 2 (Ngày 3-5):** Xử lý tài nguyên chặn hiển thị (Inlining Critical CSS) và sửa thuộc tính `font-display`.
3.  **Giai đoạn 3 (Ngày 6-10):** Tối ưu hóa scripts bên thứ ba (reCAPTCHA, GTM) và trì hoãn load các JS nặng.
