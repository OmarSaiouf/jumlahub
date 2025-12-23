<?php

use App\Core\Http\Controllers\CategoryController;
use App\Core\Http\Controllers\DashboardController;
use App\Core\Http\Controllers\HomeController;
use App\Core\Http\Controllers\OrdersController;
use App\Core\Http\Controllers\PaymentController;
use App\Core\Http\Controllers\PreferenceController;
use App\Core\Http\Controllers\ProductController;
use App\Core\Models\City;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


//------------
//  home
//------------
Route::get('/', [HomeController::class, 'index'])->name('home');

//------------
//  cities
// for ajax in register form
//------------
Route::get('/countries/{country}/cities', function ($countryId) {
    return Cache::remember("cities_country_$countryId", 60 * 60 * 60, function () use ($countryId) {
        return City::where('country_id', $countryId)
            ->select('id', 'name')
            ->get();
    });
});
Route::post('/preferences', [PreferenceController::class, 'update'])
    ->name('preferences.update');


//------------
//  orders
//------------
Route::prefix("orders")->middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/', [OrdersController::class, "myOrder"])->name('my.order');
    Route::post("/create", [OrdersController::class, "store"])->name('main.create.order');
    Route::post('cancel', [OrdersController::class, 'cancel'])->name('main.cancel.order');
});



//------------
//  payment
//------------
Route::prefix("payment")->middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/', [PaymentController::class, "show"])->name('web.payment.show');
    Route::post("/pay", [PaymentController::class, "pay"])->name('payment.pay');
});
Route::post("/callback", [PaymentController::class, "callback"])->name('payment.callback');

// ------------
// category
// ------------
Route::prefix('category')->group(function () {
    Route::get('/{id}', [CategoryController::class, 'show'])->name('main.category.show');
});

//------------
//  product
//------------
Route::prefix('product')->group(function () {
    Route::get('/{id}', [ProductController::class, 'show'])->name('main.product.show');
});


//------------
//  dashboard
//------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
