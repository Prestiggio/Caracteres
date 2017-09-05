<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintCaracteresKsq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_caracteres_characteristics', function (Blueprint $table) {
        	$table->integer("parent_id", false, true)->change();
        	$table->integer("lft", false, true)->change();
        	$table->integer("rgt", false, true)->change();
        	$table->foreign("parent_id", "ry_caracteres_characteristics_parent_id_index")->references("id")->on("ry_caracteres_characteristics")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_caracteres_characteristics', function (Blueprint $table) {
        	$table->dropForeign("ry_caracteres_characteristics_parent_id_index");
        });
    }
}
