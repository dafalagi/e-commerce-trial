<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('file-system')->group(function() {
    Route::post('', [\App\Http\Controllers\API\Admin\FileSystem\FileStorageController::class, 'store']);
});