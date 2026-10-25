<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\Product;

class ProductForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(Product::class)
            ->setValidatorClass(\Dev\Telehub\Http\Requests\ProductRequest::class);

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $this->add('tenant_id', SelectField::class, [
                'label' => 'Tenant',
                'required' => true,
                'choices' => \Dev\Telehub\Models\Tenant::query()->pluck('username', 'id')->all(),
            ]);
        }

        $this->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('name_en', TextField::class, [
                'label' => 'Name (English)',
                'required' => false,
            ])
            ->add('icon', TextField::class, [
                'label' => 'Icon / Emoji',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ví dụ: 🎬 hoặc ⚡ hoặc mã Custom Emoji',
                ],
            ])
            ->add('price', NumberField::class, [
                'label' => 'Price',
                'required' => true,
                'value' => (int)($this->getModel()->price ?? 0),
                'attr' => [
                    'placeholder' => '0',
                    'step' => '1',
                ],
            ])
            ->add('duration_days', NumberField::class, [
                'label' => 'Thời gian bảo hành (số)',
                'required' => false,
                'value' => $this->getModel()->id ? $this->getModel()->duration_days : 0,
                'attr' => [
                    'placeholder' => 'Nhập số (0 = không bảo hành)',
                    'step' => '1',
                    'min' => '0',
                ],
            ])
            ->add('warranty_unit', SelectField::class, [
                'label' => 'Đơn vị bảo hành',
                'required' => false,
                'choices' => [
                    'hour' => '⏰ Giờ (hour)',
                    'day'  => '📅 Ngày (day)',
                ],
                'selected' => $this->getModel()->id ? ($this->getModel()->warranty_unit ?: 'day') : 'day',
                'help_block' => [
                    'text' => 'Chọn "Giờ" nếu bảo hành theo giờ (vd: BH 1H, 6H...). Chọn "Ngày" cho bảo hành theo ngày. Nhập 0 ở trên nếu không bảo hành.',
                ],
            ])
            ->add('price_usd', NumberField::class, [
                'label' => 'Price (USD) - Optional (if blank, calculated from rate)',
                'required' => false,
                'value' => $this->getModel()->price_usd,
                'attr' => [
                    'placeholder' => 'e.g. 0.25',
                    'step' => '0.01',
                ],
            ])
            ->add('description', TextareaField::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('description_en', TextareaField::class, [
                'label' => 'Description (English)',
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('api_sold', NumberField::class, [
                'label' => 'Số lượng đã bán (Hiển thị bot Telegram)',
                'required' => false,
                'value' => (int)($this->getModel()->api_sold ?? 0),
                'help_block' => [
                    'text' => 'Số lượng đã bán hiển thị trên bot Telegram. Tự động đồng bộ từ API (nếu có), hoặc bạn có thể tự nhập số uy tín theo ý muốn.',
                ],
            ])
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
