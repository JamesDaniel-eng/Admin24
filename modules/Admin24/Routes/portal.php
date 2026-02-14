<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/admin24' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('admin24', function () {
    Route::get('invoices/{invoice}', 'Main@show')->name('invoices.show');
    Route::post('invoices/{invoice}/confirm', 'Main@confirm')->name('invoices.confirm');

    //Landing Page Routes
    Route::get('/', 'Portal\Main@index')->name('dashboard');
    Route::get('customers', 'Portal\Customers@index')->name('showcustomers');
    Route::get('invoices', 'Portal\CustomerInvoices@index')->name('showcustomerinvoices');
    Route::get('receipts', 'Portal\CustomerInvoices@receipts')->name('showcustomerreceipts');
    Route::get('bills', 'Portal\Expenses@bills')->name('showbills');
    Route::get('vendors', 'Portal\Expenses@vendors')->name('showvendors');
    Route::get('employees', 'Portal\Assets@employees')->name('showemployees');
    Route::get('assets', 'Portal\Assets@index')->name('showassets');
    Route::get('inventory', 'Portal\Assets@inventory')->name('showinventory');
    Route::get('ledgers-and-journals', 'Portal\Assets@inventory')->name('show-ledgers-journals');
    Route::get('accounts', 'Portal\Banking@index')->name('showaccounts');
    Route::get('incomeaccounts', 'Portal\Banking@income_accs')->name('showincomeaccounts');
    Route::get('expenseaccounts', 'Portal\Banking@expense_accs')->name('showexpenseaccounts');
    Route::get('transactions', 'Portal\Banking@transactions')->name('showtransactions');
    Route::get('reconciliations', 'Portal\Banking@reconciliations')->name('showtreconciliations');
    Route::get('taxes', 'Portal\Taxes@index')->name('showtaxes');
    Route::get('taxbills', 'Portal\Taxes@bills')->name('showtaxbills');
    Route::get('fillings', 'Portal\Taxes@fillings')->name('showtaxfillings');
    Route::get('payments', 'Portal\Payments@index')->name('showpayments');
    Route::get('pay/invoices', 'Portal\Payments@invoices')->name('payinvoices');
    Route::get('pay/bills', 'Portal\Payments@bills')->name('paybills');
    Route::get('pay/taxes', 'Portal\Payments@taxes')->name('paytaxes');
});