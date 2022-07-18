# Laravel-Addresses (Base on rinvex/laravel-addresses)
---

A polymorphic Laravel package to manage addresses. This package allow you to add addresses to any eloquent model with ease.

[![Packagist](https://img.shields.io/packagist/v/metamel/laravel-addresses.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/metamel/laravel-addresses)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/metamel/laravel-addresses.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/metamel/laravel-addresses/)
[![Travis](https://img.shields.io/travis/metamel/laravel-addresses.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/metamel/laravel-addresses)
[![StyleCI](https://styleci.io/repos/87485079/shield)](https://styleci.io/repos/87485079)
[![License](https://img.shields.io/packagist/l/metamel/laravel-addresses.svg?label=License&style=flat-square)](https://github.com/metamel/laravel-addresses/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require metamel/laravel-addresses
    ```

2. Publish config file:
    ```shell
    php artisan vendor:publish --tag=addresses-config
    ```

3. Execute migrations via the following command:
    ```shell
    php artisan migrate
    ```

4. Done!


## Usage

To add addresses support to your eloquent models simply use `\Metamel\Addresses\Traits\Addressable` trait.

### Manage your addresses

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Create a new address
$user->addresses()->create([
    'label' => 'Default Address',
    'name' => 'John Doe',
    'organization' => 'Something Went Wrong LTD.',
    'country_code' => 'gb',
    'street' => '10 Downing Street',
    'state' => 'somewhere over the rainbow',
    'city' => 'London',
    'postal_code' => 'SW1A 2AA',
    'latitude' => '51.503364',
    'longitude' => '-0.127625',
    'is_primary' => true,
    'is_billing' => true,
    'is_shipping' => true,
]);

// Create multiple new addresses
$user->addresses()->createMany([
    [...],
    [...],
    [...],
]);

// Find an existing address
$address = app('metamel.addresses.models.address')->find(1);

// Update an existing address
$address->update([
    'label' => 'Default Work Address',
]);

// Delete address
$address->delete();

// Alternative way of address deletion
$user->addresses()->where('id', 123)->first()->delete();
```

### Manage your addressable model

The API is intuitive and very straight forward, so let's give it a quick look:

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Get attached addresses collection
$user->addresses;

// Get attached addresses query builder
$user->addresses();

// Scope Primary Addresses
$primaryAddresses = app('metamel.addresses.models.address')->isPrimary()->get();

// Scope Billing Addresses
$billingAddresses = app('metamel.addresses.models.address')->isBilling()->get();

// Scope Shipping Addresses
$shippingAddresses = app('metamel.addresses.models.address')->isShipping()->get();

// Scope Addresses in the given country
$egyptianAddresses = app('metamel.addresses.models.address')->InCountry('eg')->get();

// Find all users within 5 kilometers radius from the latitude/longitude 31.2467601/29.9020376
$fiveKmAddresses = \App\Models\User::findByDistance(5, 'kilometers', '31.2467601', '29.9020376')->get();

// Alternative method to find users within certain radius
$user = new \App\Models\User();
$users = $user->lat('51.503364')->lng('-0.127625')->within(5, 'kilometers')->get();
```


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Help on](https://github.com/metamel/laravel-addresses/issues)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](packages/metamel/laravel-addresses/CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](packages/metamel/laravel-addresses/CONTRIBUTING.md#versioning)
- [Pull Requests](packages/metamel/laravel-addresses/CONTRIBUTING.md#pull-requests)
- [Coding Standards](packages/metamel/laravel-addresses/CONTRIBUTING.md#coding-standards)
- [Feature Requests](packages/metamel/laravel-addresses/CONTRIBUTING.md#feature-requests)
- [Git Flow](packages/metamel/laravel-addresses/CONTRIBUTING.md#git-flow)


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2022 Metamel, Some rights reserved.
