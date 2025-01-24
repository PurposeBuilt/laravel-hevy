<?php

namespace Purposebuiltscott\LaravelHevy;

use Illuminate\Support\ServiceProvider;
use function base_path;

class HevyApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/hevy.php', 'hevy');

        $this->app->singleton(HevyApiClient::class, function () {
            return new HevyApiClient(
                config('hevy.api_key')
            );
        });
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/config/hevy.php' => base_path('config/hevy.php'),
        ], 'config');
    }
}
