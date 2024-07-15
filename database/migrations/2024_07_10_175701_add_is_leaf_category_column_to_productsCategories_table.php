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
        Schema::table('productsCategories', function (Blueprint $table) {
            $table->boolean("is_leaf_category")->nullable(false)->default(false);
        });

        //! s'il y a déja des catégories dans la BD il faut executer cette requete pour mettre à jour
        //! la colonne 'is_leaf_category'

        // UPDATE
        //     productscategories
        // SET
        //     is_leaf_category = 0
        // WHERE
        //     id IN(
        //     SELECT
        //         t1.id
        //     FROM
        //         (
        //         SELECT
        //             pc1.id,
        //             (
        //             SELECT
        //                 COUNT(*)
        //             FROM
        //                 productscategories pc2
        //             WHERE
        //                 pc2.parent_id = pc1.id
        //         ) AS sub_category_count
        //     FROM
        //         productscategories pc1
        //     ) t1
        // WHERE
        //     t1.sub_category_count > 0
        // )

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productsCategories', function (Blueprint $table) {
            //
        });
    }
};
