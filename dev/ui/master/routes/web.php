<?php

use Dev\Base\Http\Middleware\RequiresJsonRequestMiddleware;
use Dev\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Master\Http\Controllers\MasterController;

Theme::registerRoutes(function (): void {
    // API routes - không cần controller group
    Route::group(['prefix' => 'api'], function (): void {
        // API route để load thêm tin tức cho trang news
        Route::get('news', function () {
            $page       = request('page', 1);
            $perPage    = request('per_page', 9);
            $categoryId = request('category_id', null);

            return response()->json(get_news_paginated_data($page, $perPage, $categoryId));
        });

        // API route để lấy danh sách categories
        Route::get('news-categories', function () {
            return response()->json(get_news_categories());
        });

        // API route để lấy theme translations cho React (sử dụng helper function)
        Route::get('v1/translations/theme', function () {
            return get_theme_translations_json_response();
        })->name('api.translations.theme');
    });

    // Public routes với MasterController
    Route::group(['controller' => MasterController::class], function (): void {
        Route::middleware(RequiresJsonRequestMiddleware::class)
            ->group(function (): void {
                Route::get('ajax/search', 'getSearch')->name('public.ajax.search');
            });

        // Route cho trang chi tiết tin tức
        Route::get('news/{slug}', 'getNewsDetail')->name('public.news.detail');
    });
});

Theme::routes();
