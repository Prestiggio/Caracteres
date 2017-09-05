<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintCaracteresRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_caracteres_ranks', function (Blueprint $table) {
            $table->unique(['rankable_type', 'rankable_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_caracteres_ranks', function (Blueprint $table) {
            $table->dropUnique("ry_caracteres_ranks_rankable_type_rankable_id_id_unique");
        });
    }
}
