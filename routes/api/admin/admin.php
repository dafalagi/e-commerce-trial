<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
    require __DIR__ . '/auth/auth.php';

    /**
     * Add API routes that need auth here
     * or declare their middleware in their own file and include them above.
     * 
     * Remember to also include 'token.admin' middleware when adding 'auth:api' middleware
     * to ensure that only admin users can access these routes.
     */
    Route::middleware(['auth:api', 'token.admin'])->group(function () {
        require __DIR__ . '/file-system/file-system.php';
    });
});
