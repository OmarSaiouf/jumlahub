<?php

use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});
