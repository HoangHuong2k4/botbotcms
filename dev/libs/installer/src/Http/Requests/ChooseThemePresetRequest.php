<?php

namespace Dev\Installer\Http\Requests;

use Dev\Installer\InstallerStep\InstallerStep;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ChooseThemePresetRequest extends Request
{
    public function rules(): array
    {
        return [
            'theme_preset' => ['required', 'string', Rule::in(array_keys(InstallerStep::getThemePresets()))],
        ];
    }
}
