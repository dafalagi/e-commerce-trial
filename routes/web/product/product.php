<?php

use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [\App\Http\Controllers\Web\Product\ProductController::class, 'index'])->name('products.index');
});