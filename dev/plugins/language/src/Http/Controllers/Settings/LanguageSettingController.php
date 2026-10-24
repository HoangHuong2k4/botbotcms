<?php

namespace Dev\Language\Http\Controllers\Settings;

use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Language\Facades\Language;
use Dev\Language\Http\Requests\Settings\LanguageSettingRequest;
use Dev\Setting\Http\Controllers\SettingController;

class LanguageSettingController extends SettingController
{
    public function update(LanguageSettingRequest $request): BaseHttpResponse
    {
        $response = $this->performUpdate([
            ...$request->validated(),
            'language_hide_languages' => $request->input('language_hide_languages', []),
        ]);

        Language::clearCache();

        return $response;
    }
}
