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
        Schema::create('usersPermissions_systemPermissions', function (Blueprint $table) {
            $table->unsignedBigInteger('userPermission_id')->nullable(false);
            $table->foreign('userPermission_id')->references('id')->on('usersPermissions');

            $table->unsignedSmallInteger('systemPermission_id')->nullable(false);
            $table->foreign('systemPermission_id')->references('id')->on('systemPermissions');

            $table->integer('value')->nullable(false);

            $table->primary(['userPermission_id', 'systemPermission_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersPermissions_systemPermissions');
    }
};
