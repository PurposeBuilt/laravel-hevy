<?php

namespace Purposebuiltscott\LaravelHevy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class HevyApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/hevy.php', 'hevy');

        $this->app->bind(HevyApiClient::class, function ($app, array $parameters = []) {
            $apiKey = $parameters['api_key'] ?? null;
            return new HevyApiClient($apiKey);
        });
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/config/hevy.php' => config_path('hevy.php'),
            //__DIR__ . '/config/hevy.php' => config_path('hevy.php'),
        ], 'config');
    }
}
