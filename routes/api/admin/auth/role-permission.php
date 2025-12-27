<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('permission')->group(function() {
    Route::put('', [\App\Http\Controllers\API\Admin\Auth\RolePermissionController::class, 'update']);
});
