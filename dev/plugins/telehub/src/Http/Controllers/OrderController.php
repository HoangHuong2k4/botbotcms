<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dev\Base\Facades\Assets;
use Dev\Telehub\Models\DepositRequest;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle("Đơn hàng (Orders)");
        Assets::usingVueJS();

        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $paymentCode = $request->input('payment_code', '');

        return view('plugins/telehub::orders', compact('isAdmin', 'paymentCode'));
    }

    private function buildOrderFilterQuery(Request $request, $isAdmin)
    {
        $paymentCode = trim((string) $request->input('payment_code', ''));
        $code = trim((string) $request->input('code', ''));
        $search = trim((string) $request->input('search', ''));
        $email = trim((string) $request->input('email', ''));

        $query = Order::from('telehub_orders');

        $tenantId = null;
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $tenantId = $tenant->id;
                $query->where('telehub_orders.tenant_id', $tenantId);
            }
        }

        if ($paymentCode !== '') {
            $depQuery = DepositRequest::where('payment_code', $paymentCode);
            if ($tenantId) {
                $depQuery->where('tenant_id', $tenantId);
            }
            $depCustomerIds = $depQuery->pluck('customer_id')->unique()->toArray();
            if (!empty($depCustomerIds)) {
                $query->whereIn('telehub_orders.customer_id', $depCustomerIds);
            } else {
                $query->where('telehub_orders.code', $paymentCode);
            }
        }

        if ($code !== '') {
            $cleanCode = ltrim($code, '#');
            $directQuery = DB::table('telehub_orders')
                ->where(function ($q) use ($cleanCode) {
                    $q->where('code', 'like', "%{$cleanCode}%")
                      ->orWhere('api_order_code', 'like', "%{$cleanCode}%");
                    if (ctype_digit($cleanCode)) {
                        $q->orWhere('id', (int) $cleanCode);
                    }
                });
            if ($tenantId) {
                $directQuery->where('tenant_id', $tenantId);
            }

            if ($directQuery->exists()) {
                $query->where(function ($q) use ($cleanCode) {
                    $q->where('telehub_orders.code', 'like', "%{$cleanCode}%")
                      ->orWhere('telehub_orders.api_order_code', 'like', "%{$cleanCode}%");
                    if (ctype_digit($cleanCode)) {
                        $q->orWhere('telehub_orders.id', (int) $cleanCode);
                    }
                });
            } else {
                $depQuery = DB::table('telehub_deposit_requests')
                    ->where('payment_code', 'like', "%{$cleanCode}%");
                if ($tenantId) {
                    $depQuery->where('tenant_id', $tenantId);
                }
                $depCustomerIds = $depQuery->pluck('customer_id')->unique()->toArray();

                if (!empty($depCustomerIds)) {
                    $query->whereIn('telehub_orders.customer_id', $depCustomerIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        }

        if ($email !== '') {
            $itemsQuery = DB::table('telehub_product_items')
                ->whereNotNull('order_id')
                ->where(function ($q) use ($email) {
                    $q->where('username', 'like', "%{$email}%")
                      ->orWhere('note', 'like', "%{$email}%")
                      ->orWhere('content', 'like', "%{$email}%");
                });
            if ($tenantId) {
                $itemsQuery->where('tenant_id', $tenantId);
            }
            $itemOrderIds = $itemsQuery->pluck('order_id')->unique()->toArray();

            $depCredQuery = DB::table('telehub_deposit_requests')
                ->where('credentials', 'like', "%{$email}%");
            if ($tenantId) {
                $depCredQuery->where('tenant_id', $tenantId);
            }
            $credCodes = $depCredQuery->pluck('payment_code')->unique()->toArray();

            if (empty($itemOrderIds) && empty($credCodes)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->where(function ($q) use ($itemOrderIds, $credCodes) {
                    if (!empty($itemOrderIds)) {
                        $q->whereIn('telehub_orders.id', $itemOrderIds);
                    }
                    if (!empty($credCodes)) {
                        $q->orWhereIn('telehub_orders.code', $credCodes);
                    }
                });
            }
        }

        if ($search !== '') {
            $cleanSearch = ltrim($search, '@#');
            $custQuery = DB::table('telehub_bot_customers')
                ->where(function ($q) use ($search, $cleanSearch) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('telegram_id', 'like', "%{$cleanSearch}%")
                      ->orWhere('username', 'like', "%{$cleanSearch}%");
                });
            if ($tenantId) {
                $custQuery->where('tenant_id', $tenantId);
            }
            $matchedCustomerIds = $custQuery->pluck('id')->toArray();

            $depQuery = DB::table('telehub_deposit_requests')
                ->where('payment_code', 'like', "%{$cleanSearch}%");
            if ($tenantId) {
                $depQuery->where('tenant_id', $tenantId);
            }
            $depCustomerIds = $depQuery->pluck('customer_id')->toArray();

            $allCustomerIds = array_values(array_unique(array_merge($matchedCustomerIds, $depCustomerIds)));

            $query->where(function ($q) use ($cleanSearch, $allCustomerIds) {
                $q->where('telehub_orders.code', 'like', "%{$cleanSearch}%")
                  ->orWhere('telehub_orders.api_order_code', 'like', "%{$cleanSearch}%");
                if (ctype_digit($cleanSearch)) {
                    $q->orWhere('telehub_orders.id', (int) $cleanSearch);
                }
                if (!empty($allCustomerIds)) {
                    $q->orWhereIn('telehub_orders.customer_id', $allCustomerIds);
                }
            });
        }

        if ($request->filled('type')) {
            $query->where('telehub_orders.type', $request->input('type'));
        }

        if ($request->filled('product_id')) {
            $productId = (int) $request->input('product_id');
            $orderIdsByProduct = DB::table('telehub_order_details')
                ->where('product_id', $productId)
                ->pluck('order_id')
                ->unique()
                ->toArray();
            if (empty($orderIdsByProduct)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('telehub_orders.id', $orderIdsByProduct);
            }
        }

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        if ($dateFrom && $dateTo) {
            $query->whereBetween('telehub_orders.created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ]);
        }

        return $query;
    }

    private function computeStatistics($baseQuery): array
    {
        $orderAgg = (clone $baseQuery)
            ->selectRaw('
                COUNT(*) as total_orders,
                IFNULL(SUM(CASE WHEN telehub_orders.status = "completed" AND telehub_orders.type != "warranty" AND telehub_orders.created_at IS NOT NULL THEN telehub_orders.total_amount ELSE 0 END), 0) as gross_revenue
            ')
            ->first();

        $totalOrders = (int) ($orderAgg->total_orders ?? 0);
        $grossRevenue = (float) ($orderAgg->gross_revenue ?? 0);

        $stats = (clone $baseQuery)
            ->where('telehub_orders.status', 'completed')
            ->where('telehub_orders.type', '!=', 'warranty')
            ->whereNotNull('telehub_orders.created_at')
            ->join('telehub_warranties as w', 'w.order_id', '=', 'telehub_orders.id')
            ->where('w.type', 'refund')
            ->selectRaw('COUNT(w.id) as total_accs, IFNULL(SUM(w.refund_amount), 0) as total_amount')
            ->first();

        $refundedAccs = (int) ($stats->total_accs ?? 0);
        $refundedAmount = (float) ($stats->total_amount ?? 0);

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $grossRevenue - $refundedAmount,
            'total_refunded_accs' => $refundedAccs,
            'total_refunded_amount' => $refundedAmount,
        ];
    }

    public function api(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $baseQuery = $this->buildOrderFilterQuery($request, $isAdmin);

        $sortBy = $request->input('sort_by');
        $sortDir = strtolower((string) $request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $validSortFields = ['id', 'total_amount', 'created_at', 'status', 'type'];
        $sortField = ($sortBy && in_array($sortBy, $validSortFields, true)) ? $sortBy : 'id';

        $perPage = min(max((int) $request->input('per_page', 20), 1), 200);
        $page = max((int) $request->input('page', 1), 1);

        $withStats = $request->boolean('with_stats');
        $statistics = null;

        if ($withStats) {
            $statistics = $this->computeStatistics($baseQuery);
            $total = $statistics['total_orders'];
        } else {
            $total = (int) (clone $baseQuery)->count();
        }

        $items = [];
        if ($total > 0) {
            $items = (clone $baseQuery)
                ->join('telehub_bot_customers as c', 'c.id', '=', 'telehub_orders.customer_id')
                ->select('telehub_orders.*', 'c.full_name', 'c.telegram_id')
                ->addSelect(DB::raw('(SELECT name FROM telehub_api_providers ap WHERE ap.id = telehub_orders.api_provider_id LIMIT 1) as api_provider_name'))
                ->addSelect(DB::raw('(SELECT payment_code FROM telehub_deposit_requests dr WHERE dr.customer_id = telehub_orders.customer_id ORDER BY dr.id DESC LIMIT 1) as payment_code'))
                ->addSelect(DB::raw('(SELECT IFNULL(SUM(refund_amount), 0) FROM telehub_warranties w WHERE w.order_id = telehub_orders.id AND w.type = "refund") as refunded_amount'))
                ->with(['details' => function ($q) {
                    $q->join('telehub_products as p', 'p.id', '=', 'telehub_order_details.product_id')
                      ->select('telehub_order_details.*', 'p.name as product_name', 'p.duration_days');
                }, 'items'])
                ->orderBy('telehub_orders.' . $sortField, $sortDir)
                ->forPage($page, $perPage)
                ->get();
        }

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $response = $paginator->toArray();
        if ($statistics !== null) {
            $response['statistics'] = $statistics;
        }

        return response()->json($response);
    }

    public function apiStats(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $baseQuery = $this->buildOrderFilterQuery($request, $isAdmin);

        return response()->json($this->computeStatistics($baseQuery));
    }

    public function apiProducts(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $query = Product::orderBy('name');

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $query->where('tenant_id', $tenant->id);
            }
        }

        $products = $query->select('id', 'name')->get();

        return response()->json($products);
    }

    public function updateType(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                if ($order->tenant_id != $tenant->id) {
                    abort(403);
                }
            }
        }

        $request->validate([
            'type' => 'required|in:sale,warranty,login'
        ]);

        $order->type = $request->type;
        $order->save();

        return response()->json([
            'error' => false,
            'message' => 'Cập nhật phân loại đơn hàng thành công'
        ]);
    }

    public function updatePrice(Request $request, $id)
    {
        $order = Order::with(['details', 'customer'])->findOrFail($id);
        
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                if ($order->tenant_id != $tenant->id) {
                    abort(403);
                }
            }
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.price' => 'required|numeric|min:0',
            'update_balance' => 'nullable|boolean',
            'note' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $oldTotal = (float) $order->total_amount;
            $newTotal = 0;

            foreach ($request->items as $itemData) {
                $detail = $order->details->firstWhere('id', $itemData['id']);
                if ($detail) {
                    $newPrice = (float) $itemData['price'];
                    $detail->price = $newPrice;
                    $detail->save();
                    $newTotal += ($newPrice * $detail->quantity);
                }
            }

            $order->total_amount = $newTotal;
            $order->save();

            $diff = $oldTotal - $newTotal; // > 0: giảm giá (hoàn tiền), < 0: tăng giá (trừ tiền)

            if ($request->boolean('update_balance') && $diff != 0) {
                $customer = $order->customer;
                if ($customer) {
                    $codeStr = $order->code ? "#{$order->code}" : "#{$order->id}";
                    if ($diff > 0) {
                        $customer->balance += $diff;
                        $customer->save();

                        \Dev\Telehub\Models\BalanceLog::create([
                            'tenant_id'   => $order->tenant_id,
                            'customer_id' => $customer->id,
                            'order_id'    => $order->id,
                            'type'        => 'IN',
                            'amount'      => $diff,
                            'note'        => 'Hoàn chênh lệch giảm giá đơn ' . $codeStr . ' (' . number_format($oldTotal, 0, ',', '.') . 'đ -> ' . number_format($newTotal, 0, ',', '.') . 'đ)' . ($request->note ? ': ' . $request->note : '')
                        ]);
                    } else {
                        $deductAmount = abs($diff);
                        $customer->balance -= $deductAmount;
                        $customer->save();

                        \Dev\Telehub\Models\BalanceLog::create([
                            'tenant_id'   => $order->tenant_id,
                            'customer_id' => $customer->id,
                            'order_id'    => $order->id,
                            'type'        => 'OUT',
                            'amount'      => $deductAmount,
                            'note'        => 'Thu chênh lệch tăng giá đơn ' . $codeStr . ' (' . number_format($oldTotal, 0, ',', '.') . 'đ -> ' . number_format($newTotal, 0, ',', '.') . 'đ)' . ($request->note ? ': ' . $request->note : '')
                        ]);
                    }
                }
            }

            DB::commit();

            // Load lại relation details kèm product để trả về cho Vue update table
            $order->load(['details' => function($q) {
                $q->join('telehub_products as p', 'p.id', '=', 'telehub_order_details.product_id')
                  ->select('telehub_order_details.*', 'p.name as product_name', 'p.duration_days');
            }]);

            return response()->json([
                'error' => false,
                'message' => 'Cập nhật giá đơn hàng thành công!',
                'order' => $order
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => 'Lỗi khi cập nhật giá: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleWarranty(Request $request, $id)
    {
        $order = Order::with('details.product')->findOrFail($id);
        
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                if ($order->tenant_id != $tenant->id) {
                    abort(403);
                }
            }
        }

        $request->validate([
            'product_item_id' => 'required|exists:telehub_product_items,id',
            'type' => 'required|in:refund,replace',
            'refund_amount' => 'required|numeric|min:0',
            'days_used' => 'required|integer|min:0',
            'note' => 'nullable|string'
        ]);

        $item = \Dev\Telehub\Models\ProductItem::where('id', $request->product_item_id)
            ->where('order_id', $order->id)
            ->firstOrFail();

        if ($item->status !== 'active') {
            return response()->json(['error' => true, 'message' => 'Tài khoản này đã được xử lý bảo hành trước đó.']);
        }

        DB::beginTransaction();
        try {
            // Update item status
            $item->status = $request->type === 'refund' ? 'revoked' : 'replaced';
            $item->save();

            // Insert into warranties
            $warranty = new \Dev\Telehub\Models\Warranty([
                'tenant_id' => $order->tenant_id,
                'customer_id' => $order->customer_id,
                'order_id' => $order->id,
                'product_item_id' => $item->id,
                'type' => $request->type,
                'days_used' => $request->days_used,
                'refund_amount' => $request->refund_amount,
                'status' => 'completed',
                'note' => $request->note
            ]);
            $warranty->save();

            // If refund, handle balance and notification
            if ($request->type === 'refund' && $request->refund_amount > 0) {
                $customer = \Dev\Telehub\Models\BotCustomer::find($order->customer_id);
                if ($customer) {
                    // Đơn login: không cộng vào ví ảo (admin tự chuyển khoản tay)
                    $isLoginOrder = ($order->type === 'login');

                    if (!$isLoginOrder) {
                        $customer->balance += $request->refund_amount;
                        $customer->save();

                        \Dev\Telehub\Models\BalanceLog::create([
                            'tenant_id' => $order->tenant_id,
                            'customer_id' => $customer->id,
                            'order_id' => $order->id,
                            'type' => 'IN',
                            'amount' => $request->refund_amount,
                            'note' => 'Hoàn tiền bảo hành đơn ' . ($order->code ?: $order->id) . ' - ' . ($request->note ?: 'Lỗi tài khoản')
                        ]);
                    }

                    // Send Telegram notification
                    if ($customer->telegram_id) {
                        $botConfig = \Dev\Telehub\Models\BotConfig::where('tenant_id', $order->tenant_id)->first();
                        if ($botConfig && $botConfig->bot_token) {
                            $message = "⚠️ *THÔNG BÁO BẢO HÀNH/THU HỒI*\n\n";
                            $message .= "Tài khoản: `{$item->username}`\n";
                            $message .= "Gói: {$order->details->first()->product->name}\n";
                            $message .= "Lý do: {$request->note}\n\n";
                            $message .= "💰 Số tiền hoàn lại: *" . number_format($request->refund_amount) . "đ*\n";

                            if ($isLoginOrder) {
                                $message .= "🏦 Hình thức hoàn: *Chuyển khoản ngân hàng*";
                            } else {
                                $message .= "💳 Số dư hiện tại: *" . number_format($customer->balance) . "đ*";
                            }

                            \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$botConfig->bot_token}/sendMessage", [
                                'chat_id' => $customer->telegram_id,
                                'text' => $message,
                                'parse_mode' => 'Markdown'
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Xử lý bảo hành thành công!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function checkApiStatus($id)
    {
        $order = Order::findOrFail($id);

        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                if ($order->tenant_id != $tenant->id) {
                    abort(403);
                }
            }
        }

        if (!$order->api_provider_id || !$order->api_order_code) {
            return response()->json([
                'error' => true,
                'message' => 'Đơn hàng này không có mã Job ID kết nối API.'
            ], 400);
        }

        $provider = DB::table('telehub_api_providers')->where('id', $order->api_provider_id)->first();
        if (!$provider || empty($provider->base_url)) {
            return response()->json([
                'error' => true,
                'message' => 'Không tìm thấy thông tin nhà cung cấp API.'
            ], 400);
        }

        $baseUrl = rtrim($provider->base_url, '/');
        $authHeader = $provider->header_name ?: 'x-api-key';
        $headers = [
            'Accept' => 'application/json',
        ];
        if ($provider->auth_type === 'bearer') {
            $headers['Authorization'] = 'Bearer ' . $provider->api_key;
        } else {
            $headers[$authHeader] = $provider->api_key;
        }

        try {
            $statusUrl = "{$baseUrl}/api/jobs/status/" . urlencode($order->api_order_code);
            $response = \Illuminate\Support\Facades\Http::withHeaders($headers)
                ->timeout(15)
                ->get($statusUrl);

            if ($response->successful()) {
                $data = $response->json();
                $newStatus = strtolower($data['status'] ?? '');

                if ($newStatus) {
                    $order->api_status = $newStatus;
                    $order->api_response = json_encode($data);
                    $order->save();

                    // Cập nhật nội dung trong telehub_product_items nếu completed hoặc failed
                    if ($newStatus === 'completed' || $newStatus === 'failed') {
                        $note = $data['note'] ?? '';
                        $progress = $data['progress'] ?? null;
                        $resultLink = $data['result_link'] ?? '';

                        $dep = DB::table('telehub_deposit_requests')->where('payment_code', $order->code)->first();
                        $email = '';
                        if ($dep && !empty($dep->credentials)) {
                            $parts = explode('|', $dep->credentials);
                            $email = trim($parts[0] ?? '');
                        }

                        if ($newStatus === 'completed') {
                            $content = "🎉 NÂNG CẤP TÀI KHOẢN THÀNH CÔNG!\n"
                                . ($email ? "📧 Tài khoản: {$email}\n" : "")
                                . "🆔 Job ID: {$order->api_order_code}\n"
                                . ($resultLink ? "🎁 Kết quả: {$resultLink}\n" : "")
                                . ($note ? "📝 Ghi chú: {$note}\n" : "");
                        } else {
                            $content = "⚠️ KÍCH HOẠT KHÔNG THÀNH CÔNG\n"
                                . ($email ? "📧 Tài khoản: {$email}\n" : "")
                                . "🆔 Job ID: {$order->api_order_code}\n"
                                . "❌ Lý do: " . ($note ?: 'Lỗi xử lý') . "\n"
                                . ($progress !== null ? "📊 Tiến trình dừng ở: {$progress}%\n" : "");
                        }

                        DB::table('telehub_product_items')->where('order_id', $order->id)->update([
                            'content' => $content
                        ]);
                    }
                }

                return response()->json([
                    'error' => false,
                    'message' => 'Cập nhật trạng thái API thành công: ' . strtoupper($newStatus),
                    'data' => $data,
                    'order' => $order
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'API nhà cung cấp phản hồi lỗi: ' . $response->status()
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Lỗi kết nối tới API: ' . $e->getMessage()
            ], 500);
        }
    }
}
