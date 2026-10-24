<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Forms\NotificationForm;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Jobs\SendTelegramNotificationJob;
use Dev\Telehub\Jobs\BroadcastTelegramNotificationJob;
use Illuminate\Http\Request;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Base\Enums\BaseStatusEnum;

class NotificationController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add('Telegram Notifications', route('telehub.notifications.index'));
    }

    public function index()
    {
        $this->pageTitle('Telegram Notifications');

        return NotificationForm::create()->renderForm();
    }

    public function store(Request $request, BaseHttpResponse $response)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|string',
            'tenant_id' => 'nullable|exists:telehub_tenants,id',
            'admin_telegram_id' => 'nullable|string',
        ]);

        $message = $request->input('message');
        $image = $request->input('image');
        $tenantId = $request->input('tenant_id');
        $adminTelegramId = $request->input('admin_telegram_id');
        $submitType = $request->input('submit_type');

        // If not super user, force tenant_id to current user's tenant
        if (! \Illuminate\Support\Facades\Auth::user()->isSuperUser()) {
            $tenant = \Dev\Telehub\Models\Tenant::current();
            if (!$tenant) {
                return $response->setError()->setMessage('Tenant not found.');
            }
            $tenantId = $tenant->id;
        }

        // Xử lý gửi thử nghiệm cho Admin
        if ($submitType === 'test') {
            if (!$adminTelegramId) {
                return $response->setError()->setMessage('Please enter your Admin Telegram ID for testing.');
            }

            // Lấy bot config cho tenant tương ứng
            $botConfig = BotConfig::query()
                ->where('tenant_id', $tenantId)
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->first();

            if (!$botConfig || !$botConfig->bot_token) {
                return $response->setError()->setMessage('Active bot configuration not found for this tenant.');
            }

            // Gửi ngay lập tức vào hàng đợi đến Admin
            SendTelegramNotificationJob::dispatch(
                $botConfig->bot_token,
                $adminTelegramId,
                $message,
                $image
            );

            return $response->setMessage("Test message sent to your Telegram ID ({$adminTelegramId}) successfully!");
        }

        // Gửi diện rộng cho tất cả khách hàng
        BroadcastTelegramNotificationJob::dispatch($message, $tenantId, $image);

        return $response->setMessage("Broadcasting notification in the background. You can continue working.");
    }
}
