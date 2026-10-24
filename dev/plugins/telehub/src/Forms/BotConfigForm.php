<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Models\Tenant;

class BotConfigForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(BotConfig::class);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Tenant',
                'required' => true,
                'choices' => Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this
            ->add('bot_token', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.bot_token'),
                'required' => true,
                'placeholder' => 'Sales Bot Token',
            ])
            ->add('telegram_notification_id', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.telegram_notification_token'),
                'placeholder' => 'Notification Bot Token',
            ])
            ->add('telegram_admin_id', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.telegram_admin_id'),
                'placeholder' => 'ID Admin nhận thông báo (e.g. 7353915691)',
            ])
            ->add('welcome_message', 'textarea', [
                'label' => trans('plugins/telehub::telehub.bot_configs.welcome_message'),
                'placeholder' => 'Bản tin chào mừng khi bấm /start...',
                'attr' => ['rows' => 5],
            ])
            ->add('welcome_message_en', 'textarea', [
                'label' => 'Welcome Message (English)',
                'placeholder' => 'Welcome message when /start...',
                'attr' => ['rows' => 5],
            ])
            ->add('bank_code', SelectField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.bank_code'),
                'choices' => \Dev\Telehub\Supports\BankHelper::getBanks(),
                'searchable' => true,
            ])
            ->add('bank_num', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.bank_num'),
                'placeholder' => 'Số tài khoản ngân hàng',
            ])
            ->add('bank_account_name', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.bank_account_name'),
                'placeholder' => 'Tên chủ tài khoản (In hoa không dấu)',
            ])
            ->add('bank_api_token', TextField::class, [
                'label' => 'API Token / Secret Key',
                'placeholder' => 'Token để lấy lịch sử giao dịch (thueapibank.vn)',
            ])
            ->add('webhook_signature', TextField::class, [
                'label' => trans('plugins/telehub::telehub.bot_configs.webhook_signature'),
                'placeholder' => 'Mã Signature khớp với thueapibank.vn',
            ])
            ->add('binance_api_key', TextField::class, [
                'label' => 'Binance API Key',
                'placeholder' => 'API Key của Binance',
            ])
            ->add('binance_secret_key', TextField::class, [
                'label' => 'Binance Secret Key',
                'placeholder' => 'Secret Key của Binance',
            ])
            ->add('binance_pay_id', TextField::class, [
                'label' => 'Binance Pay ID (UID)',
                'placeholder' => 'ID Binance nhận tiền (VD: 1076336156)',
            ])
            ->add('usdt_wallet_address', TextField::class, [
                'label' => 'USDT Wallet Address',
                'placeholder' => 'Ví USDT hiển thị cho khách',
            ])
            ->add('usdt_network', TextField::class, [
                'label' => 'USDT Network',
                'placeholder' => 'VD: BEP20, TRC20, ...',
            ])
            ->add('usdt_exchange_rate', TextField::class, [
                'label' => 'USDT Exchange Rate (VND)',
                'placeholder' => 'Tỷ giá, ví dụ: 25500',
            ])
            ->add('restart_api_btn', 'html', [
                'html' => '
                    <div class="form-group mb-3" style="margin-top: 30px;">
                        <button type="button" class="btn btn-warning" onclick="restartApiAndClearCache()">
                            <i class="fa fa-refresh"></i> Áp dụng Cấu hình (Xóa Cache & Khởi động lại Bot)
                        </button>
                        <p class="help-block mt-1">Bấm nút này sau khi đổi API Token Ngân Hàng hoặc cấu hình để Bot nhận dữ liệu mới ngay lập tức.</p>
                    </div>
                    <script>
                    function restartApiAndClearCache() {
                        if (!confirm("Bạn có chắc chắn muốn khởi động lại hệ thống Bot và xóa Cache không? Quá trình này mất khoảng 2-3 giây.")) return;
                        $.ajax({
                            url: "' . route('telehub.bot-configs.restart-api') . '",
                            type: "POST",
                            data: { _token: "' . csrf_token() . '" },
                            success: function(res) {
                                alert(res.message);
                                window.location.reload();
                            },
                            error: function(err) {
                                alert(err.responseJSON ? err.responseJSON.message : "Đã có lỗi xảy ra");
                            }
                        });
                    }
                    </script>
                ',
            ]);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this
                ->add('qr_template', TextField::class, [
                    'label' => trans('plugins/telehub::telehub.bot_configs.qr_template'),
                    'placeholder' => 'compact, qr_only, v.v.',
                ])
                ->add('status', SelectField::class, StatusFieldOption::make())
                ->setBreakFieldPoint('status');
        }
    }
}
