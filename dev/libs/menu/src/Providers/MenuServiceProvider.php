<?php

namespace Dev\Menu\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\DashboardMenuItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Menu\Facades\Menu;
use Dev\Menu\Models\Menu as MenuModel;
use Dev\Menu\Models\MenuLocation;
use Dev\Menu\Models\MenuNode;
use Dev\Menu\Repositories\Eloquent\MenuLocationRepository;
use Dev\Menu\Repositories\Eloquent\MenuNodeRepository;
use Dev\Menu\Repositories\Eloquent\MenuRepository;
use Dev\Menu\Repositories\Interfaces\MenuInterface;
use Dev\Menu\Repositories\Interfaces\MenuLocationInterface;
use Dev\Menu\Repositories\Interfaces\MenuNodeInterface;
use Dev\Theme\Events\RenderingAdminBar;
use Dev\Theme\Facades\AdminBar;

class MenuServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(MenuInterface::class, function () {
            return new MenuRepository(new MenuModel());
        });

        $this->app->bind(MenuNodeInterface::class, function () {
            return new MenuNodeRepository(new MenuNode());
        });

        $this->app->bind(MenuLocationInterface::class, function () {
            return new MenuLocationRepository(new MenuLocation());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/menu')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-core-menu')
                        ->parentId('cms-core-appearance')
                        ->priority(2)
                        ->name('libs/menu::menu.name')
                        ->icon('ti ti-tournament')
                        ->route('menus.index')
                        ->permissions('menus.index')
                );
        });

        $this->app['events']->listen(RenderingAdminBar::class, function (): void {
            AdminBar::registerLink(
                trans('libs/menu::menu.name'),
                route('menus.index'),
                'appearance',
                'menus.index'
            );
        });

        $this->app['events']->listen('cms.menu::registering-locations', function (): void {
            Menu::addMenuLocation('main-menu', trans('libs/menu::menu.main_navigation'));
        });

        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
    }
}
