<?php

namespace Dev\Widget\Widgets;

use Dev\Base\Facades\Html;
use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Theme\Supports\ThemeSupport;
use Dev\Widget\AbstractWidget;
use Dev\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class SiteCopyright extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => trans('libs/widget::widget.widget_site_copyright'),
            'description' => trans('libs/widget::widget.widget_site_copyright_description'),
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'description',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(
                        trans('libs/widget::widget.widget_site_copyright_helper', [
                            'link' => Html::link(route('theme.options'), trans('libs/widget::widget.theme_options')),
                        ])
                    )
            );
    }

    protected function data(): array|Collection
    {
        return [
            'copyright' => ThemeSupport::getSiteCopyright(),
        ];
    }
}
