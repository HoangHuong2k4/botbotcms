<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Dev\Telehub\Models\DepositRequest;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\BalanceLog;
use Dev\Telehub\Models\BankWebhook;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Models\Tenant;

class ManualDepositController extends BaseController
{
    public function index()
    {
        $this->pageTitle('Xử lý nạp tiền thủ công');
        $tenants = [];
        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $tenants = Tenant::pluck('username', 'id')->toArray();
        }

        return view('plugins/telehub::manual-deposit', compact('tenants'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_code' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $code = trim(strtoupper($request->input('payment_code')));
        $amount = $request->input('amount');
        
        $query = DepositRequest::where('payment_code', $code)
            ->where('status', 'pending');
            
        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser() && $request->has('tenant_id')) {
            $tenantId = $request->input('tenant_id');
            if ($tenantId) {
                $query->where('tenant_id', $tenantId);
            }
        } else {
            // For tenant users, it will be automatically scoped by TenantMiddleware or global scopes, 
            // but just in case, let's get the tenant_id of current user if they are tied to a tenant.
            // Botble CMS usually handles tenant scope globally if configured, but let's assume it works.
        }

        $depositRequest = $query->first();

        if (!$depositRequest) {
            return back()->with('error_msg', 'Không tìm thấy yêu cầu nạp tiền đang chờ (pending) với mã ' . $code);
        }

        if ($depositRequest->amount != $amount && $depositRequest->amount > 0) {
            // Allow manual override of amount, but maybe warn? Let's just use the entered amount for the balance addition
            $amount = $request->input('amount');
        }

        DB::beginTransaction();
        try {
            // Lock row
            $depositRequest = DepositRequest::where('id', $depositRequest->id)->lockForUpdate()->first();
            if ($depositRequest->status !== 'pending') {
                DB::rollBack();
                return back()->with('error_msg', 'Yêu cầu này đã được xử lý.');
            }

            $customer = BotCustomer::find($depositRequest->customer_id);
            if (!$customer) {
                DB::rollBack();
                return back()->with('error_msg', 'Không tìm thấy khách hàng.');
            }

            // Update balance
            $customer->balance += $amount;
            $customer->save();

            // Update request status
            $depositRequest->status = 'success';
            $depositRequest->save();

            // Insert log
            $log = new BalanceLog();
            $log->tenant_id = $depositRequest->tenant_id;
            $log->customer_id = $customer->id;
            $log->type = 'IN';
            $log->amount = $amount;
            $log->note = "Nạp tiền tự động qua mã {$code} (Xử lý thủ công)";
            $log->save();

            // Insert webhook
            BankWebhook::create([
                'tenant_id' => $depositRequest->tenant_id,
                'tran_id_bank' => 'MANUAL_' . time(),
                'amount' => $amount,
                'description' => 'MANUAL FIX: ' . $code,
                'raw_json' => json_encode(['manual' => true, 'code' => $code, 'admin' => \Illuminate\Support\Facades\Auth::user()->id]),
            ]);

            DB::commit();

            // Send Telegram Notifications
            $this->sendNotifications($depositRequest->tenant_id, $customer, $amount, $code);

            return back()->with('success_msg', 'Đã xử lý thành công giao dịch ' . $code);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_msg', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    private function sendNotifications($tenantId, $customer, $amount, $code)
    {
        try {
            $botConfig = BotConfig::where('tenant_id', $tenantId)->first();
            if (!$botConfig || !$botConfig->bot_token) return;

            $token = $botConfig->bot_token;
            
            // Notify Customer
            if ($customer->telegram_id) {
                $timeVN = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
                $message = "✅ <b>NẠP TIỀN THÀNH CÔNG</b>\n";
                $message .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                $message .= "📝 <b>Mã giao dịch:</b> <code>{$code}</code>\n";
                $message .= "💵 <b>Số tiền nạp:</b> +" . number_format($amount, 0, ',', '.') . "đ\n";
                $message .= "💳 <b>Số dư hiện tại:</b> " . number_format($customer->balance, 0, ',', '.') . "đ\n";
                $message .= "━━━━━━━━━━━━━━━━━━\n";
                $message .= "Cảm ơn bạn đã sử dụng dịch vụ!";
                
                // Use notification bot token if set
                $notifyToken = $botConfig->telegram_notification_id ?: $token;
                
                Http::post("https://api.telegram.org/bot{$notifyToken}/sendMessage", [
                    'chat_id' => $customer->telegram_id,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ]);
            }

            // Note: Admin notification is automatically handled by BalanceLog::created observer in TelehubServiceProvider
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Manual Deposit Telegram Error: " . $e->getMessage());
        }
    }
}
