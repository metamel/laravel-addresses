<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    public function down(): void
    {
        Schema::dropIfExists(config('addresses.tables.addresses'));
    }

    public function up(): void
    {
        Schema::create(config('addresses.tables.addresses'), static function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('addressable');

            $table->string('label')->nullable()->index();
            $table->string('salutation')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('organization')->nullable()->index();
            $table->string('value_added_tax')->nullable();
            $table->string('country_code', 2)->nullable()->index();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('street')->nullable();
            $table->decimal('latitude', 10, 8)->nullable()->index();
            $table->decimal('longitude', 11, 8)->nullable()->index();
            $table->boolean('is_primary')->default(false)->index();
            $table->boolean('is_billing')->default(false)->index();
            $table->boolean('is_shipping')->default(false)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
