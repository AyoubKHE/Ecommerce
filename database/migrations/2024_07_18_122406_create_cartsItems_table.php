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
        Schema::create('cartsItems', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id')->nullable(false);
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

            $table->unsignedInteger('productVariation_id')->nullable(false);
            $table->foreign('productVariation_id')->references('id')->on('productsVariations');

            $table->integer('quantity')->nullable(false);

            $table->primary(['cart_id', 'productVariation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartsItems');
    }
};
