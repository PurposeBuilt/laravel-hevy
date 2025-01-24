<?php

namespace Purposebuiltscott\LaravelHevy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class HevyApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/hevy.php', 'hevy');

        $this->app->singleton(HevyApiClient::class, function () {
            return new HevyApiClient(
                Config::get('hevy.api_key')
            );
        });
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/config/hevy.php' => config_path('hevy.php'),
        ], 'config');
    }
}
