<?php

namespace Dev\Sitemap\Listeners;

use Dev\Sitemap\Events\SitemapUpdatedEvent;
use Dev\Sitemap\Jobs\IndexNowSubmissionJob;
use Dev\Sitemap\Services\IndexNowService;
use Carbon\Carbon;

class IndexNowSubmissionListener
{
    public function __construct(protected IndexNowService $indexNowService)
    {
    }

    public function handle(SitemapUpdatedEvent $event): void
    {
        if (! $this->indexNowService->isEnabled()) {
            return;
        }

        if (! $this->indexNowService->getApiKey()) {
            return;
        }

        IndexNowSubmissionJob::dispatch($event->sitemapUrl)
            ->delay(Carbon::now()->addSeconds(30));
    }
}
