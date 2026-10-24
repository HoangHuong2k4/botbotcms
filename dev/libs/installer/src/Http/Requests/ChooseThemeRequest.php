<?php

namespace Dev\Installer\Http\Requests;

use Dev\Installer\InstallerStep\InstallerStep;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ChooseThemeRequest extends Request
{
    public function rules(): array
    {
        return [
            'theme' => ['required', 'string', Rule::in(array_keys(InstallerStep::getThemes()))],
        ];
    }
}
