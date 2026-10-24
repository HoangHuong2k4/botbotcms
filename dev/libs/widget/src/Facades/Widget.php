<?php

namespace Dev\Widget\Facades;

use Dev\Widget\AbstractWidget;
use Dev\Widget\WidgetGroup;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\Widget\Factories\WidgetFactory registerWidget(string $widget)
 * @method static array getWidgets()
 * @method static \Illuminate\Support\HtmlString|string|null run()
 * @method static void ignoreCaches(array $widgets)
 *
 * @see \Dev\Widget\Factories\WidgetFactory
 */
class Widget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'apps.widget';
    }

    public static function group(string $name): WidgetGroup
    {
        return app('apps.widget-group-collection')->group($name);
    }

    public static function ignoreCaches(array $widgets): void
    {
        AbstractWidget::ignoreCaches($widgets);
    }
}
