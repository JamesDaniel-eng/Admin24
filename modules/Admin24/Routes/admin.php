<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'admin24' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('admin24', function () {
    Route::get('businesses', 'Main@index')->name('businesses');
    Route::get('businesses/add', 'Main@create')->name('business.add');
    Route::post('add-business', 'Main@store')->name('business.store');
    Route::get('businesses/view/{id}', 'Main@view')->name('business.view');
    Route::get('businesses/edit/{id}', 'Main@edit')->name('business.edit');
    Route::post('transfer-orders/import', 'Main@import')->name('transfer-orders.import');
    Route::resource('transfer-orders', 'ImportController');

    //Settings
    Route::get('settings/quantities', 'Settings@index')->name('settings.quantities');
    Route::get('settings/quantities/add', 'Settings@create')->name('settings.quantities.add');    
    Route::get('settings/quantities/{id}/edit', 'Settings@edit')->name('settings.quantities.edit');
    Route::get('settings/quantities/set', 'Settings@set')->name('settings.quantities.set');    
    Route::post('settings/quantities/{id}/update', 'Settings@update')->name('settings.quantities.update');
    Route::post('settings/quantities/store', 'Settings@store')->name('settings.quantities.store');
    Route::post('settings', 'Settings@setUpdate')->name('settings.quantities.setupdate');
});
