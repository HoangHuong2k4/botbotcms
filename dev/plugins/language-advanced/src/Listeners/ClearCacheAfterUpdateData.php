<?php

namespace Dev\LanguageAdvanced\Listeners;

use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Models\BaseModel;
use Dev\Support\Services\Cache\Cache;

class ClearCacheAfterUpdateData
{
    public function handle(UpdatedContentEvent $event): void
    {
        if (! $event->data instanceof BaseModel) {
            return;
        }

        Cache::make($event->data::class)->flush();
    }
}
