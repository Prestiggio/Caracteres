<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCharacteristicsTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'ry_caracteres_characteristics', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->nullable ()->index ();
			$table->integer ( 'lft' )->nullable ()->index ();
			$table->integer ( 'rgt' )->nullable ()->index ();
			$table->integer ( 'depth' )->nullable ();			
			$table->boolean ( "active" );		
			$table->boolean('multiple');	
			$table->char("input"); //mety ho tag special ra ajax <ville></ville>
			$table->timestamps ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop ( 'ry_caracteres_characteristics' );
	}
}
