<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Specificationlangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ry_caracteres_specificationlangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("specification_id");
            $table->integer("user_id");
            $table->char("lang");
            $table->char("value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ry_caracteres_specificationlangs');
    }
}
