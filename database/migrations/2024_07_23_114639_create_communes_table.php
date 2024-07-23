<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->unsignedInteger("id", true);
            $table->string("postal_code", 30);
            $table->string("name", 30);

            $table->unsignedSmallInteger('wilaya_id')->nullable(false);
            $table->foreign('wilaya_id')->references('id')->on('wilayas');
        });

        Artisan::call('app:import-wilayas-and-communes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communes');
    }
};
