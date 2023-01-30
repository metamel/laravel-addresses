<?php

declare(strict_types=1);

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
                __DIR__.'/../../config/addresses.php' => config_path('addresses.php'),
            ],
            'addresses-config'
        );

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
