<?php

namespace Dev\Gallery\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Gallery\Facades\Gallery;
use Dev\Gallery\Models\Gallery as GalleryModel;
use Dev\SeoHelper\Facades\SeoHelper;
use Dev\Theme\Facades\Theme;

class PublicController extends BaseController
{
    public function getGalleries()
    {
        $galleries = GalleryModel::query()
            ->wherePublished()
            ->with(['slugable', 'user'])
            ->oldest('order')->latest()
            ->get();

        SeoHelper::setTitle(trans('plugins/gallery::gallery.galleries'));

        Theme::breadcrumb()->add(trans('plugins/gallery::gallery.galleries'), Gallery::getGalleriesPageUrl());

        return Theme::scope('galleries', compact('galleries'), 'plugins/gallery::themes.galleries')
            ->render();
    }
}
