<?php

namespace Dev\Base\Providers;

use Dev\Base\Supports\BreadcrumbsManager;
use Dev\Base\Supports\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * @deprecated This service provider does not need anymore.
 */
class BreadcrumbsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(BreadcrumbsManager::class);
    }

    public function provides(): array
    {
        return [BreadcrumbsManager::class];
    }
}
