<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\ProductItem;

// Lấy username từ biến GET (mặc định là rỗng nếu chưa nhập)
$searchUsername = $_GET['username'] ?? '';
$searchUsername = str_replace('@', '', trim($searchUsername)); // Bỏ dấu @ nếu người dùng có nhập

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tra cứu thống kê mua hàng</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; background-color: #f8f9fa; }
        .form-container { margin-bottom: 20px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .result-container { padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; }
        th { background-color: #f1f3f5; }
        ul { list-style: none; padding-left: 0; }
        li { padding: 5px 0; font-size: 16px; }
        .text-danger { color: #dc3545; }
    </style>
</head>
<body>

<div class="form-container">
    <h2><span style="font-size: 24px;">🔍</span> Tra cứu khách hàng Telegram</h2>
    <form method="GET" action="">
        <label for="username" style="display: block; margin-bottom: 8px; font-weight: bold;">Nhập Username hoặc ID Telegram:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($searchUsername); ?>" placeholder="VD: ZeroBit2k4 hoặc @ZeroBit2k4 hoặc ID" autofocus>
        <button type="submit">Tra Cứu</button>
    </form>
</div>

<?php
if ($searchUsername !== '') {
    echo "<div class='result-container'>";
    
    // 1. Tìm customer
    $customer = BotCustomer::where('username', $searchUsername)->orWhere('telegram_id', $searchUsername)->first();

    if (!$customer) {
        echo "<h3 class='text-danger'>❌ Không tìm thấy người dùng có username hoặc ID là: " . htmlspecialchars($searchUsername) . "</h3>";
    } else {
        // 2. Lọc đơn hàng của user này
        $ordersCount = Order::where('customer_id', $customer->id)
            ->where('status', 'completed')
            ->count();

        $totalAmount = Order::where('customer_id', $customer->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        // 3. Đếm số tài khoản (items) đã mua (không tính đơn bảo hành nếu muốn)
        // Lấy tất cả item nằm trong các đơn hàng thành công của customer
        $itemsCount = ProductItem::where('customer_id', $customer->id)
            ->where('is_sold', true)
            ->count();

        echo "<h2>Thống kê mua hàng của @" . htmlspecialchars($customer->username) . "</h2>";
        echo "<ul>";
        echo "<li><strong>Telegram ID:</strong> {$customer->telegram_id}</li>";
        echo "<li><strong>Tổng số đơn hàng thành công:</strong> <span style='color: #28a745; font-weight: bold;'>{$ordersCount}</span> đơn</li>";
        echo "<li><strong>Tổng số tài khoản đã mua:</strong> <span style='color: #007bff; font-weight: bold;'>{$itemsCount}</span> acc</li>";
        echo "<li><strong>Tổng tiền đã chi:</strong> <span style='color: #dc3545; font-weight: bold;'>" . number_format($totalAmount, 0, ',', '.') . " ₫</span></li>";
        echo "</ul>";

        echo "<h3>Chi tiết các đơn hàng (Mới nhất):</h3>";
        $orders = Order::with('items')->where('customer_id', $customer->id)->where('status', 'completed')->orderBy('id', 'desc')->get();
        if ($orders->count() > 0) {
            echo "<table>";
            echo "<tr><th>Mã Đơn</th><th>Ngày Mua</th><th>Tổng Tiền</th><th>Loại Đơn</th></tr>";
            foreach ($orders as $order) {
                $type = $order->type === 'warranty' ? '<span style="color:red">Bảo hành</span>' : '<span style="color:blue">Bán ra</span>';
                echo "<tr>";
                echo "<td>#{$order->id}</td>";
                echo "<td>{$order->created_at}</td>";
                echo "<td><strong>" . number_format($order->total_amount, 0, ',', '.') . " ₫</strong></td>";
                echo "<td>{$type}</td>";
                echo "</tr>";
                
                // Hiển thị tài khoản đã mua
                if ($order->items && $order->items->count() > 0) {
                    echo "<tr>";
                    echo "<td colspan='4' style='background-color: #f8f9fa; padding: 10px 20px;'>";
                    echo "<div style='font-family: monospace; font-size: 14px; color: #333;'>";
                    foreach ($order->items as $item) {
                        echo htmlspecialchars($item->content) . "<br>";
                    }
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p>Chưa có đơn hàng nào thành công.</p>";
        }
    }
    echo "</div>";
}
?>
</body>
</html>
