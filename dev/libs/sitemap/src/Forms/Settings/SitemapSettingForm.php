<?php

namespace Dev\Sitemap\Forms\Settings;

use Dev\Base\Forms\FieldOptions\CheckboxFieldOption;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\FieldOptions\NumberFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Setting\Forms\SettingForm;
use Dev\Sitemap\Http\Requests\SitemapSettingRequest;

class SitemapSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('libs/sitemap::sitemap.settings.title'))
            ->setSectionDescription(trans('libs/sitemap::sitemap.settings.description'))
            ->setValidatorClass(SitemapSettingRequest::class)
            ->add(
                'sitemap_enabled',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('libs/sitemap::sitemap.settings.enable_sitemap'))
                    ->value($sitemapEnabled = setting('sitemap_enabled', true))
                    ->helperText(trans('libs/sitemap::sitemap.settings.enable_sitemap_help', ['url' => url('sitemap.xml')]))
            )
            ->addOpenCollapsible('sitemap_enabled', '1', $sitemapEnabled)
            ->add(
                'sitemap_info',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(view('libs/sitemap::partials.sitemap-info')->render())
            )
            ->add(
                'sitemap_items_per_page',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('libs/sitemap::sitemap.settings.sitemap_items_per_page'))
                    ->value(setting('sitemap_items_per_page', 1000))
                    ->helperText(trans('libs/sitemap::sitemap.settings.sitemap_items_per_page_help'))
                    ->min(10)
                    ->max(100000)
            )
            ->add(
                'indexnow_enabled',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('libs/sitemap::sitemap.settings.indexnow_enabled'))
                    ->value($indexNowEnabled = setting('indexnow_enabled', 0))
                    ->helperText(trans('libs/sitemap::sitemap.settings.indexnow_enabled_help'))
            )
            ->addOpenCollapsible('indexnow_enabled', '1', $indexNowEnabled)
            ->add(
                'indexnow_api_key',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('libs/sitemap::sitemap.settings.indexnow_api_key'))
                    ->value(setting('indexnow_api_key'))
                    ->helperText(trans('libs/sitemap::sitemap.settings.indexnow_api_key_help'))
                    ->placeholder('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')
            )
            ->add(
                'indexnow_info',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(view('libs/sitemap::partials.indexnow-info')->render())
            )
            ->addCloseCollapsible('indexnow_enabled', '1')
            ->addCloseCollapsible('sitemap_enabled', '1');
    }
}
