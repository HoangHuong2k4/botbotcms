<?php

namespace Dev\Gallery\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\DashboardMenuItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Gallery\Facades\Gallery as GalleryFacade;
use Dev\Gallery\Models\Gallery;
use Dev\Gallery\Models\GalleryMeta;
use Dev\Gallery\Repositories\Eloquent\GalleryMetaRepository;
use Dev\Gallery\Repositories\Eloquent\GalleryRepository;
use Dev\Gallery\Repositories\Interfaces\GalleryInterface;
use Dev\Gallery\Repositories\Interfaces\GalleryMetaInterface;
use Dev\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Events\ThemeRoutingBeforeEvent;
use Dev\Theme\Facades\SiteMapManager;
use Illuminate\Foundation\AliasLoader;

class GalleryServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(GalleryInterface::class, function () {
            return new GalleryRepository(new Gallery());
        });

        $this->app->bind(GalleryMetaInterface::class, function () {
            return new GalleryMetaRepository(new GalleryMeta());
        });

        AliasLoader::getInstance()->alias('Gallery', GalleryFacade::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/gallery')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(EventServiceProvider::class);

        $this->app['events']->listen(ThemeRoutingBeforeEvent::class, function (): void {
            SiteMapManager::registerKey(['galleries']);
        });

        SlugHelper::registering(function (): void {
            SlugHelper::registerModule(Gallery::class, fn () => trans('plugins/gallery::gallery.galleries'));
            SlugHelper::setPrefix(Gallery::class, 'galleries', true);
        });

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-gallery')
                        ->priority(5)
                        ->name('plugins/gallery::gallery.menu_name')
                        ->icon('ti ti-camera')
                        ->route('galleries.index')
                );
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Gallery::class, [
                'name',
                'description',
            ]);

            LanguageAdvancedManager::registerModule(GalleryMeta::class, [
                'images',
            ]);

            LanguageAdvancedManager::addTranslatableMetaBox('gallery_wrap');

            foreach (GalleryFacade::getSupportedModules() as $item) {
                $translatableColumns = array_merge(LanguageAdvancedManager::getTranslatableColumns($item), ['gallery']);

                LanguageAdvancedManager::registerModule($item, $translatableColumns);
            }
        }

        $this->app->booted(function (): void {
            SeoHelper::registerModule([Gallery::class]);

            $this->app->register(HookServiceProvider::class);
        });
    }
}
