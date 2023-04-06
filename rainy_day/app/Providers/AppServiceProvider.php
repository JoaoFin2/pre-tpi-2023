<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WeatherService;
use App\Services\SwissMeteoService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WeatherService::class, function ($app) {
            return new WeatherService();
        });
        $this->app->singleton(SwissMeteoService::class, function ($app) {
            return new SwissMeteoService($app->make(WeatherService::class));
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
