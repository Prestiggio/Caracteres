<?php
namespace Ry\Caracteres\Models;

use LaravelLocalization;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model {
	
	protected $table = "ry_caracteres_specifications";
	
	protected $fillable = ["characteristic_id"];
	
	protected $visible = ["id", "term", "characteristic"];
	
	protected $with = ["term", "characteristic"];
	
	function characterizable() {
		return $this->morphTo();
	}
	
	public function term() {
		return $this->hasOne ( "Ry\Caracteres\Models\Specificationlang", "specification_id" )->where ( function ($query) {
			$query->where ( "lang", "=", LaravelLocalization::getCurrentLocale () );
		} );
	}
	public function terms() {
		return $this->hasMany ( "Ry\Caracteres\Models\Specificationlang", "specification_id" );
	}
	
	public function characteristic() {
		return $this->belongsTo("Ry\Caracteres\Models\Characteristic", "characteristic_id");
	}
	
}