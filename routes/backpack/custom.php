<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Modules\Admin\Http\Controllers',
], function () { // custom admin routes
    Route::crud('city', 'CityCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('currency', 'CurrencyCrudController');
    Route::crud('language', 'LanguageCrudController');
    Route::crud('payment-provider', 'PaymentProviderCrudController');
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('user', 'UserCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
