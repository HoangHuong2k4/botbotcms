<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\DepositRequest;
use Dev\Telehub\Models\BotCustomer;

class DepositRequestForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(DepositRequest::class)
            ->add('customer_id', SelectField::class, [
                'label' => 'Customer',
                'required' => true,
                'choices' => BotCustomer::query()->pluck('telegram_id', 'id')->all(),
            ])
            ->add('amount', NumberField::class, [
                'label' => 'Amount',
                'required' => true,
                'value' => (int)($this->getModel()->amount ?? 0),
                'attr' => [
                    'step' => '1',
                ],
            ])
            ->add('payment_code', TextField::class, [
                'label' => 'Payment Code',
                'required' => true,
            ])
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
