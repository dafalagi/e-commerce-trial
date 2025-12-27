<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('role')->group(function() {
    require __DIR__ . '/role-permission.php';

    Route::post('', [\App\Http\Controllers\API\Admin\Auth\RoleController::class, 'store']);
    Route::put('{role_uuid}', [\App\Http\Controllers\API\Admin\Auth\RoleController::class, 'update']);
    Route::delete('{role_uuid}', [\App\Http\Controllers\API\Admin\Auth\RoleController::class, 'delete']);
    Route::get('{role_uuid?}', [\App\Http\Controllers\API\Admin\Auth\RoleController::class, 'get']);
});
