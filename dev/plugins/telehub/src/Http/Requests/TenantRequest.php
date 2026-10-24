<?php

namespace Dev\Telehub\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class TenantRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', 'max:100', Rule::unique('telehub_tenants', 'username')->ignore($this->route('tenant'))],
            'email' => ['required', 'email', 'max:150', Rule::unique('telehub_tenants', 'email')->ignore($this->route('tenant'))],
            'role_id' => ['nullable', 'exists:roles,id'],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'string', 'min:6'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:6'];
        }

        return $rules;
    }
}
