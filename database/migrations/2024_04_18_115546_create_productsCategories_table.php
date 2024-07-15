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
        Schema::create('productsCategories', function (Blueprint $table) {
            $table->unsignedSmallInteger("id", true);

            $table->string("name", 255)->nullable(false)->unique();
            $table->text("description")->nullable(false)->unique();
            $table->string("image_path", 255)->nullable(false);
            $table->integer("ordering")->unique()->nullable(true);
            $table->boolean("is_active")->nullable(false)->default(true);
            $table->boolean("show_on_website_header")->nullable(false)->default(false);
            $table->timestamps();

            $table->unsignedBigInteger('added_by')->nullable(false);
            $table->foreign('added_by')->references('id')->on('users');

            $table->unsignedSmallInteger('parent_id')->nullable(true);
            $table->foreign('parent_id')->references('id')->on('productsCategories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsCategories');
    }
};
