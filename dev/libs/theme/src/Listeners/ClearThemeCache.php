<?php

namespace Dev\Theme\Listeners;

use Dev\Base\Events\CacheCleared;
use Dev\Theme\Facades\Manager as ThemeManager;

class ClearThemeCache
{
    public function handle(CacheCleared $event): void
    {
        if (in_array($event->cacheType, ['framework', 'all'])) {
            ThemeManager::clearCache();
        }
    }
}
