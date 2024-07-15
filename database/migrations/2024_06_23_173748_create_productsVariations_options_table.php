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
        Schema::create('productsVariations_attributesOptions', function (Blueprint $table) {

            $table->unsignedInteger('productVariation_id')->nullable(false);
            $table->foreign('productVariation_id')->references('id')->on('productsVariations');

            $table->unsignedSmallInteger('productAttribute_id')->nullable(false);
            $table->foreign('productAttribute_id', "productAttribute_id_foreign")->references('id')->on('productsAttributes');

            $table->unsignedSmallInteger('productAttributeOption_id')->nullable(false);
            $table->foreign('productAttributeOption_id', "productAttributeOption_id_foreign")->references('id')->on('productsAttributesOptions');

            $table->primary(['productVariation_id', 'productAttribute_id', 'productAttributeOption_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsVariations_attributesOptions');
    }
};
