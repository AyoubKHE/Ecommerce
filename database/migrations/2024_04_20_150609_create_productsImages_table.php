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
        Schema::create('productsImages', function (Blueprint $table) {
            $table->unsignedInteger("id", true);

            $table->string("image_path", 255)->nullable(false);
            $table->boolean("is_default")->nullable(false)->default(false);
            $table->timestamps();

            $table->unsignedInteger('product_id')->nullable(false);
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsImages');
    }
};
