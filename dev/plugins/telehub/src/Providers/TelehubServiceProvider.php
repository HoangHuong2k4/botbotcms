<?php

namespace Dev\Telehub\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Base\Facades\DashboardMenu;
use Dev\Telehub\Models\Tenant;

class TelehubServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        parent::register();

        $this->app['router']->aliasMiddleware('telehub.tenant', \Dev\Telehub\Http\Middleware\TenantMiddleware::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/telehub')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->loadRoutes(['web', 'api']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Dev\Telehub\Commands\CleanInactiveCustomersCommand::class,
            ]);
        }

        \Dev\ACL\Models\User::created(function (\Dev\ACL\Models\User $user) {
            $existingTenant = \Dev\Telehub\Models\Tenant::query()
                ->where('user_id', $user->id)
                ->orWhere('username', $user->username)
                ->orWhere('email', $user->email)
                ->first();

            if (! $existingTenant) {
                \Dev\Telehub\Models\Tenant::query()->create([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'password' => '12341234',
                    'status' => \Dev\Base\Enums\BaseStatusEnum::PUBLISHED,
                    'role_id' => request()->input('role_id'),
                ]);
            } elseif (! $existingTenant->user_id) {
                // Link existing tenant to the new user if it's not linked yet
                $existingTenant->update(['user_id' => $user->id]);
            }
        });

        \Dev\ACL\Models\User::deleted(function (\Dev\ACL\Models\User $user) {
            \Dev\Telehub\Models\Tenant::query()->where('user_id', $user->id)->delete();
        });

        // Khi admin edit balance trực tiếp từ form → tự tạo BalanceLog để trigger notify
        \Dev\Telehub\Models\BotCustomer::updated(function (\Dev\Telehub\Models\BotCustomer $customer) {
            if (!$customer->wasChanged('balance')) return;

            $oldBalance = $customer->getOriginal('balance');
            $newBalance = $customer->balance;
            $diff = $newBalance - $oldBalance;

            if ($diff == 0) return;

            \Dev\Telehub\Models\BalanceLog::create([
                'tenant_id'   => $customer->tenant_id,
                'customer_id' => $customer->id,
                'type'        => $diff > 0 ? 'IN' : 'OUT',
                'amount'      => abs($diff),
                'note'        => ($diff > 0 ? 'Admin cộng ' : 'Admin trừ ') . number_format(abs($diff), 0, ',', '.') . 'đ (chỉnh sửa trực tiếp)',
            ]);
        });

        // Thông báo admin khi có biến động số dư ví
        \Dev\Telehub\Models\BalanceLog::created(function (\Dev\Telehub\Models\BalanceLog $log) {
            try {
                $tenantId = $log->tenant_id;
                if (!$tenantId) return;

                $botConfig = \Dev\Telehub\Models\BotConfig::where('tenant_id', $tenantId)->first();
                if (!$botConfig || !$botConfig->bot_token || !$botConfig->telegram_admin_id) return;

                $customer = $log->customer;
                $timeVN = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');

                $isIn  = in_array($log->type, ['IN', 'in', 'increase', 'deposit']);
                $emoji = $isIn ? '📥' : '📤';
                $label = $isIn ? 'CỘNG SỐ DƯ' : 'TRỪ SỐ DƯ';
                $sign  = $isIn ? '+' : '-';

                $newBalance = $customer ? $customer->balance : 0;

                $message  = "{$emoji} <b>BIẾN ĐỘNG SỐ DƯ VÍ – {$label}</b>\n";
                $message .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
                $message .= "━━━━━━━━━━━━━━━━━━\n";
                $message .= "👤 <b>Khách hàng:</b> " . htmlspecialchars($customer->full_name ?? 'N/A') . "\n";
                if ($customer && $customer->telegram_id) {
                    $message .= "🆔 <b>Telegram ID:</b> <code>{$customer->telegram_id}</code>\n";
                }
                $message .= "💰 <b>Số tiền:</b> <b>{$sign}" . number_format($log->amount, 0, ',', '.') . "đ</b>\n";
                $message .= "💳 <b>Số dư hiện tại:</b> " . number_format($newBalance, 0, ',', '.') . "đ\n";
                $message .= "📝 <b>Ghi chú:</b> " . htmlspecialchars($log->note ?? '') . "\n";

                $notifyToken = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
                \Illuminate\Support\Facades\Http::post("https://api.telegram.org/bot{$notifyToken}/sendMessage", [
                    'chat_id'    => $botConfig->telegram_admin_id,
                    'text'       => $message,
                    'parse_mode' => 'HTML',
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('BalanceLog admin notify error: ' . $e->getMessage());
            }
        });

        if (file_exists($routesFile = __DIR__ . '/../../routes/web.php')) {
            \Illuminate\Support\Facades\Route::group([], $routesFile);
        }

        DashboardMenu::default()->beforeRetrieving(function () {
            // Main Parent
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-telehub',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/telehub::telehub.name',
                'icon' => 'ti ti-brand-telegram',
                'url' => '#',
                'permissions' => ['telehub.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-statistics',
                'priority' => 0,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Statistics',
                'icon' => 'ti ti-chart-bar',
                'url' => route('telehub.statistics.index'),
                'permissions' => ['telehub.statistics.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-user-analytics',
                'priority' => 0,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Thống kê User',
                'icon' => 'ti ti-users-group',
                'url' => route('telehub.user-analytics.index'),
                'permissions' => ['telehub.user-analytics.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-orders',
                'priority' => 1,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Đơn hàng (Orders)',
                'icon' => 'ti ti-receipt',
                'url' => route('telehub.orders.index'),
                'permissions' => ['telehub.orders.index'],
            ])
            // Sub-menus
            ->registerItem([
                'id' => 'cms-plugins-telehub-tenant',
                'priority' => 1,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Tenants',
                'icon' => 'ti ti-users',
                'url' => route('telehub.tenants.index'),
                'permissions' => ['telehub.tenants.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-bot-config',
                'priority' => 2,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Bot Configs',
                'icon' => 'ti ti-settings',
                'url' => route('telehub.bot-configs.index'),
                'permissions' => ['telehub.bot-configs.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-product',
                'priority' => 11,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Products',
                'icon' => 'ti ti-shopping-cart',
                'url' => route('telehub.products.index'),
                'permissions' => ['telehub.products.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-product-item',
                'priority' => 12,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Product Items',
                'icon' => 'ti ti-barcode',
                'url' => route('telehub.product-items.index'),
                'permissions' => ['telehub.product-items.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-customer',
                'priority' => 20,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Customers',
                'icon' => 'ti ti-user-circle',
                'url' => route('telehub.bot-customers.index'),
                'permissions' => ['telehub.bot-customers.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-notifications',
                'priority' => 21,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Telegram Notifications',
                'icon' => 'ti ti-brand-telegram',
                'url' => route('telehub.notifications.index'),
                'permissions' => ['telehub.notifications.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-deposit',
                'priority' => 30,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Deposit Requests',
                'icon' => 'ti ti-wallet',
                'url' => route('telehub.deposit-requests.index'),
                'permissions' => ['telehub.deposit-requests.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-manual-deposit',
                'priority' => 30,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Xử lý thủ công',
                'icon' => 'ti ti-check',
                'url' => route('telehub.manual-deposit.index'),
                'permissions' => ['telehub.manual-deposit.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-balance',
                'priority' => 31,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Balance Logs',
                'icon' => 'ti ti-history',
                'url' => route('telehub.balance-logs.index'),
                'permissions' => ['telehub.balance-logs.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-bank-webhook',
                'priority' => 40,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Bank Webhooks',
                'icon' => 'ti ti-cloud-download',
                'url' => route('telehub.bank-webhooks.index'),
                'permissions' => ['telehub.bank-webhooks.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-dealers',
                'priority' => 45,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Cộng Tác Viên (API)',
                'icon' => 'ti ti-users',
                'url' => route('telehub.dealers.index'),
                'permissions' => ['telehub.dealers.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-api-providers',
                'priority' => 15,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Kết Nối API (Kho sỉ)',
                'icon' => 'ti ti-plug-connected',
                'url' => route('telehub.api-providers.index'),
                'permissions' => ['telehub.api-providers.index'],
            ])
            ->registerItem([
                'id' => 'cms-plugins-telehub-convert-data',
                'priority' => 50,
                'parent_id' => 'cms-plugins-telehub',
                'name' => 'Convert Data',
                'icon' => 'ti ti-file-export',
                'url' => route('telehub.convert-data.index'),
                'permissions' => ['telehub.convert-data.index'],
            ]);
        });

        $this->registerProfileFilters();
    }

    protected function registerProfileFilters(): void
    {
        add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
            if (! $form instanceof \Dev\ACL\Forms\ProfileForm || ! $data instanceof \Dev\ACL\Models\User) {
                return $form;
            }

            $currentUser = \Illuminate\Support\Facades\Auth::user();
            if ($currentUser->isSuperUser() || $currentUser->hasPermission('users.edit')) {
                $roles = \Dev\ACL\Models\Role::query()->pluck('name', 'id')->all();
                $userRoleId = $data->roles->first()?->id;

                $form->add(
                    'role_id',
                    \Dev\Base\Forms\Fields\SelectField::class,
                    \Dev\Base\Forms\FieldOptions\SelectFieldOption::make()
                        ->label(trans('core/acl::users.role'))
                        ->choices(['' => trans('core/acl::users.select_role')] + $roles)
                        ->selected($userRoleId)
                        ->toArray()
                );
            }

            return $form;
        }, 120, 2);

        add_action(USER_ACTION_AFTER_UPDATE_PROFILE, function ($screen, $request, $user) {
            $currentUser = \Illuminate\Support\Facades\Auth::user();
            if ($currentUser->isSuperUser() || $currentUser->hasPermission('users.edit')) {
                if ($request->has('role_id')) {
                    $roleId = $request->input('role_id');
                    $user->roles()->sync([$roleId]);

                    $role = \Dev\ACL\Models\Role::query()->find($roleId);
                    if ($role) {
                        $user->update(['permissions' => $role->permissions ?: []]);
                    }

                    // Sync BACK to Tenant with Self-Healing logic
                    $tenant = \Dev\Telehub\Models\Tenant::query()
                        ->where('user_id', $user->id)
                        ->orWhere('email', $user->email)
                        ->orWhere('username', $user->username)
                        ->first();

                    if ($tenant) {
                        $tenant->updateQuietly([
                            'role_id' => $roleId,
                            'user_id' => $user->id, // Re-link if ID was mismatched
                        ]);
                    }
                }
            }
        }, 120, 3);
    }
}
