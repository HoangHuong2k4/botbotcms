<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\BankWebhook;
use Dev\Telehub\Models\Tenant;

class BankWebhookForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(BankWebhook::class);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Tenant',
                'required' => true,
                'choices' => Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this
            ->add('tran_id_bank', TextField::class, [
                'label' => 'Bank Transaction ID',
                'required' => true,
            ])
            ->add('amount', NumberField::class, [
                'label' => 'Amount',
                'required' => true,
            ])
            ->add('description', TextareaField::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->add('raw_json', TextareaField::class, [
                'label' => 'Raw JSON Data',
                'attr' => [
                    'rows' => 5,
                ],
            ]);
    }
}
