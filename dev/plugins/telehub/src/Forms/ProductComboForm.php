<?php

namespace Dev\Telehub\Forms;

use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\ProductCombo;

class ProductComboForm extends FormAbstract
{
    public function setup(): void
    {
        $this->model(ProductCombo::class)
            ->setValidatorClass(\Dev\Telehub\Http\Requests\ProductComboRequest::class);

        // Lấy danh sách sản phẩm theo tenant
        $productQuery = Product::query()->where('status', 'published');
        if (!\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            if ($tenant = \Dev\Telehub\Models\Tenant::current()) {
                $productQuery->where('tenant_id', $tenant->id);
            }
        }
        $products = $productQuery->pluck('name', 'id')->all();

        $this->add('product_id', SelectField::class, [
                'label'    => 'Sản phẩm',
                'required' => true,
                'choices'  => $products,
            ])
            ->add('min_quantity', NumberField::class, [
                'label'    => 'Số lượng tối thiểu',
                'required' => true,
                'value'    => (int)($this->getModel()->min_quantity ?? 2),
                'attr'     => ['min' => 2, 'placeholder' => '2'],
                'help_block' => ['text' => 'Mua ít nhất X acc thì mới áp dụng combo này.'],
            ])
            ->add('type', SelectField::class, [
                'label'    => 'Loại ưu đãi',
                'required' => true,
                'choices'  => [
                    'discount' => '🏷️ Giảm giá (discount)',
                    'bonus'    => '🎁 Tặng thêm acc (bonus)',
                ],
                'attr' => ['id' => 'combo-type-select'],
            ])
            ->add('discount_percent', NumberField::class, [
                'label' => 'Giảm % / acc',
                'value' => (float)($this->getModel()->discount_percent ?? 0),
                'attr'  => [
                    'min'         => 0,
                    'max'         => 100,
                    'step'        => '0.01',
                    'placeholder' => 'Ví dụ: 10 = giảm 10%',
                ],
                'help_block' => ['text' => 'Chỉ dùng khi loại = Giảm giá. Nhập 0 nếu dùng giảm theo số tiền.'],
            ])
            ->add('discount_amount', NumberField::class, [
                'label' => 'Giảm số tiền / acc (đồng)',
                'value' => (float)($this->getModel()->discount_amount ?? 0),
                'attr'  => [
                    'min'         => 0,
                    'step'        => '1',
                    'placeholder' => 'Ví dụ: 1000 = giảm 1,000đ/acc',
                ],
                'help_block' => ['text' => 'Chỉ dùng khi loại = Giảm giá. Ưu tiên discount_percent nếu cả 2 đều > 0.'],
            ])
            ->add('bonus_qty', NumberField::class, [
                'label' => 'Số acc tặng thêm',
                'value' => (int)($this->getModel()->bonus_qty ?? 1),
                'attr'  => [
                    'min'         => 1,
                    'step'        => '1',
                    'placeholder' => 'Ví dụ: 1 = tặng 1 acc',
                ],
                'help_block' => ['text' => 'Chỉ dùng khi loại = Tặng acc. Acc tặng sẽ trừ vào kho.'],
            ])
            ->add('label', TextField::class, [
                'label'    => 'Nhãn hiển thị (tuỳ chọn)',
                'required' => false,
                'attr'     => ['placeholder' => 'Ví dụ: Super Deal, Flash Sale...'],
            ])
            ->add('is_active', SelectField::class, [
                'label'   => 'Kích hoạt',
                'choices' => [1 => 'Bật', 0 => 'Tắt'],
                'value'   => (int)($this->getModel()->is_active ?? 1),
            ])
            ->add('sort_order', NumberField::class, [
                'label' => 'Thứ tự sắp xếp',
                'value' => (int)($this->getModel()->sort_order ?? 0),
                'attr'  => ['min' => 0, 'placeholder' => '0'],
            ]);
    }
}
