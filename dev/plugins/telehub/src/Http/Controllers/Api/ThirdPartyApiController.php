<?php

namespace Dev\Telehub\Http\Controllers\Api;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\DealerPrice;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\OrderDetail;
use Dev\Telehub\Models\BalanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThirdPartyApiController extends BaseController
{
    private function authenticate(Request $request)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['success' => false, 'message' => 'Missing X-API-KEY header'], 401);
        }

        $customer = BotCustomer::where('api_key', $apiKey)
            ->where('is_dealer', true)
            ->where('status', 'published')
            ->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Invalid or inactive API Key'], 401);
        }

        return $customer;
    }

    public function getUserInfo(Request $request)
    {
        $customer = $this->authenticate($request);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'full_name' => $customer->full_name,
                'username' => $customer->username,
                'telegram_id' => $customer->telegram_id,
                'balance' => $customer->balance,
                'formatted_balance' => number_format($customer->balance, 0, ',', '.') . ' ₫'
            ]
        ]);
    }

    public function getProducts(Request $request)
    {
        $customer = $this->authenticate($request);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        // Lấy tất cả sản phẩm của tenant
        $products = Product::where('tenant_id', $customer->tenant_id)
            ->where('status', 'published')
            ->with(['apiProvider'])
            ->withCount(['items as stock' => function ($query) {
                $query->where('is_sold', false);
            }])
            ->get();

        // Lấy giá sỉ (nếu có)
        $dealerPrices = DealerPrice::where('customer_id', $customer->id)->get()->keyBy('product_id');

        $data = $products->map(function ($product) use ($dealerPrices) {
            $price = $product->price;
            $priceUsd = $product->price_usd;
            $isDealerPrice = false;

            if ($dealerPrices->has($product->id)) {
                $dp = $dealerPrices->get($product->id);
                if (!is_null($dp->price)) {
                    $price = $dp->price;
                }
                if (!is_null($dp->price_usd)) {
                    $priceUsd = $dp->price_usd;
                }
                $isDealerPrice = true;
            }

            // Tồn kho: Nếu là sản phẩm đấu nối API (is_api_product) thì lấy từ api_stock
            // Nếu nhà cung cấp API bị tắt hoặc không hoạt động thì coi như hết hàng (0)
            if ($product->is_api_product) {
                $isProviderActive = $product->apiProvider && in_array($product->apiProvider->status, ['active', '1', 1]);
                $stock = $isProviderActive ? (int) $product->api_stock : 0;
            } else {
                $stock = (int) $product->stock;
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $price,
                'price_usd' => $priceUsd,
                'retail_price' => $product->price,
                'retail_price_usd' => $product->price_usd,
                'is_dealer_price' => $isDealerPrice,
                'stock' => $stock,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function buyProducts(Request $request)
    {
        $customer = $this->authenticate($request);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        $request->validate([
            'product_id' => 'required|integer|exists:telehub_products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $product = Product::where('tenant_id', $customer->tenant_id)
            ->where('status', 'published')
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại hoặc đã bị ẩn.'], 404);
        }

        // Tính giá
        $price = $product->price;
        $priceUsd = null;     // Lưu giá USD gốc để audit
        $exchangeRate = null; // Tỷ giá đã dùng (nếu convert từ USD)
        $dealerPrice = DealerPrice::where('customer_id', $customer->id)->where('product_id', $productId)->first();
        if ($dealerPrice) {
            // Nếu có giá VNĐ trực tiếp
            if (!is_null($dealerPrice->price) && $dealerPrice->price > 0) {
                $price = $dealerPrice->price;
            }
            // Nếu có giá USD, convert sang VNĐ theo tỷ giá từ BotConfig
            elseif (!is_null($dealerPrice->price_usd) && $dealerPrice->price_usd > 0) {
                $priceUsd = (float) $dealerPrice->price_usd;
                $botConfig = \Dev\Telehub\Models\BotConfig::where('tenant_id', $customer->tenant_id)->first();
                $exchangeRate = ($botConfig && $botConfig->usdt_exchange_rate > 0)
                    ? (float) $botConfig->usdt_exchange_rate
                    : 26000;
                $price = round($priceUsd * $exchangeRate);
            }
        }

        $totalAmount = $price * $quantity;

        // Check số dư
        if ($customer->balance < $totalAmount) {
            return response()->json(['success' => false, 'message' => 'Số dư không đủ để thanh toán.'], 400);
        }

        $orderCode = 'API' . strtoupper(\Illuminate\Support\Str::random(6));

        // ========================================================
        // TRƯỜNG HỢP 1: SẢN PHẨM ĐẤU NỐI API TỰ ĐỘNG
        // ========================================================
        if ($product->is_api_product) {
            $provider = \Dev\Telehub\Models\ApiProvider::where('id', $product->api_provider_id)
                ->where('tenant_id', $customer->tenant_id)
                ->where(function ($q) {
                    $q->where('status', 'active')->orWhere('status', '1')->orWhere('status', 1);
                })
                ->first();

            if (!$provider) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng tài khoản trong kho không đủ.'
                ], 400);
            }

            if ($product->api_stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng tài khoản trong kho không đủ.'
                ], 400);
            }

            // Gọi API bên thứ 3 đặt hàng
            $apiResult = $provider->placeOrder((string)$product->api_product_id, $quantity, $orderCode);

            if (!$apiResult['success']) {
                $errDetail = $apiResult['error'] ?? 'Lỗi kết nối';
                $statusCode = $apiResult['status_code'] ?? 0;
                $rawJsonStr = json_encode($apiResult['raw'] ?? []);

                // Nhận diện lỗi thiếu tiền / cạn số dư kho sỉ
                $isInsufficientBalance = (
                    $statusCode === 402
                    || stripos($errDetail, 'balance') !== false
                    || stripos($errDetail, 'credit') !== false
                    || stripos($errDetail, 'số dư') !== false
                    || stripos($errDetail, 'không đủ tiền') !== false
                    || stripos($rawJsonStr, 'balance') !== false
                    || stripos($rawJsonStr, 'insufficient') !== false
                );

                // Báo ngay về Telegram cho Admin
                try {
                    $botConfig = \Dev\Telehub\Models\BotConfig::where('tenant_id', $customer->tenant_id)->first();
                    if ($botConfig && $botConfig->bot_token && $botConfig->telegram_admin_id) {
                        $notifyToken = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
                        $timeVN = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');

                        if ($isInsufficientBalance) {
                            $adminAlert = "⚠️ <b>THÔNG BÁO CẠN SỐ DƯ KHO SỈ (API)</b>\n";
                            $adminAlert .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                            $adminAlert .= "━━━━━━━━━━━━━━━━━━\n";
                            $adminAlert .= "📦 <b>Sản phẩm:</b> {$quantity} x {$product->name}\n";
                            $adminAlert .= "🏢 <b>Kho sỉ:</b> {$provider->name} (ID: #{$provider->id})\n";
                            $adminAlert .= "👤 <b>Khách gọi API:</b> {$customer->full_name} | @{$customer->username} (ID: <code>{$customer->id}</code>)\n";
                            $adminAlert .= "💵 <b>Số dư kho hiện tại:</b> " . number_format($provider->balance, 0, ',', '.') . " " . ($provider->currency ?: 'VND') . "\n";
                            $adminAlert .= "❌ <b>Lỗi chi tiết:</b> <code>" . htmlspecialchars($errDetail) . "</code>\n";
                            $adminAlert .= "👉 <b>Vui lòng nạp thêm tiền vào kho sỉ để đơn tiếp theo không bị nghẽn!</b>";
                        } else {
                            $adminAlert = "⚠️ <b>LỖI ĐẶT HÀNG KHO SỈ (API)</b>\n";
                            $adminAlert .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                            $adminAlert .= "━━━━━━━━━━━━━━━━━━\n";
                            $adminAlert .= "📦 <b>Sản phẩm:</b> {$quantity} x {$product->name}\n";
                            $adminAlert .= "🏢 <b>Kho sỉ:</b> {$provider->name} (ID: #{$provider->id})\n";
                            $adminAlert .= "👤 <b>Khách gọi API:</b> {$customer->full_name} | @{$customer->username} (ID: <code>{$customer->id}</code>)\n";
                            $adminAlert .= "❌ <b>Lỗi:</b> <code>" . htmlspecialchars($errDetail) . "</code> (HTTP {$statusCode})\n";
                        }

                        \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$notifyToken}/sendMessage", [
                            'chat_id' => $botConfig->telegram_admin_id,
                            'text' => $adminAlert,
                            'parse_mode' => 'HTML'
                        ]);
                    }
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to notify admin about API provider error: " . $e->getMessage());
                }

                \Illuminate\Support\Facades\Log::error("buyProducts 3rd party API error for prod {$product->id}: {$errDetail}");

                // Trả về cho khách: Tuyệt đối không để lộ thông tin kho sỉ hay cạn tiền
                if (stripos($errDetail, 'hết hàng') !== false || stripos($errDetail, 'out of stock') !== false || $statusCode === 409) {
                    $clientMessage = 'Số lượng tài khoản trong kho không đủ.';
                } else {
                    $clientMessage = 'Hệ thống đang bận hoặc gián đoạn kết nối, vui lòng thử lại sau giây lát.';
                }

                return response()->json([
                    'success' => false,
                    'message' => $clientMessage
                ], 400);
            }

            // Xử lý định dạng accounts trả về
            $itemsRaw = $apiResult['items'] ?? [];
            $accounts = [];
            if (is_array($itemsRaw) && count($itemsRaw) > 0) {
                foreach ($itemsRaw as $item) {
                    if (is_array($item)) {
                        if (!empty($item['user']) && !empty($item['password'])) {
                            $accStr = $item['user'] . ' | ' . $item['password'];
                            if (!empty($item['verifyEmail'])) $accStr .= ' | ' . $item['verifyEmail'];
                            if (!empty($item['twoFa'])) $accStr .= ' | ' . $item['twoFa'];
                            elseif (!empty($item['2fa'])) $accStr .= ' | ' . $item['2fa'];
                            $accounts[] = $accStr;
                        } else {
                            $accounts[] = $item['value'] ?? $item['content'] ?? $item['account'] ?? $item['data'] ?? $item['credentials'] ?? json_encode($item, JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        $accounts[] = (string) $item;
                    }
                }
            } elseif (!empty($apiResult['data']['message'])) {
                $accounts[] = $apiResult['data']['message'];
            } else {
                $accounts[] = 'Đơn hàng API #' . ($apiResult['order_code'] ?? $orderCode) . ' đã được tiếp nhận.';
            }

            DB::beginTransaction();
            try {
                // Trừ tiền khách hàng
                $customer->balance -= $totalAmount;
                BotCustomer::withoutEvents(function () use ($customer) {
                    $customer->save();
                });

                // Lưu BalanceLog
                $log = new BalanceLog();
                $log->tenant_id = $customer->tenant_id;
                $log->customer_id = $customer->id;
                $log->type = 'decrease';
                $log->amount = $totalAmount;
                $priceNote = $priceUsd ? "\${$priceUsd}/acc × tỷ giá " . number_format($exchangeRate ?? 26000, 0) : number_format($price, 0) . "đ/acc";
                $log->note = "Mua $quantity x {$product->name} @ {$priceNote} (API)";
                $log->save();

                // Tạo Order
                $order = Order::create([
                    'tenant_id' => $customer->tenant_id,
                    'customer_id' => $customer->id,
                    'code' => $orderCode,
                    'total_amount' => $totalAmount,
                    'status' => 'completed',
                    'type' => 'sale',
                    'api_provider_id' => $provider->id,
                    'api_order_code' => $apiResult['order_code'] ?? null,
                    'api_response' => json_encode($apiResult['raw'] ?? $apiResult['data'] ?? []),
                    'api_status' => $apiResult['status'] ?? 'completed',
                ]);

                $log->order_id = $order->id;
                $log->save();

                OrderDetail::create([
                    'tenant_id' => $customer->tenant_id,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'price_usd' => $priceUsd,
                ]);

                // Lưu các accounts nhận được vào ProductItem để tra cứu lịch sử & bảo hành
                foreach ($accounts as $acc) {
                    ProductItem::create([
                        'tenant_id' => $customer->tenant_id,
                        'product_id' => $product->id,
                        'content' => $acc,
                        'is_sold' => true,
                        'customer_id' => $customer->id,
                        'order_id' => $order->id,
                        'status' => 'published',
                    ]);
                }

                // Cập nhật tồn kho api_stock
                if ($product->api_stock >= $quantity) {
                    $product->decrement('api_stock', $quantity);
                } else {
                    $product->api_stock = 0;
                    $product->save();
                }

                // Cập nhật số dư kho sỉ của provider nếu có trả về
                if (isset($apiResult['balance_after']) && !is_null($apiResult['balance_after'])) {
                    $provider->balance = (float) $apiResult['balance_after'];
                    $provider->save();
                }

                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                \Illuminate\Support\Facades\Log::error("buyProducts API order persistence error: " . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Lỗi lưu đơn hàng: ' . $e->getMessage()], 500);
            }

            // Gửi thông báo Telegram (admin + buyer)
            $this->sendTelegramNotification($order, $customer, $product, $quantity, $totalAmount, $accounts, true);

            return response()->json([
                'success' => true,
                'message' => 'Mua hàng thành công!',
                'data' => [
                    'order_id'     => $order->id,
                    'order_code'   => $order->code,
                    'product_name' => $product->name,
                    'quantity'     => $quantity,
                    'total_amount' => $totalAmount,
                    'accounts'     => $accounts,
                    'customer' => [
                        'full_name'    => $customer->full_name,
                        'username'     => $customer->username,
                        'telegram_id'  => $customer->telegram_id,
                        'balance_left' => $customer->balance,
                        'formatted_balance_left' => number_format($customer->balance, 0, ',', '.') . ' ₫',
                    ],
                ]
            ]);
        }

        // ========================================================
        // TRƯỜNG HỢP 2: SẢN PHẨM NỘI BỘ (KHO THƯỜNG)
        // ========================================================
        DB::beginTransaction();
        try {
            // Lock items for update
            $items = ProductItem::where('product_id', $productId)
                ->where('is_sold', false)
                ->limit($quantity)
                ->lockForUpdate()
                ->get();

            if ($items->count() < $quantity) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Số lượng tài khoản trong kho không đủ.'], 400);
            }

            // Trừ tiền
            $customer->balance -= $totalAmount;
            BotCustomer::withoutEvents(function () use ($customer) {
                $customer->save();
            });

            // Lưu log
            $log = new BalanceLog();
            $log->tenant_id = $customer->tenant_id;
            $log->customer_id = $customer->id;
            $log->type = 'decrease';
            $log->amount = $totalAmount;
            $priceNote = $priceUsd ? "\${$priceUsd}/acc × tỷ giá " . number_format($exchangeRate ?? 26000, 0) : number_format($price, 0) . "đ/acc";
            $log->note = "Mua $quantity x {$product->name} @ {$priceNote} (API)";
            $log->save();

            // Tạo Order
            $order = Order::create([
                'tenant_id' => $customer->tenant_id,
                'customer_id' => $customer->id,
                'code' => $orderCode,
                'total_amount' => $totalAmount,
                'status' => 'completed',
                'type' => 'sale',
            ]);

            $log->order_id = $order->id;
            $log->save();

            OrderDetail::create([
                'tenant_id' => $customer->tenant_id,
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'price_usd' => $priceUsd, // Lưu giá USD gốc (nếu là dealer USD price)
            ]);

            $accounts = [];
            foreach ($items as $item) {
                $item->is_sold = true;
                $item->customer_id = $customer->id;
                $item->order_id = $order->id;
                $item->save();

                $accounts[] = $item->content;
            }

            DB::commit();

            // Send Telegram notification
            $this->sendTelegramNotification($order, $customer, $product, $quantity, $totalAmount, $accounts, false);

            return response()->json([
                'success' => true,
                'message' => 'Mua hàng thành công!',
                'data' => [
                    'order_id'     => $order->id,
                    'order_code'   => $order->code,
                    'product_name' => $product->name,
                    'quantity'     => $quantity,
                    'total_amount' => $totalAmount,
                    'accounts'     => $accounts,
                    'customer' => [
                        'full_name'    => $customer->full_name,
                        'username'     => $customer->username,
                        'telegram_id'  => $customer->telegram_id,
                        'balance_left' => $customer->balance,
                        'formatted_balance_left' => number_format($customer->balance, 0, ',', '.') . ' ₫',
                    ],
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }

    private function sendTelegramNotification($order, $customer, $product, $quantity, $totalAmount, array $accounts, bool $isApi = false): void
    {
        try {
            $botConfig = \Dev\Telehub\Models\BotConfig::where('tenant_id', $order->tenant_id)->first();
            if ($botConfig && $botConfig->bot_token && $botConfig->telegram_admin_id) {
                $timeVN = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
                
                $itemsFormatted = "";
                foreach ($accounts as $acc) {
                    $itemsFormatted .= "<code>" . htmlspecialchars($acc) . "</code>\n";
                }

                $message = "🛒 <b>ĐƠN HÀNG MỚI (Từ API)</b>\n";
                $message .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                $orderCodeDisplay = $order->code ? "<code>{$order->code}</code>" : "<code>#{$order->id}</code>";
                $message .= "📝 <b>Mã đơn:</b> {$orderCodeDisplay}\n";
                $message .= "👤 <b>Khách hàng:</b> {$customer->full_name} | @{$customer->username} (ID: <code>{$customer->telegram_id}</code>)\n";
                $message .= "📦 <b>Sản phẩm:</b> {$quantity} x {$product->name}\n";
                $message .= "💵 <b>Tổng thanh toán:</b> " . number_format($totalAmount, 0, ',', '.') . "đ\n";
                $message .= "━━━━━━━━━━━━━━━━━━\n";
                $message .= "📑 <b>Tài khoản bàn giao:</b>\n";
                $message .= $itemsFormatted;

                $notifyToken = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
                \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$notifyToken}/sendMessage", [
                    'chat_id' => $botConfig->telegram_admin_id,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]);

                // Send notification to buyer
                if ($customer->telegram_id) {
                    $buyerMessage = "✅ <b>MUA HÀNG THÀNH CÔNG (Qua API)</b>\n";
                    $buyerMessage .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                    $buyerMessage .= "📝 <b>Mã đơn:</b> {$orderCodeDisplay}\n";
                    $buyerMessage .= "📦 <b>Sản phẩm:</b> {$quantity} x {$product->name}\n";
                    $buyerMessage .= "💵 <b>Tổng thanh toán:</b> " . number_format($totalAmount, 0, ',', '.') . "đ\n";
                    $buyerMessage .= "💳 <b>Số dư còn lại:</b> " . number_format($customer->balance, 0, ',', '.') . "đ\n";
                    $buyerMessage .= "━━━━━━━━━━━━━━━━━━\n";
                    $buyerMessage .= "📑 <b>Tài khoản bàn giao:</b>\n";
                    $buyerMessage .= $itemsFormatted;

                    \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$notifyToken}/sendMessage", [
                        'chat_id' => $customer->telegram_id,
                        'text' => $buyerMessage,
                        'parse_mode' => 'HTML'
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("API Telegram notification error: " . $e->getMessage());
        }
    }

    public function getOrders(Request $request)
    {
        $customer = $this->authenticate($request);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        $limit = $request->input('limit', 20);
        $orders = Order::where('customer_id', $customer->id)
            ->with(['details.product', 'items'])
            ->orderBy('id', 'desc')
            ->paginate($limit);

        $data = $orders->getCollection()->map(function ($order) {
            $accounts = $order->items->pluck('content')->all();

            // Nếu đơn hàng chưa có ProductItem (ví dụ đơn hàng API cũ), trích xuất từ api_response
            if (empty($accounts) && !empty($order->api_response)) {
                $respData = is_string($order->api_response) ? json_decode($order->api_response, true) : $order->api_response;
                $rawItems = $respData['delivery']['accounts'] ?? $respData['data']['delivery']['accounts'] ?? $respData['data']['items'] ?? $respData['data']['accounts'] ?? $respData['items'] ?? $respData['accounts'] ?? $respData['cards'] ?? [];
                if (is_array($rawItems)) {
                    foreach ($rawItems as $item) {
                        if (is_array($item)) {
                            if (!empty($item['user']) && !empty($item['password'])) {
                                $accStr = $item['user'] . ' | ' . $item['password'];
                                if (!empty($item['verifyEmail'])) $accStr .= ' | ' . $item['verifyEmail'];
                                if (!empty($item['twoFa'])) $accStr .= ' | ' . $item['twoFa'];
                                elseif (!empty($item['2fa'])) $accStr .= ' | ' . $item['2fa'];
                                $accounts[] = $accStr;
                            } else {
                                $accounts[] = $item['value'] ?? $item['content'] ?? $item['account'] ?? $item['data'] ?? $item['credentials'] ?? json_encode($item, JSON_UNESCAPED_UNICODE);
                            }
                        } else {
                            $accounts[] = (string) $item;
                        }
                    }
                }
            }

            return [
                'id' => $order->id,
                'code' => $order->code,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                'details' => $order->details->map(function ($detail) {
                    return [
                        'product_name' => $detail->product ? $detail->product->name : 'N/A',
                        'quantity' => $detail->quantity,
                        'price' => $detail->price,
                    ];
                }),
                'accounts' => $accounts
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ]
        ]);
    }
}
