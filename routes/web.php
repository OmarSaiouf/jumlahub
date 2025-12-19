<?php

use App\Core\Http\Controllers\DashboardController;
use App\Core\Http\Controllers\HomeController;
use App\Core\Http\Controllers\OrdersController;
use App\Core\Http\Controllers\PaymentController;
use App\Core\Http\Controllers\PreferenceController;
use App\Core\Http\Controllers\ProductController;
use App\Core\Models\City;
use Illuminate\Support\Facades\Route;

Route::middleware('setLocaleAndCurrency')->group(function () {

    //------------
    //  home
    //------------
    Route::get('/', [HomeController::class, 'index']);

    //------------
    //  cities
    // for ajax in register form
    //------------
    Route::get('/countries/{country}/cities', function ($countryId) {
        return City::where('country_id', $countryId)
            ->select('id', 'name')
            ->get();
    });
    Route::post('/preferences', [PreferenceController::class, 'update'])
        ->name('preferences.update');


    //------------
    //  orders
    //------------
    Route::prefix("orders")->middleware(['auth:web', 'verified'])->group(function () {
        Route::get('/', [OrdersController::class, "myOrder"])->name('my.order');
        Route::post("/createOrder", [OrdersController::class, "store"])->name('create.order');
    });



    //------------
    //  payment
    //------------
    Route::prefix("payment")->middleware(['auth:web', 'verified'])->group(function () {
        Route::get('/', [PaymentController::class, "show"])->name('payment.show');
        Route::post("/pay", [PaymentController::class, "pay"])->name('payment.pay');
    });
    Route::post("/callback", [PaymentController::class, "callback"])->name('payment.callback');


    //------------
    //  product
    //------------
    Route::prefix('product')->group(function () {
        Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');
    });


    //------------
    //  dashboard
    //------------
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
    });

});