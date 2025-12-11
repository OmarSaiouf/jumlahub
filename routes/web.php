<?php

use App\Core\Http\Controllers\DashboardController;
use App\Core\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
