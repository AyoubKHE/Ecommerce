<?php

use App\Models\ShippingMethod;
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
        Schema::create('shippingMethods', function (Blueprint $table) {
            $table->unsignedSmallInteger("id", true);
            $table->string("name")->nullable(false);
            $table->string("description");
            $table->decimal('price', 8, 2)->nullable(false);
        });

        $shipping_methods = [
            ["Commande en ligne, collecte en magasin", "Récupérez depuis notre magasin", "0.00"],
            ["Yalidine", "Opérateur de courrier Express en régime domestique", "300.00"],
        ];

        foreach ($shipping_methods as $shipping_method) {
            ShippingMethod::create([
                "name" => $shipping_method[0],
                "description" => $shipping_method[1],
                "price" => $shipping_method[2]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippingMethods');
    }
};
