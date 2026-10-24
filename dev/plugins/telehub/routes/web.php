<?php

namespace Dev\Telehub\Routes;

use Dev\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['namespace' => 'Dev\Telehub\Http\Controllers', 'prefix' => 'telehub', 'as' => 'telehub.'], function () {
        Route::resource('tenants', 'TenantController');
        Route::post('bot-configs/restart-api', [
            'as'         => 'bot-configs.restart-api',
            'uses'       => 'BotConfigController@restartApi',
            'permission' => 'telehub.bot-configs.edit',
        ]);
        Route::resource('bot-configs', 'BotConfigController');
        Route::resource('products', 'ProductController');
        Route::get('product-items/api', [
            'as' => 'product-items.api',
            'uses' => 'ProductItemController@apiItems',
            'permission' => 'telehub.product-items.index',
        ]);
        Route::post('product-items/bulk-move', [
            'as' => 'product-items.bulk-move',
            'uses' => 'ProductItemController@bulkMove',
            'permission' => 'telehub.product-items.edit',
        ]);
        Route::resource('product-items', 'ProductItemController');

        // Product Combos (Mua combo ưu đãi)
        Route::get('product-combos/by-product/{productId}', [
            'as'         => 'product-combos.by-product',
            'uses'       => 'ProductComboController@apiByProduct',
            'permission' => 'telehub.product-combos.index',
        ]);
        Route::resource('product-combos', 'ProductComboController');

        Route::resource('bot-customers', 'BotCustomerController');
        Route::group(['prefix' => 'bot-customers', 'as' => 'bot-customers.'], function () {
            Route::get('clean-inactive', 'BotCustomerController@cleanInactive')->name('clean-inactive');
            Route::get('{bot_customer}/topup', 'BotCustomerController@getTopup')->name('topup')->middleware('can:telehub.bot-customers.topup');
            Route::post('{bot_customer}/topup', 'BotCustomerController@postTopup')->name('topup.post')->middleware('can:telehub.bot-customers.topup');
        });
        Route::resource('balance-logs', 'BalanceLogController');
        Route::resource('deposit-requests', 'DepositRequestController');
        
        Route::get('manual-deposit', [
            'as'         => 'manual-deposit.index',
            'uses'       => 'ManualDepositController@index',
            'permission' => 'telehub.manual-deposit.index',
        ]);
        Route::post('manual-deposit', [
            'as'         => 'manual-deposit.process',
            'uses'       => 'ManualDepositController@process',
            'permission' => 'telehub.manual-deposit.index',
        ]);

        Route::resource('bank-webhooks', 'BankWebhookController');
        
        // Orders (Vue SPA)
        Route::get('orders/api', [
            'as' => 'orders.api',
            'uses' => 'OrderController@api',
            'permission' => 'telehub.orders.index',
        ]);
        Route::get('orders/api/stats', [
            'as' => 'orders.api.stats',
            'uses' => 'OrderController@apiStats',
            'permission' => 'telehub.orders.index',
        ]);
        Route::get('orders/api/products', [
            'as' => 'orders.api.products',
            'uses' => 'OrderController@apiProducts',
            'permission' => 'telehub.orders.index',
        ]);
        Route::post('orders/{id}/type', [
            'as'         => 'orders.update_type',
            'uses'       => 'OrderController@updateType',
            'permission' => 'telehub.orders.edit',
        ]);
        Route::post('orders/{id}/price', [
            'as'         => 'orders.update_price',
            'uses'       => 'OrderController@updatePrice',
            'permission' => 'telehub.orders.edit',
        ]);
        Route::post('orders/{id}/warranty', [
            'as'         => 'orders.warranty',
            'uses'       => 'OrderController@handleWarranty',
            'permission' => 'telehub.orders.edit',
        ]);
        
        Route::group(['prefix' => 'dealers', 'as' => 'dealers.'], function () {
            Route::get('api', [
                'as'         => 'api',
                'uses'       => 'DealerController@getDealers',
                'permission' => 'telehub.dealers.index',
            ]);
            Route::get('api/stats', [
                'as'         => 'stats',
                'uses'       => 'DealerController@getDealerStats',
                'permission' => 'telehub.dealers.index',
            ]);
            Route::get('{id}/purchases', [
                'as'         => 'purchases',
                'uses'       => 'DealerController@getDealerPurchases',
                'permission' => 'telehub.dealers.index',
            ]);
            Route::post('{id}/api-key', [
                'as'         => 'api_key',
                'uses'       => 'DealerController@generateApiKey',
                'permission' => 'telehub.dealers.edit',
            ]);
            Route::post('{id}/toggle', [
                'as'         => 'toggle',
                'uses'       => 'DealerController@toggleDealer',
                'permission' => 'telehub.dealers.edit',
            ]);
            Route::get('{id}/prices', [
                'as'         => 'prices',
                'uses'       => 'DealerController@getDealerPrices',
                'permission' => 'telehub.dealers.index',
            ]);
            Route::post('{id}/prices', [
                'as'         => 'set_price',
                'uses'       => 'DealerController@setDealerPrice',
                'permission' => 'telehub.dealers.edit',
            ]);
            Route::get('search-customers', [
                'as'         => 'search_customers',
                'uses'       => 'DealerController@searchCustomers',
                'permission' => 'telehub.dealers.edit',
            ]);
            Route::post('clear-all-prices', [
                'as'         => 'clear_all_prices',
                'uses'       => 'DealerController@clearAllPrices',
                'permission' => 'telehub.dealers.edit',
            ]);
        });
        Route::resource('dealers', 'DealerController');
        Route::resource('orders', 'OrderController');
        Route::resource('convert-data', 'ConvertDataController');

        // API Providers (Đấu nối API nhà cung cấp)
        Route::group(['prefix' => 'api-providers', 'as' => 'api-providers.'], function () {
            Route::get('', [
                'as'         => 'index',
                'uses'       => 'ApiProviderController@index',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::get('list', [
                'as'         => 'list',
                'uses'       => 'ApiProviderController@list',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('', [
                'as'         => 'store',
                'uses'       => 'ApiProviderController@store',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::put('{id}', [
                'as'         => 'update',
                'uses'       => 'ApiProviderController@update',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::delete('{id}', [
                'as'         => 'destroy',
                'uses'       => 'ApiProviderController@destroy',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/check-balance', [
                'as'         => 'check-balance',
                'uses'       => 'ApiProviderController@checkBalance',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::get('{id}/catalog', [
                'as'         => 'catalog',
                'uses'       => 'ApiProviderController@catalog',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/import', [
                'as'         => 'import',
                'uses'       => 'ApiProviderController@import',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/toggle-product-status', [
                'as'         => 'toggle-product-status',
                'uses'       => 'ApiProviderController@toggleProductStatus',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/unlink-product', [
                'as'         => 'unlink-product',
                'uses'       => 'ApiProviderController@unlinkProduct',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/bulk-status', [
                'as'         => 'bulk-status',
                'uses'       => 'ApiProviderController@bulkStatus',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::post('{id}/sync', [
                'as'         => 'sync',
                'uses'       => 'ApiProviderController@sync',
                'permission' => 'telehub.api-providers.index',
            ]);
            Route::get('{id}/orders', [
                'as'         => 'orders',
                'uses'       => 'ApiProviderController@orders',
                'permission' => 'telehub.api-providers.index',
            ]);
        });

        Route::get('statistics', 'StatisticsController@index')->name('statistics.index');
        Route::get('statistics/api', [
            'as' => 'statistics.api',
            'uses' => 'StatisticsController@api',
            'permission' => 'telehub.statistics.index',
        ]);

        // User Analytics (bot user behaviour)
        Route::get('user-analytics', [
            'as'         => 'user-analytics.index',
            'uses'       => 'UserAnalyticsController@index',
            'permission' => 'telehub.user-analytics.index',
        ]);
        Route::get('user-analytics/api', [
            'as'         => 'user-analytics.api',
            'uses'       => 'UserAnalyticsController@api',
            'permission' => 'telehub.user-analytics.index',
        ]);

        Route::resource('notifications', 'NotificationController');

        Route::prefix('tools/data-synchronize')->name('tools.data-synchronize.')->group(function () {
            Route::prefix('import')->name('import.')->group(function () {
                Route::group(['prefix' => 'product-items', 'as' => 'product-items.', 'permission' => 'telehub.product-items.create'], function () {
                    Route::get('/', 'ImportProductItemController@index')->name('index');
                    Route::post('/', 'ImportProductItemController@import')->name('store');
                    Route::post('validate', 'ImportProductItemController@validateData')->name('validate');
                    Route::post('download-example', 'ImportProductItemController@downloadExample')->name('download-example');
                });
            });
        });
    });
});

Route::domain('{subdomain}.' . env('APP_DOMAIN', 'cms-tele.test'))->group(function () {
    Route::group([
        'namespace' => 'Dev\Telehub\Http\Controllers',
        'middleware' => ['web', 'telehub.tenant'],
    ], function () {
        Route::get('/', 'PublicController@index')->name('tenant.public.index');
        Route::get('/products', 'PublicController@products')->name('tenant.public.products');
    });
});
