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
        Schema::create('productsVariations', function (Blueprint $table) {

            $table->unsignedInteger('id', true)->nullable(false);

            $table->decimal('price', 6, 2)->nullable(true);

            $table->unsignedInteger("quantity_in_stock")->nullable(false);

            $table->boolean("is_active")->nullable(false)->default(true);

            $table->string("image_path", 255)->nullable(true);

            $table->unsignedInteger('product_id')->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsVariations');
    }
};
