<?php
namespace Dev\Contact\Http\Requests;

use Dev\Base\Rules\EmailRule;
use Dev\Base\Rules\PhoneNumberRule;
use Dev\Support\Http\Requests\Request;

class CreateContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:60'],
            'email'           => ['required', new EmailRule(), 'max:60'],
            'phone'           => ['required', new PhoneNumberRule(), 'max:60'],
            'visitModelHouse' => ['nullable', 'boolean'],
            'deepConsultation' => ['nullable', 'boolean'],
            'gender' => ['required', 'string', 'max:60'],
            'content' => ['nullable'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'Vui lòng nhập họ',
            'name.max'       => 'Họ không được quá 60 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.max'      => 'Email không được quá 60 ký tự',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max'      => 'Số điện thoại không được quá 60 ký tự',
            'gender.required' => 'Vui lòng chọn giới tính',
            'gender.max' => 'Giới tính không được quá 60 ký tự',
        ];
    }
}
