<?php

namespace Metamel\Addresses\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Metamel\Addresses\Models\Address;

trait Addressable
{
    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|\Metamel\Addresses\Models\Address
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(
            config('addresses.models.address'),
            Address::ADDRESSABLE,
            Address::COL_ADDRESSABLE_TYPE,
            Address::COL_ADDRESSABLE_ID
        );
    }

    /**
     * Boot the addressable trait for the model.
     *
     * @return void
     */
    public static function bootAddressable(): void
    {
        static::deleted(static function ($model) {
            $model->addresses()->delete();
        });
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Find addressable by distance.
     *
     * @param float $distance
     * @param string|null $measurementUnit
     * @param float|string|null $latitude
     * @param float|string|null $longitude
     *
     * @return \Illuminate\Support\Collection<static>
     */
    public function findByDistance(
        float $distance,
        ?string $measurementUnit = null,
        float|string $latitude = null,
        float|string $longitude = null
    ): Collection {
        return $this->addresses()->within($distance, $measurementUnit, $latitude, $longitude)->get();
    }

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string|null $type
     * @param string|null $id
     * @param string|null $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);
}
