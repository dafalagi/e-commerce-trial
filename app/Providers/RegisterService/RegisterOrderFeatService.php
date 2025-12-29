<?php

namespace App\Providers\RegisterService;

use App\Providers\AppServiceProvider;

class RegisterOrderFeatService extends AppServiceProvider
{
    public function register(): void
    {
        /** Cart */
        $this->registerService('StoreCartService', \App\Services\Order\Cart\StoreCartService::class);
        $this->registerService('UpdateCartService', \App\Services\Order\Cart\UpdateCartService::class);
        $this->registerService('DeleteCartService', \App\Services\Order\Cart\DeleteCartService::class);
        $this->registerService('GetCartService', \App\Services\Order\Cart\GetCartService::class);
    }
}