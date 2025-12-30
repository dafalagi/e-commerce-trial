<?php

use App\Jobs\SendLowStockNotification;
use Illuminate\Support\Facades\Route;

Route::get('test', function() {
    SendLowStockNotification::dispatch(
        '019b6f34-fa2d-7381-8488-61d1576304a5',
        1,
        'Sample Product',
        5
    );

    return 'Low stock notification job dispatched.';
});