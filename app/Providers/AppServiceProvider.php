<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Parsedown;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Parsedown::class, function ($app) {
            $parsedown = new Parsedown();
            $parsedown->setSafeMode(true);
            return $parsedown;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
