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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->string("unit_number", 50);
            $table->string("street_number", 50);
            $table->string("address_line1", 100);
            $table->string("address_line2", 100);
            $table->string("city", 50);
            $table->string("region", 50);
            $table->string("postal_code", 25);

            $table->unsignedSmallInteger('country_id')->nullable(false);
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
