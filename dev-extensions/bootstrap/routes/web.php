<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Dev\Bootstrap\Http\Controllers',
    'middleware' => ['web', 'core'],
    'as' => 'bootstrap.'
], function () {});
