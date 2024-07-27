<?php

use App\Models\OrderStatus;
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
        Schema::create('orderStatuses', function (Blueprint $table) {
            $table->unsignedSmallInteger("id", true);
            $table->string("status")->nullable(false);
            $table->string("description");
        });

        $statuses = [
            "Paiement en attente" => "Paiement en attente",
            "Paiement confirmé" => "Paiement confirmé",
            "En route" => "En route",
            "Livré" => "Livré",
            "Annulé" => "Annulé",
            "Revenu" => "Revenu"
        ];

        foreach ($statuses as $status_name => $status_description) {
            OrderStatus::create([
                "status" => $status_name,
                "description" => $status_description
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderStatuses');
    }
};
