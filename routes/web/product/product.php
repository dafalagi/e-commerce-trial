<?php

use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::get('/', [\App\Http\Controllers\Web\Product\ProductController::class, 'index'])->name('product.index');
});