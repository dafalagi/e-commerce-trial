<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Web\Auth\AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Web\Auth\AuthController::class, 'logout'])->name('logout');
});