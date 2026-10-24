<?php

namespace Dev\Bootstrap\Providers;

use Illuminate\Support\Facades\Schema;

use Dev\Base\Supports\Helper;
use Dev\Base\Supports\ServiceProvider;
use Dev\Kernel\Traits\LoadAndPublishDataTrait;

class BootstrapServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        $this
            ->setNamespace('bootstrap')
            ->loadMigrations()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api']);
    }
}
