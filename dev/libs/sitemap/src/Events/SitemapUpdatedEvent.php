<?php

namespace Dev\Sitemap\Events;

use Dev\Base\Events\Event;

class SitemapUpdatedEvent extends Event
{
    public function __construct(public ?string $sitemapUrl = null)
    {
    }
}
