<?php

declare(strict_types = 1);

namespace Metamel\Addresses\Models;

use Rinvex\Country\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Jackpopp\GeoDistance\GeoDistanceTrait;
use Rinvex\Country\CountryLoaderException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Metamel\Addresses\Models\Address\Address
 *
 * @property int $id
 * @property string $addressable_type
 * @property int $addressable_id
 * @property string|null $label
 * @property string|null $salutation
 * @property string|null $name
 * @property string|null $value_added_tax
 * @property string|null $country_code
 * @property string|null $state
 * @property string|null $postal_code
 * @property string|null $city
 * @property string|null $street
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $email
 * @property string|null $phone
 * @property bool $is_primary
 * @property bool $is_billing
 * @property bool $is_shipping
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 * @property-read \Rinvex\Country\Country|null $country
 * @property-read string|null $formatted_address
 * @method static \Illuminate\Database\Eloquent\Builder|Address inCountry(string $countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|Address isBilling()
 * @method static \Illuminate\Database\Eloquent\Builder|Address isPrimary()
 * @method static \Illuminate\Database\Eloquent\Builder|Address isShipping()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Query\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address outside($distance, $measurement = null, $lat = null, $lng = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereIsShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereValueAddedTax($value)
 * @method static \Illuminate\Database\Query\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address within($distance, $measurement = null, $lat = null, $lng = null)
 * @method static \Illuminate\Database\Query\Builder|Address withoutTrashed()
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    use GeoDistanceTrait;

    public const ADDRESSABLE = 'addressable';

    public const COL_ADDRESSABLE_ID = 'addressable_id';

    public const COL_ADDRESSABLE_TYPE = 'addressable_type';

    public const COL_CITY = 'city';

    public const COL_COUNTRY_CODE = 'country_code';

    public const COL_DELETED_AT = 'deleted_at';

    public const COL_EMAIL = 'email';

    public const COL_ID = 'id';

    public const COL_IS_BILLING = 'is_billing';

    public const COL_IS_PRIMARY = 'is_primary';

    public const COL_IS_SHIPPING = 'is_shipping';

    public const COL_LABEL = 'label';

    public const COL_LATITUDE = 'latitude';

    public const COL_LONGITUDE = 'longitude';

    public const COL_NAME = 'name';

    public const COL_PHONE = 'phone';

    public const COL_POSTAL_CODE = 'postal_code';

    public const COL_SALUTATION = 'salutation';

    public const COL_STATE = 'state';

    public const COL_STREET = 'street';

    public const COL_VALUE_ADDED_TAX = 'value_addes_tax';

    public const COUNTRY = 'country';

    public const FORMATTED_ADDRESS = 'formatted_address';

    public const MEASUREMENT_FEET = 'feet';

    public const MEASUREMENT_KILOMETERS = 'kilometers';

    public const MEASUREMENT_METERS = 'meters';

    public const MEASUREMENT_MILES = 'miles';

    public const MEASUREMENT_NAUTICAL_MILES = 'nautical_miles';

    protected $appends = [
        self::COUNTRY,
        self::FORMATTED_ADDRESS,
    ];

    protected $casts = [
        self::COL_ADDRESSABLE_ID => 'integer',
        self::COL_ADDRESSABLE_TYPE => 'string',
        self::COL_LATITUDE => 'float',
        self::COL_LONGITUDE => 'float',
        self::COL_IS_PRIMARY => 'boolean',
        self::COL_IS_BILLING => 'boolean',
        self::COL_IS_SHIPPING => 'boolean',
        self::COL_DELETED_AT => 'datetime',
    ];

    protected $fillable = [
        self::COL_ADDRESSABLE_ID,
        self::COL_ADDRESSABLE_TYPE,
        self::COL_LABEL,
        self::COL_SALUTATION,
        self::COL_NAME,
        self::COL_VALUE_ADDED_TAX,
        self::COL_COUNTRY_CODE,
        self::COL_STREET,
        self::COL_STATE,
        self::COL_CITY,
        self::COL_POSTAL_CODE,
        self::COL_LATITUDE,
        self::COL_LONGITUDE,
        self::COL_PHONE,
        self::COL_EMAIL,
        self::COL_IS_PRIMARY,
        self::COL_IS_BILLING,
        self::COL_IS_SHIPPING,
    ];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('addresses.tables.addresses'));
        $this->latColumn = self::COL_LATITUDE;
        $this->lngColumn = self::COL_LONGITUDE;

        parent::__construct($attributes);
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo(self::ADDRESSABLE, self::COL_ADDRESSABLE_TYPE, self::COL_ADDRESSABLE_ID, self::COL_ID);
    }

    public function getCountryAttribute(): ?Country
    {
        if ($this->country_code === null) {
            return null;
        }

        try {
            return country($this->country_code);
        } catch (CountryLoaderException $exception) {
            return null;
        }
    }

    public function getFormattedAddressAttribute(): ?string
    {
        $country = $this->country;
        if ($country === null) {
            return null;
        }

        $addressFormat = $country->getAddressFormat() ?? $this->getDefaultAddressFormat();

        return str_replace(
            [
                '{{recipient}}',
                '{{street}}',
                '{{postalcode}}',
                '{{city}}',
                '{{country}}',
                '{{region}}',
                '{{region_short}}',
            ],
            [
                $this->name,
                $this->street,
                $this->postal_code,
                $this->city,
                $country->getName(),
                $country->getRegion(),
                $country->getRegionCode(),
            ],
            $addressFormat
        );
    }

    public function scopeInCountry(Builder $builder, string $countryCode): Builder
    {
        return $builder->where(self::COL_COUNTRY_CODE, $countryCode);
    }

    public function scopeIsBilling(Builder $builder): Builder
    {
        return $builder->where(self::COL_IS_BILLING, true);
    }

    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where(self::COL_IS_PRIMARY, true);
    }

    public function scopeIsShipping(Builder $builder): Builder
    {
        return $builder->where(self::COL_IS_SHIPPING, true);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(static function (self $address) {
            $geocodingEnabled = config('addresses.geocoding.enabled');
            $geocodingApiKey = config('addresses.geocoding.api_key');

            if ($geocodingEnabled && $geocodingApiKey) {
                $segments[] = $address->street;
                $segments[] = sprintf('%s, %s %s', $address->city, $address->state, $address->postal_code);
                $segments[] = country($address->country_code)->getName();

                $googleGeocodeUrl = sprintf(
                    'https://maps.google.com/maps/api/geocode/json?address=%s&sensor=false&key=%s',
                    str_replace(' ', '+', implode(', ', $segments)),
                    $geocodingApiKey
                );

                $encodedGoogleGeocodeResponse = file_get_contents($googleGeocodeUrl, true);

                $geocode = json_decode(
                    $encodedGoogleGeocodeResponse,
                    false,
                    512,
                    JSON_THROW_ON_ERROR
                );

                if (count($geocode->results)) {
                    $address->latitude = $geocode->results[0]->geometry->location->lat;
                    $address->longitude = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }

    protected function getDefaultAddressFormat(): string
    {
        return "{{recipient}}\n{{street}}\n{{postalcode}} {{city}}\n{{country}}\n{{region}}\n{{region_short}}";
    }
}
