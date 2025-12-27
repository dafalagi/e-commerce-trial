<?php

namespace App\Providers\RegisterService;

use App\Providers\AppServiceProvider;

class RegisterProductFeatService extends AppServiceProvider
{
    public function register(): void
    {
        /** Product */
        $this->registerService('StoreProductService', \App\Services\Product\Product\StoreProductService::class);
        $this->registerService('UpdateProductService', \App\Services\Product\Product\UpdateProductService::class);
        $this->registerService('DeleteProductService', \App\Services\Product\Product\DeleteProductService::class);
        $this->registerService('GetProductService', \App\Services\Product\Product\GetProductService::class);
    }
}