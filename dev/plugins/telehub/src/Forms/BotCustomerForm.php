<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Tenant;

class BotCustomerForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(BotCustomer::class)
            ->setValidatorClass(\Dev\Telehub\Http\Requests\BotCustomerRequest::class);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Tenant',
                'required' => true,
                'choices' => Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this->add('telegram_id', TextField::class, [
                'label' => 'Telegram ID',
                'required' => true,
            ])
            ->add('username', TextField::class, [
                'label' => 'Username (@name)',
            ])
            ->add('full_name', TextField::class, [
                'label' => 'Full Name',
            ])
            ->add('balance', NumberField::class, [
                'label' => 'Balance',
                'default_value' => 0,
                'value' => (int)($this->getModel()->balance ?? 0),
                'attr' => [
                    'step' => '1',
                ],
            ])
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->add('is_banned', OnOffField::class, [
                'label' => '🚫 Chặn khỏi Bot (Ban Scam / Gian lận)',
                'default_value' => false,
                'help_block' => [
                    'text' => 'Khi bật, user này sẽ bị chặn hoàn toàn mọi thao tác trên Bot Telegram và không thể mua hàng/nạp tiền.',
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
