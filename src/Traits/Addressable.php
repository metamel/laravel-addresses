<?php

declare(strict_types=1);

namespace Metamel\Addresses\Traits;

use Closure;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Events\QueuedClosure;
use Illuminate\Support\Collection;
use Metamel\Addresses\Models\Address;

trait Addressable
{
    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|\Metamel\Addresses\Models\Address
     */
    public function addresses(): MorphMany|Address
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
     * {@inheritdoc}
     *
     * @param array|\Closure|\Illuminate\Events\QueuedClosure|string $callback
     *
     * @return void
     * @see \Illuminate\Database\Eloquent\Concerns\HasEvents::deleted
     */
    abstract public static function deleted(
        array|Closure|QueuedClosure|string $callback
    ): void;

    /**
     * Find addressable by distance.
     *
     *
     * @return \Illuminate\Support\Collection<static>
     */
    public function findByDistance(
        float $distance,
        ?string $measurementUnit = null,
        ?float $latitude = null,
        ?float $longitude = null
    ): Collection {
        return $this
            ->addresses()
            ->within($distance, $measurementUnit, $latitude, $longitude)
            ->get();
    }

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * {@inheritdoc}
     *
     * @param string $related
     * @param string $name
     * @param string|null $type
     * @param string|null $id
     * @param string|null $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @see \Illuminate\Database\Eloquent\Concerns\HasRelationships::morphMany
     */
    abstract public function morphMany(
        string $related,
        string $name,
        ?string $type = null,
        ?string $id = null,
        ?string $localKey = null
    ): MorphMany;
}
