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
        Schema::create('preferences_of_showcase', function (Blueprint $table) {
            $table->unsignedSmallInteger('id', true);

            $table->json("header")->nullable(true);
            $table->json("body")->nullable(true);
            $table->json("footer")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences_of_showcase');
    }
};
