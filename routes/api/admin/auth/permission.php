<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('permission')->group(function() {
    Route::get('{permission_uuid?}', [\App\Http\Controllers\API\Admin\Auth\PermissionController::class, 'get']);
});
