<?php

namespace Dev\Widget\Providers;

use Dev\Base\Facades\AdminHelper;
use Dev\Base\Supports\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        add_filter(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, function (?string $html) {
            if (! AdminHelper::isInAdmin(true) || ! Auth::check()) {
                return $html;
            }

            if (Route::currentRouteName() === 'settings.cache') {
                return $html;
            }

            if (setting('widget_cache_enabled', false)) {
                return $html;
            }

            if (isset($_COOKIE['widget_cache_suggestion_dismissed']) && $_COOKIE['widget_cache_suggestion_dismissed'] == '1') {
                return $html;
            }

            return $html . view('libs/widget::partials.widget-cache-suggestion')->render();
        }, 6);
    }
}
