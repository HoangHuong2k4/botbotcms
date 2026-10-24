<?php

namespace Dev\Telehub\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BotCustomerRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'telegram_id' => 'required|string|max:50',
            'username' => 'nullable|string|max:100',
            'full_name' => 'nullable|string|max:200',
            'balance' => 'numeric|min:0',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];

        if (\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $rules['tenant_id'] = 'required|exists:telehub_tenants,id';
        }

        return $rules;
    }
}
