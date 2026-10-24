<?php

namespace Dev\Telehub\Http\Requests;

use Dev\Support\Http\Requests\Request;

class TopupRequest extends Request
{
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ];
    }
}
