<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api'],
    'prefix'    => 'api/v1',
    'namespace' => 'Dev\Bootstrap\Http\Controllers\API\v1',
    'as' => 'bootstrap.api.v1.'
], function () {});
