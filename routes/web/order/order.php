<?php

use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::get('{order}', [\App\Http\Controllers\Web\Order\OrderController::class, 'show'])->name('orders.show');
});