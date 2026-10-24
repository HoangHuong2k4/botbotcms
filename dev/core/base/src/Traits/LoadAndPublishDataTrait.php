<?php

namespace Dev\Base\Traits;

use Dev\Base\Supports\Helper;
use Dev\Base\Supports\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * @mixin ServiceProvider
 */
trait LoadAndPublishDataTrait
{
    protected ?string $namespace = null;

    protected function setNamespace(string $namespace): static
    {
        $this->namespace = ltrim(rtrim($namespace, '/'), '/');

        $this->app['config']->set(['core.base.general.plugin_namespaces.' . File::basename($this->getPath()) => $namespace]);

        return $this;
    }

    protected function getPath(?string $path = null, ?string $platform_path = 'dev', ?string $plugin_path = 'dev/plugins'): string
    {
        $reflection = new ReflectionClass($this);

        $modulePath = str_replace('/src/Providers', '', File::dirname($reflection->getFilename()));

        if (! Str::contains($modulePath, base_path($plugin_path))) {
            $modulePath = base_path($platform_path . '/' . $this->getDashedNamespace());
        }

        $modulePath = str_replace('/', DIRECTORY_SEPARATOR, $modulePath);

        return $modulePath . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }

    protected function loadAndPublishConfigurations(array|string $fileNames): static
    {
        if (! is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom($this->getConfigFilePath($fileName), $this->getDotedNamespace() . '.' . $fileName);

            if ($this->app->runningInConsole()) {
                $this->publishes([
                    $this->getConfigFilePath($fileName) => config_path($this->getDashedNamespace() . '/' . $fileName . '.php'),
                ], 'cms-config');
            }
        }

        return $this;
    }

    protected function getConfigFilePath(string $file, string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('config/' . $file . '.php', $platform_path, $plugin_path);
    }

    protected function getDashedNamespace(): string
    {
        return str_replace('.', '/', (string) $this->namespace);
    }

    protected function getDotedNamespace(): string
    {
        return str_replace('/', '.', (string) $this->namespace);
    }

    protected function loadRoutes(array|string $fileNames = ['web']): static
    {
        if (! is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $filePath = $this->getRouteFilePath($fileName);

            if ($filePath) {
                $this->loadRoutesFrom($filePath);
            }
        }

        return $this;
    }

    protected function getRouteFilePath(string $file, string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('routes/' . $file . '.php', $platform_path, $plugin_path);
    }

    protected function loadAndPublishViews(): static
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->getDashedNamespace());
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$this->getViewsPath() => resource_path('views/vendor/' . $this->getDashedNamespace())],
                'cms-views'
            );
        }

        return $this;
    }

    protected function getViewsPath(string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('/resources/views', $platform_path, $plugin_path);
    }

    public function loadAndPublishTranslations(): static
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->getDashedNamespace());
        $this->publishes(
            [$this->getTranslationsPath() => lang_path('vendor/' . $this->getDashedNamespace())],
            'cms-lang'
        );

        return $this;
    }

    protected function getTranslationsPath(string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('/resources/lang', $platform_path, $plugin_path);
    }

    protected function loadMigrations(): static
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());

        return $this;
    }

    protected function getMigrationsPath(string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('/database/migrations', $platform_path, $plugin_path);
    }

    protected function publishAssets(?string $path = null): static
    {
        if (empty($path)) {
            $path = 'vendor/core/' . $this->getDashedNamespace();
        }

        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

        $this->publishes([$this->getAssetsPath() => public_path($path)], 'cms-public');

        return $this;
    }

    protected function getAssetsPath(string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): string
    {
        return $this->getPath('public', $platform_path, $plugin_path);
    }

    protected function loadHelpers(string $platform_path = 'dev', string $plugin_path = 'dev/plugins'): static
    {
        Helper::autoload($this->getPath('/helpers', $platform_path, $plugin_path));

        return $this;
    }

    protected function loadAnonymousComponents(): static
    {
        $this->app['blade.compiler']->anonymousComponentPath(
            $this->getViewsPath() . '/components',
            str_replace('/', '-', (string) $this->namespace)
        );

        return $this;
    }

    protected function loadPermissionsRegistration(): static
    {
        $this->loadAndPublishConfigurations(['permissions']);

        return $this;
    }
}
