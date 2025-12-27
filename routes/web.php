<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/web/test.php';

Route::get('/', function () {
    return view('components.layouts.app');
})->name('products.index');

Route::get('cart', function () {
    return view('cart.index');
})->name('cart.index');
