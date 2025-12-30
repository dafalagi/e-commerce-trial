<?php

use App\Jobs\SendLowStockNotification;
use Illuminate\Support\Facades\Route;

Route::get('test', function() {
    SendLowStockNotification::dispatch(
        '019b6f21-7434-70a0-bd57-305ef38ce6ae',
        1,
        'Sample Product',
        5
    );

    return 'Low stock notification job dispatched.';
});