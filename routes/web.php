<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/test.php';

Route::middleware(['web'])->group(function () {
    require __DIR__ . '/web/auth/auth.php';

    Route::middleware(['auth'])->group(function () {
        require __DIR__ . '/web/product/product.php';
    });
});
