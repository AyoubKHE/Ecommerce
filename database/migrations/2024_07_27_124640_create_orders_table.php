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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedSmallInteger('shippingMethod_id')->nullable(false);
            $table->foreign('shippingMethod_id')->references('id')->on('shippingMethods');

            $table->unsignedBigInteger('address_id')->nullable(false);
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->unsignedSmallInteger('orderStatus_id')->nullable(false);
            $table->foreign('orderStatus_id')->references('id')->on('orderStatuses');

            $table->integer('items_count')->nullable(false);
            $table->decimal('total_price', 8, 2)->nullable(false);

            $table->string("more_details");

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
