<?php

namespace Dev\ACL\Http\Requests;

use Dev\ACL\Models\User;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Requests\Concerns\HasPhoneFieldValidation;
use Dev\Base\Rules\EmailRule;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateUserRequest extends Request
{
    use HasPhoneFieldValidation;

    protected function prepareForValidation(): void
    {
        $this->preparePhoneForValidation();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:60', 'min:2'],
            'last_name' => ['required', 'string', 'max:60', 'min:2'],
            'email' => [
                'required',
                'min:6',
                'max:120',
                new EmailRule(),
                Rule::unique((new User())->getTable(), 'email'),
            ],
            'password' => ['required', 'string', 'min:6', 'max:120', 'confirmed'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'min:3',
                'max:120',
                Rule::unique((new User())->getTable(), 'username'),
            ],
            'phone' => ['nullable', ...BaseHelper::getPhoneValidationRule(true)],
        ];
    }
}
