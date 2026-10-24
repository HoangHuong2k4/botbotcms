<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\Tenant;

class NotificationForm extends FormAbstract
{
    public function setup(): void
    {
        // Tự động tìm kiếm Telegram ID của admin hiện tại bằng cách khớp username
        $defaultAdminId = '';
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            $customer = \Dev\Telehub\Models\BotCustomer::query()
                ->where('username', $user->username)
                ->first();
            if ($customer) {
                $defaultAdminId = $customer->telegram_id;
            }
        }

        $this
            ->setupModel([])
            ->setMethod('POST')
            ->setUrl(route('telehub.notifications.store'))
            ->add('admin_telegram_id', 'text', [
                'label' => 'Admin Telegram ID (for Testing)',
                'required' => false,
                'value' => $defaultAdminId,
                'attr' => [
                    'placeholder' => 'Enter your Telegram ID (e.g. 7353915691) to test...',
                ],
            ])
            ->add('image', \Dev\Base\Forms\Fields\MediaImageField::class, \Dev\Base\Forms\FieldOptions\MediaImageFieldOption::make()->label('Image (Optional)')->toArray())
            ->add('message', TextareaField::class, [
                'label' => 'Message content',
                'required' => true,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Enter message to send to all customers...',
                ],
            ]);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Filter by Tenant',
                'choices' => ['' => 'All Tenants'] + Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this->add('submit', 'submit', [
            'label' => 'Send Now (Broadcast to All)',
            'attr' => [
                'name' => 'submit_type',
                'value' => 'broadcast',
                'class' => 'btn btn-primary',
            ],
        ]);

        $this->add('submit_test', 'submit', [
            'label' => 'Send Test to Me',
            'attr' => [
                'name' => 'submit_type',
                'value' => 'test',
                'class' => 'btn btn-warning ms-2',
            ],
        ]);
    }
}
