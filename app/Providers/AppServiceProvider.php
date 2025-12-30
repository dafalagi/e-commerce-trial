<?php

namespace App\Providers;

use App\Models\Auth\User;
use Carbon\CarbonInterval;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        /**
         * Add service to be registered, grouped based on feature
         */
        $this->app->register(\App\Providers\RegisterService\RegisterAuthFeatService::class);
        $this->app->register(\App\Providers\RegisterService\RegisterFileSystemFeatService::class);
        $this->app->register(\App\Providers\RegisterService\RegisterProductFeatService::class);
        $this->app->register(\App\Providers\RegisterService\RegisterOrderFeatService::class);
        $this->app->register(\App\Providers\RegisterService\RegisterNotificationFeatService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(CarbonInterval::days(7));
        Passport::refreshTokensExpireIn(CarbonInterval::days(14));
        
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FE_URL').'/reset-password?token='.$token.'&email='.urlencode($user->email);
        });
        
        Relation::morphMap([

        ]);
    }

    protected function registerService($serviceName, $className)
    {
        $this->app->singleton($serviceName, function () use ($className) {
            return new $className();
        });
    }
}
