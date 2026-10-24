<?php

namespace Dev\Slug\Providers;

use Dev\Base\Contracts\BaseModel;
use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Supports\ServiceProvider;
use Dev\Slug\Facades\SlugHelper;
use Dev\Slug\Forms\Fields\PermalinkField;
use Dev\Theme\Facades\Theme;
use Dev\Theme\FormFront;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_BEFORE_RENDER_FORM, [$this, 'addSlugBox'], 1712);

        add_filter('core_slug_language', [$this, 'setSlugLanguageForGenerator'], 17);
    }

    public function addSlugBox(FormAbstract $form): FormAbstract
    {
        if ($form->isDisabledPermalinkField()) {
            return $form;
        }

        $model = $form->getModel();

        if (! $model instanceof BaseModel || ! SlugHelper::isSupportedModel($model::class)) {
            return $form;
        }

        if (array_key_exists('slug', $form->getFields())) {
            return $form;
        }

        if ($form instanceof FormFront) {
            $version = get_cms_version();

            Theme::asset()->container('footer')->usePath(false)->add('slug-js', 'vendor/core/libs/slug/js/front-slug.js', ['jquery'], version: $version);
            Theme::asset()->usePath(false)->add('slug-css', 'vendor/core/libs/slug/css/slug.css', version: $version);
        } else {
            Assets::addScriptsDirectly('vendor/core/libs/slug/js/slug.js')->addStylesDirectly('vendor/core/libs/slug/css/slug.css');
        }

        return $form
            ->addAfter(SlugHelper::getColumnNameToGenerateSlug($model), 'slug', PermalinkField::class, [
                'model' => $model,
                'colspan' => 'full',
            ]);
    }

    public function setSlugLanguageForGenerator(): bool|string
    {
        return SlugHelper::turnOffAutomaticUrlTranslationIntoLatin() ? false : 'en';
    }
}
