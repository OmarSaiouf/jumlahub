<?php

use App\Core\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});
