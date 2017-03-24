<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Specification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('ry_caracteres_specifications', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer("characteristic_id", false, true);
    		$table->char("characterizable_type")->nullable();
    		$table->integer("characterizable_id", false, true)->nullable();
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
        Schema::drop('ry_caracteres_specifications');
    }
}
