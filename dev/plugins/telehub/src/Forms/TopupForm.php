<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Http\Requests\TopupRequest;
use Dev\Telehub\Models\BotCustomer;

class TopupForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(BotCustomer::class)
            ->setValidatorClass(TopupRequest::class)
            ->add('amount', NumberField::class, [
                'label' => trans('plugins/telehub::telehub.bot_customers.amount'),
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter amount to top-up',
                ],
            ])
            ->add('note', TextareaField::class, [
                'label' => trans('plugins/telehub::telehub.bot_customers.note'),
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Reason for manual top-up',
                ],
            ]);
    }
}
