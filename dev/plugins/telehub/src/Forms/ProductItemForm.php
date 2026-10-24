<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Models\Product;

class ProductItemForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(ProductItem::class);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Tenant',
                'required' => true,
                'choices' => \Dev\Telehub\Models\Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this->add('product_id', SelectField::class, [
            'label' => 'Product',
            'required' => true,
            'choices' => Product::query()->pluck('name', 'id')->all(),
        ])
            ->add('username', \Dev\Base\Forms\Fields\TextField::class, [
                'label' => 'Username',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter username',
                ],
            ])
            ->add('password', \Dev\Base\Forms\Fields\TextField::class, [
                'label' => 'Password',
                'attr' => [
                    'placeholder' => 'Enter password',
                ],
            ])
            ->add('note', TextareaField::class, [
                'label' => 'Note',
                'attr' => [
                    'rows' => 2,
                    'placeholder' => 'Extra info...',
                ],
            ])
            ->add('is_sold', OnOffField::class, [
                'label' => 'Is Sold',
                'default_value' => false,
            ])
            ->add('customer_id', SelectField::class, [
                'label' => 'Customer',
                'choices' => ['' => 'None'] + \Dev\Telehub\Models\BotCustomer::query()->pluck('full_name', 'id')->all(),
            ])
            ->add('content', TextareaField::class, [
                'label' => 'Raw Content (Original)',
                'help_block' => [
                    'text' => 'This field is preserved for backward compatibility.',
                ],
                'attr' => [
                    'rows' => 2,
                ],
            ])
            ->setBreakFieldPoint('is_sold');
    }
}
