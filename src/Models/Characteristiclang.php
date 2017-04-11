<?php
namespace Ry\Caracteres\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristiclang extends Model
{
	protected $table = "ry_caracteres_characteristiclangs";
	
	private $fallback = "en";
	
	protected $fillable = ["user_id", "path", "name", "descriptif", "lang"];
	
	protected $visible = ["id", "name", "link", "tree", "descriptif", "lang"];
	
	protected $appends = ["tree", "link"];
	
	public function characteristic() {
		return $this->belongsTo("Ry\Caracteres\Models\Characteristic", "characteristic_id");
	}
	
	public function makepath() {
		if($this->path)
			return $this->path;
	
		$ancestors = $this->characteristic->getAncestorsAndSelf();
		$a = [];
		foreach($ancestors as $ancestor) {
			$a[] = str_slug($ancestor->term->name);
		}
		$this->path = implode("/", $a);
		$this->save();
	
		$descendants = $this->characteristic->getDescendants();
		foreach($descendants as $descendant) {
			foreach($descendant->terms as $lang) {
				$lang->makepath();
			}
		}
	}
	
	public function getTreeAttribute() {
		$ancestors = $this->characteristic->getAncestorsAndSelf();
		$a = [];
		foreach($ancestors as $ancestor) {
			$a[] = $ancestor->term->name;
		}
		return implode(" > ", $a);
	}
	
	public function getLinkAttribute()  {
		return action("\Ry\Caracteres\Http\Controllers\PublicController@getCharacteristic", ["characteristic" => $this->path]);
	}
}
