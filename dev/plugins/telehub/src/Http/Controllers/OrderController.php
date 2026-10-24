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

    private function buildOrderQuery(Request $request, $isAdmin)
    {
        $paymentCode = $request->input('payment_code');
        $search = $request->input('search');
        $email = $request->input('email');

        $query = Order::from('telehub_orders')
            ->select('telehub_orders.*', 'c.full_name', 'c.telegram_id')
            ->addSelect(DB::raw('(SELECT payment_code FROM telehub_deposit_requests dr WHERE dr.customer_id = telehub_orders.customer_id ORDER BY dr.id DESC LIMIT 1) as payment_code'))
            ->addSelect(DB::raw('(SELECT IFNULL(SUM(refund_amount), 0) FROM telehub_warranties w WHERE w.order_id = telehub_orders.id AND w.type = "refund") as refunded_amount'))
            ->join('telehub_bot_customers as c', 'c.id', '=', 'telehub_orders.customer_id')
            ->with(['details' => function($q) {
                $q->join('telehub_products as p', 'p.id', '=', 'telehub_order_details.product_id')
                  ->select('telehub_order_details.*', 'p.name as product_name', 'p.duration_days');
            }, 'items']);

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $query->where('telehub_orders.tenant_id', $tenant->id);
            }
        }

        if ($paymentCode) {
            $deposit = DepositRequest::where('payment_code', $paymentCode)->first();
            if ($deposit) {
                $query->where('telehub_orders.customer_id', $deposit->customer_id);
            } else {
                // If payment code not found, make it return empty
                $query->where('telehub_orders.id', -1);
            }
        }

        if ($email) {
            $query->whereHas('items', function ($q) use ($email) {
                $q->where('username', 'like', "%{$email}%")
                  ->orWhere('note', 'like', "%{$email}%")
                  ->orWhere('content', 'like', "%{$email}%");
            });
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('c.full_name', 'like', "%{$search}%")
                  ->orWhere('c.telegram_id', 'like', "%{$search}%")
                  ->orWhere('telehub_orders.code', 'like', "%{$search}%")
                  ->orWhere('telehub_orders.id', $search)
                  ->orWhereRaw('(SELECT payment_code FROM telehub_deposit_requests dr WHERE dr.customer_id = telehub_orders.customer_id ORDER BY dr.id DESC LIMIT 1) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('type')) {
            $query->where('telehub_orders.type', $request->type);
        }

        if ($request->filled('product_id')) {
            $productId = (int) $request->input('product_id');
            $query->whereHas('details', function ($q) use ($productId) {
                $q->where('telehub_order_details.product_id', $productId);
            });
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

    public function api(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $query = $this->buildOrderQuery($request, $isAdmin);
        
        $sortBy = $request->input('sort_by');
        $sortDir = $request->input('sort_dir', 'desc');
        
        $validSortFields = ['id', 'total_amount', 'created_at', 'status', 'type'];
        if ($sortBy && in_array($sortBy, $validSortFields)) {
            $query->orderBy('telehub_orders.' . $sortBy, $sortDir);
        } else {
            $query->orderBy('telehub_orders.id', 'desc');
        }

        $perPage = $request->input('per_page', 20);
        $orders = $query->paginate($perPage);

        return response()->json($orders);
    }

    public function apiStats(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $query = $this->buildOrderQuery($request, $isAdmin);

        // Compute overall statistics for the current filter
        $totalOrders = (clone $query)->count();

        // Revenue must follow the same rules as StatisticsController so both screens match:
        // only completed sale orders (exclude cancelled + warranty) and ignore legacy/test
        // rows without created_at. No data is modified — rows are only filtered out.
        $revenueQuery = (clone $query)
            ->where('telehub_orders.status', 'completed')
            ->where('telehub_orders.type', '!=', 'warranty')
            ->whereNotNull('telehub_orders.created_at');

        $grossRevenue = (clone $revenueQuery)->sum('telehub_orders.total_amount');

        $stats = DB::table('telehub_warranties')
            ->joinSub((clone $revenueQuery)->select('telehub_orders.id'), 'filtered_orders', 'filtered_orders.id', '=', 'telehub_warranties.order_id')
            ->where('telehub_warranties.type', 'refund')
            ->selectRaw('COUNT(*) as total_accs, SUM(refund_amount) as total_amount')
            ->first();

        $refundedAccs = $stats->total_accs ?? 0;
        $refundedAmount = $stats->total_amount ?? 0;

        return response()->json([
            'total_orders' => $totalOrders,
            'total_revenue' => $grossRevenue - $refundedAmount,
            'total_refunded_accs' => $refundedAccs,
            'total_refunded_amount' => $refundedAmount
        ]);
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
}
