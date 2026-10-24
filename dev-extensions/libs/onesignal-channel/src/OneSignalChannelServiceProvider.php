<?php

namespace Dev\OneSignalChannel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class OneSignalChannelServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::extend('onesignal', function ($app) {
            return new Channels\OneSignalChannel($this->app['config']['services.onesignal.app_id'], $this->app['config']['services.onesignal.rest_api_key'], $this->app["config"]["services.onesignal.user_auth_key"]);
        });
    }
}
