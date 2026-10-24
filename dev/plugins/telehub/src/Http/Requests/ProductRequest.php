<?php

namespace Dev\Telehub\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:220',
            'name_en' => 'nullable|string|max:220',
            'icon' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'warranty_unit' => 'nullable|string|in:day,hour',
            'price_usd' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
