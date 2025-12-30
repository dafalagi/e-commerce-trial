<?php

namespace App\Providers\RegisterService;

use App\Providers\AppServiceProvider;

class RegisterNotificationFeatService extends AppServiceProvider
{
    public function register(): void
    {
        /** Notification */
        $this->registerService('StoreNotificationService', \App\Services\Notification\Notification\StoreNotificationService::class);
        $this->registerService('UpdateNotificationService', \App\Services\Notification\Notification\UpdateNotificationService::class);
        $this->registerService('DeleteNotificationService', \App\Services\Notification\Notification\DeleteNotificationService::class);
        $this->registerService('GetNotificationService', \App\Services\Notification\Notification\GetNotificationService::class);
    }
}