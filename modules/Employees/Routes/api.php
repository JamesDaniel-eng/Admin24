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
    'namespace' => 'Modules\Employees\Http\Controllers\Api'
], function () {
    // Override default route
    Route::group(['as' => 'api.'], function () {
        Route::apiResource('employees', 'Employees', ['middleware' => ['dropzone']]);
        Route::apiResource('departments', 'Departments');
        Route::apiResource('dismissals', 'Dismissals');
    });
});