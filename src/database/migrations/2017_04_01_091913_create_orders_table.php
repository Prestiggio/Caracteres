<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ry_caracteres_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("value", false, true)->default(0);
            $table->char("rankable_type");
            $table->integer("rankable_id", false, true);
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
        Schema::drop('ry_caracteres_ranks');
    }
}
