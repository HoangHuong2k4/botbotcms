<?php

use Dev\Theme\Facades\Theme;
use Dev\Theme\Theme as BaseTheme;
use Illuminate\Routing\Events\RouteMatched;

app('events')->listen(RouteMatched::class, function (): void {
    if (! method_exists(BaseTheme::class, 'registerThemeIconFields')) {
        return;
    }

    Theme::registerThemeIconFields([]);
});
