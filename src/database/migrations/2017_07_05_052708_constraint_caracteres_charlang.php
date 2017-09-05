<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintCaracteresCharlang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_caracteres_characteristiclangs', function (Blueprint $table) {
        	$table->integer("characteristic_id", false, true)->change();
        	$table->integer("user_id", false, true)->change();
        	$table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        	$table->foreign("characteristic_id")->references("id")->on("ry_caracteres_characteristics")->onDelete("cascade");
        	$table->unique(['lang', 'characteristic_id'], "characteristic_trans");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_caracteres_characteristiclangs', function (Blueprint $table) {
        	$table->dropUnique("characteristic_trans");
        	$table->dropForeign("ry_caracteres_characteristiclangs_user_id_foreign");
        	$table->dropIndex("ry_caracteres_characteristiclangs_user_id_foreign");
        	$table->dropForeign("ry_caracteres_characteristiclangs_characteristic_id_foreign");
        	$table->dropIndex("ry_caracteres_characteristiclangs_characteristic_id_foreign");
        });
    }
}
