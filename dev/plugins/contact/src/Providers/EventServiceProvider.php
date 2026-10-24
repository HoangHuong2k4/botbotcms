<?php

namespace Dev\Contact\Providers;

use Dev\Contact\Events\SentContactEvent;
use Dev\Contact\Listeners\SendContactEmailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SentContactEvent::class => [
            SendContactEmailListener::class,
        ],
    ];
}
