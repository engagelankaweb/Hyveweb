<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('external_url')->nullable()->after('description');
            $table->boolean('is_published')->default(true)->after('featured');
            $table->string('rental_type')->nullable()->after('purpose'); // 'long_term', 'short_term'
            $table->decimal('nightly_rate', 10, 2)->nullable()->after('price');
            $table->integer('max_guests')->nullable()->after('bathrooms');
            $table->integer('min_stay')->nullable()->after('max_guests'); // minimum nights
            $table->string('check_in_time')->nullable()->after('min_stay');
            $table->string('check_out_time')->nullable()->after('check_in_time');
            $table->string('external_booking_url')->nullable()->after('external_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'external_url',
                'is_published',
                'rental_type',
                'nightly_rate',
                'max_guests',
                'min_stay',
                'check_in_time',
                'check_out_time',
                'external_booking_url'
            ]);
        });
    }
};
