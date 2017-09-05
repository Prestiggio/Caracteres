<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintCaracteresSpecs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_caracteres_specifications', function (Blueprint $table) {
        	$table->foreign("characteristic_id")->references("id")->on("ry_caracteres_characteristics")->onDelete("cascade");
        	$table->unique(['characteristic_id', 'characterizable_type', 'characterizable_id'], "product_specs");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_caracteres_specifications', function (Blueprint $table) {
        	$table->dropForeign("ry_caracteres_specifications_characteristic_id_foreign");
            $table->dropUnique("product_specs");
        });
    }
}
