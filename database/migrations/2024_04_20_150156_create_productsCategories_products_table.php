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
        Schema::create('productsCategories_products', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedSmallInteger('productCategory_id')->nullable(false);
            $table->foreign('productCategory_id')->references('id')->on('productsCategories');

            $table->boolean("is_active")->nullable(false)->default(true);

            $table->primary(['product_id', 'productCategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsCategories_products');
    }
};
