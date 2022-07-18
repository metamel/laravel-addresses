<?php

namespace Metamel\Addresses\Providers;

use Illuminate\Support\ServiceProvider;

class AddressesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('metamel.addresses.models.address', config('addresses.models.address'));
    }

    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__.'/../../config/config.php' => config_path('addresses.php'),
            ],
            'addresses-config'
        );

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
