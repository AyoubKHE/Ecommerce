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
        Schema::create('orderItems', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedInteger('productVariation_id')->nullable(false);
            $table->foreign('productVariation_id')->references('id')->on('productsVariations');

            $table->integer('quantity')->nullable(false);
            $table->decimal('price', 8, 2)->nullable(false);

            $table->timestamps();

            $table->primary(['order_id', 'productVariation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderItems');
    }
};
