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
        Schema::create('productsAttributesOptions', function (Blueprint $table) {
            $table->unsignedSmallInteger('id', true);

            $table->string('value')->nullable(false);
            $table->unsignedSmallInteger('productAttribute_id')->nullable(false);
            $table->foreign('productAttribute_id')->references('id')->on('productsAttributes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsAttributesOptions');
    }
};
