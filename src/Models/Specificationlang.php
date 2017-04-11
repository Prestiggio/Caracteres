<?php
namespace Ry\Caracteres\Models;

use Illuminate\Database\Eloquent\Model;

class Specificationlang extends Model {
	
	protected $table = "ry_caracteres_specificationlangs";
	
	private $fallback = "en";
	
	protected $fillable = ["user_id", "value", "lang"];
	
	protected $visible = ["id", "value", "lang"];
	
	public function specification() {
		return $this->belongsToMany("Ry\Caracteres\Models\Specification", "specification_id");
	}
}