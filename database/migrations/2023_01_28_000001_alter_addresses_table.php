<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddressesTable extends Migration
{
    public function down(): void
    {
        Schema::table(config('addresses.tables.addresses'), static function (Blueprint $table) {
            $table->string('organization')->nullable()->index()->after('name');
            $table->dropIndex('state');
            $table->dropIndex('postal_code');
            $table->dropIndex('value_added_tax');
            $table->dropColumn(['phone', 'email', 'phone_country_code']);
        });
    }

    public function up(): void
    {
        Schema::table(config('addresses.tables.addresses'), static function (Blueprint $table) {
            $table->dropColumn(['organization']);

            $table->index('state', 'state');
            $table->index('postal_code', 'postal_code');
            $table->index('value_added_tax', 'value_added_tax');

            $table->string('phone_country_code')->nullable()->index('phone_country_code');

            $table->string('phone')->nullable()->index('phone')->after('longitude');
            $table->string('email')->nullable()->index('email')->after('longitude');
        });
    }
}
