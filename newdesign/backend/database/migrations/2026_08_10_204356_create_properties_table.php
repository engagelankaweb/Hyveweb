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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('city');
            $table->string('type');
            $table->string('purpose');
            $table->decimal('price', 15, 2);
            $table->integer('bedrooms');
            $table->decimal('bathrooms', 3, 1);
            $table->integer('area');
            $table->integer('yearBuilt');
            $table->text('description');
            $table->json('features');
            $table->json('images');
            $table->json('agent');
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
