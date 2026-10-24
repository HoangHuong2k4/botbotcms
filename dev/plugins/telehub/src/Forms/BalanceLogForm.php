<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\BalanceLog;
use Dev\Telehub\Models\BotCustomer;

class BalanceLogForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(BalanceLog::class)
            ->add('customer_id', SelectField::class, [
                'label' => 'Customer',
                'required' => true,
                'choices' => BotCustomer::query()->pluck('telegram_id', 'id')->all(),
            ])
            ->add('type', SelectField::class, [
                'label' => 'Type',
                'required' => true,
                'choices' => [
                    'add' => 'Add',
                    'sub' => 'Subtract',
                ],
            ])
            ->add('amount', NumberField::class, [
                'label' => 'Amount',
                'required' => true,
            ])
            ->add('note', TextField::class, [
                'label' => 'Note',
            ]);
    }
}
