<?php

use App\Core\Http\Controllers\DashboardController;
use App\Core\Http\Controllers\HomeController;
use App\Core\Http\Controllers\OrdersController;
use App\Core\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');

Route::get('/', [HomeController::class, 'index']);

Route::prefix("orders")->middleware(['auth:web'])->group(function () {
    Route::get('/', [OrdersController::class, "myOrder"])->name('my.order');
    Route::post("/createOrder", [OrdersController::class, "store"])->name('create.order');
});

Route::prefix("payment")->middleware(['auth:web'])->group(function () {
    Route::get('/', [PaymentController::class, "show"])->name('payment.show');
    Route::post("/pay", [PaymentController::class, "pay"])->name('payment.pay');
});
Route::post("/callback", [PaymentController::class, "callback"])->name('payment.callback');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
