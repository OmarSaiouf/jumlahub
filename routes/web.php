<?php

use App\Core\Http\Controllers\DashboardController;
use App\Core\Http\Controllers\HomeController;
use App\Core\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');

Route::get('/', [HomeController::class, 'index']);

Route::prefix("orders")->middleware(['auth:web'])->group(function () {
    Route::get('/', [OrdersController::class, "myOrder"])->name('my.order');
    Route::post("/createOrder", [OrdersController::class, "store"])->name('create.order');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
