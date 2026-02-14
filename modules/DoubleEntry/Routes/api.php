<?php

use Illuminate\Support\Facades\Route;

/**
 * 'api' prefix applied to all routes
 *
 * @see \App\Providers\Route::mapApiRoutes
 */

Route::group([
    'middleware' => 'api',
    'prefix' => 'api',
    'namespace' => 'Modules\DoubleEntry\Http\Controllers\Api'
], function () {
    // Override default route
    Route::group(['as' => 'api.'], function () {
        Route::apiResource('journal-entry', 'JournalEntry');
    });
});