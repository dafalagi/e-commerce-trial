<?php

$providers = [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
];

if(env('APP_ENV') === 'local')
    $providers[] = App\Providers\TelescopeServiceProvider::class;

return $providers;
