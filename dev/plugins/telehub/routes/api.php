<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace'  => 'Dev\Telehub\Http\Controllers\Api',
    'prefix'     => 'api/v1/telehub',
    'as'         => 'api.telehub.',
    'middleware' => ['api'],
], function () {
    Route::get('user', 'ThirdPartyApiController@getUserInfo')->name('user');
    Route::get('products', 'ThirdPartyApiController@getProducts')->name('products');
    Route::post('buy', 'ThirdPartyApiController@buyProducts')->name('buy');
    Route::get('orders', 'ThirdPartyApiController@getOrders')->name('orders');
});
