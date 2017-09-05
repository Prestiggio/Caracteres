<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintCaracteresSpeclangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_caracteres_specificationlangs', function (Blueprint $table) {
            $table->integer("specification_id", false, true)->change();
        	$table->integer("user_id", false, true)->change();
        	$table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        	$table->foreign("specification_id")->references("id")->on("ry_caracteres_specifications")->onDelete("cascade");
        	$table->unique(['lang', 'specification_id'], "specification_trans");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_caracteres_specificationlangs', function (Blueprint $table) {
        	$table->dropUnique("specification_trans");
        	$table->dropForeign("ry_caracteres_specificationlangs_user_id_foreign");
        	$table->dropIndex("ry_caracteres_specificationlangs_user_id_foreign");
        	$table->dropForeign("ry_caracteres_specificationlangs_specification_id_foreign");
        	$table->dropIndex("ry_caracteres_specificationlangs_specification_id_foreign");
        });
    }
}
