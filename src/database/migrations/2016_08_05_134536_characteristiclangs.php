<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Characteristiclangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ry_caracteres_characteristiclangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("characteristic_id");
            $table->integer("user_id");
            $table->char("lang");
            $table->char("name");
            $table->text("descriptif");
            $table->text("path")->nullable();
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
        Schema::drop('ry_caracteres_characteristiclangs');
    }
}
