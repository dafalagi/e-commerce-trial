<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('login', [\App\Http\Controllers\API\Admin\Auth\AuthController::class, 'login']);
    
    Route::middleware(['auth:api', 'token.admin'])->group(function() {
        require __DIR__ . '/role.php';
        require __DIR__ . '/permission.php';

        Route::get('user-session', [\App\Http\Controllers\API\Admin\Auth\AuthController::class, 'userSession']);
        Route::post('logout', [\App\Http\Controllers\API\Admin\Auth\AuthController::class, 'logout']);
        Route::post('forgot-password', [\App\Http\Controllers\API\Admin\Auth\AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [\App\Http\Controllers\API\Admin\Auth\AuthController::class, 'resetPassword']);
    });
});
