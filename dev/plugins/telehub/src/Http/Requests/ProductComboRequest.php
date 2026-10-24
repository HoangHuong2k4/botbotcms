<?php

namespace Dev\Telehub\Http\Requests;

use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductComboRequest extends Request
{
    public function rules(): array
    {
        return [
            'product_id'       => 'required|integer|exists:telehub_products,id',
            'min_quantity'     => 'required|integer|min:2',
            'type'             => ['required', Rule::in(['discount', 'bonus'])],
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_amount'  => 'nullable|numeric|min:0',
            'bonus_qty'        => 'nullable|integer|min:1',
            'label'            => 'nullable|string|max:100',
            'is_active'        => 'nullable|boolean',
            'sort_order'       => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'min_quantity.min' => 'Số lượng tối thiểu phải ≥ 2.',
            'type.in'          => 'Loại combo phải là discount hoặc bonus.',
        ];
    }
}
