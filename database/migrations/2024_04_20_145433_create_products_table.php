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
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger("id", true);
            $table->string("name", 255)->nullable(false)->unique();
            $table->text("description")->nullable(false)->unique();
            $table->boolean("is_active")->nullable(false)->default(true);
            $table->tinyInteger("rating")->nullable(true);
            $table->decimal('price', 6, 2)->nullable(false);
            $table->timestamps();

            $table->unsignedBigInteger('added_by')->nullable(false);
            $table->foreign('added_by')->references('id')->on('users');

            $table->unsignedInteger('brand_id')->nullable(false);
            $table->foreign('brand_id')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
