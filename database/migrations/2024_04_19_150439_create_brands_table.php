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
        Schema::create('brands', function (Blueprint $table) {
            $table->unsignedInteger("id", true);

            $table->string('name')->nullable(false)->unique();
            $table->text('description');
            $table->boolean("is_active")->nullable(false)->default(true);
            $table->timestamps();

            $table->unsignedBigInteger('added_by')->nullable(false);
            $table->foreign('added_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
