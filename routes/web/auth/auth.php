<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Web\Auth\AuthController::class, 'login'])->name('login');

Route::middleware(['guest'])->group(function () {
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Web\Auth\AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Web\Auth\AuthController::class, 'logout'])->name('logout');
});