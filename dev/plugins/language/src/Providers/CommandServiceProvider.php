<?php

namespace Dev\Language\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Language\Commands\AddLanguageCommand;
use Dev\Language\Commands\RemoveLanguageCommand;
use Dev\Language\Commands\RouteCacheCommand;
use Dev\Language\Commands\RouteClearCommand;
use Dev\Language\Commands\RouteTranslationsListCommand;
use Illuminate\Foundation\Console\RouteCacheCommand as BaseRouteCacheCommand;
use Illuminate\Foundation\Console\RouteClearCommand as BaseRouteClearCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            RouteTranslationsListCommand::class,
            AddLanguageCommand::class,
            RemoveLanguageCommand::class,
        ]);

        $this->app->extend(BaseRouteCacheCommand::class, function () {
            return new RouteCacheCommand($this->app['files']);
        });

        $this->app->extend(BaseRouteClearCommand::class, function () {
            return new RouteClearCommand($this->app['files']);
        });
    }
}
