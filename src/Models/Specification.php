<?php
namespace Ry\Caracteres\Models;

use LaravelLocalization;

use Illuminate\Database\Eloquent\Model;
use Ry\Caracteres\Models\Specification;
use Illuminate\Support\Facades\Log;

class Specification extends Model {
	
	protected $table = "ry_caracteres_specifications";
	
	protected $fillable = ["characteristic_id"];
	
	protected $visible = ["id", "term", "characteristic"];
	
	protected $with = ["term", "characteristic"];
	
	private static $sels = [];
	
	function characterizable() {
		return $this->morphTo();
	}
	
	public function term() {
		return $this->hasOne ( "Ry\Caracteres\Models\Specificationlang", "specification_id" )->where ( function ($query) {
			$query->where ( "lang", "=", "fr");
		} );
	}
	public function terms() {
		return $this->hasMany ( "Ry\Caracteres\Models\Specificationlang", "specification_id" );
	}
	
	public function characteristic() {
		return $this->belongsTo("Ry\Caracteres\Models\Characteristic", "characteristic_id");
	}
	
	private static function searched($ar) {
		foreach ($ar as $a) {
			if(isset($a["value"]) && $a["value"]!="") {
				self::$sels[$a["id"]] = $a["value"];
			}
			self::searched($a["children"]);
		}
	}
	
	public static function forTree($ar, $cast, $notIn=[], $in=[]) {
		self::$sels = [];
		self::searched($ar);
		$characterictic_ids = [];
		foreach(self::$sels as $characteristic_id => $value) {
			if(!isset($characterictic_ids[$value]))
				$characterictic_ids[$value] = [];
			$characterictic_ids[$value][] = $characteristic_id;
		}
		$results = [];
		foreach($characterictic_ids as $q => $ids) {
			$q = preg_replace(["/n[\s\n\t]*'[\s\n\t]*ny?/i", "/[\s\t'-\.,:\/]/i"], " ", trim($q));
			$ar = preg_split("/[\t\s]+/i", $q);
			$ar = array_filter($ar, function($item){
				return strlen($item)>2;
			});
			
			$query = Specification::whereIn("characteristic_id", $ids)->where("characterizable_type", "=", $cast);
			if(count($notIn)>0)
				$query->whereNotIn("characterizable_id", $notIn);
			if(count($in)>0)
				$query->whereIn("characterizable_id", $in);
			$specs = $query->get();
			foreach ($specs as $spec) {
				if($spec->terms()->where("lang", "=", "fr")->where(function($query) use ($ar){
					foreach ($ar as $a) {
						$query->orWhereRaw("soundex_match_all(?, value, ' ') > 0", [$a]);
					}
				})->count()>0)
				$results[] = $spec->characterizable;
			}
		}
		return $results;
	}
	
	public static function byValue($q, $cast, $notIn=[], $in=[]) {
		$results = app("rymd.search")->search("specification", $q);
		$characterictic_ids = [];
		foreach($results as $specificationlangs) {
			foreach($specificationlangs as $specification) {
				$characterictic_ids[$specification->specification_id] = $specification;			
			}
		}
		$query = Specification::whereIn("id", array_keys($characterictic_ids))->where("characterizable_type", "=", $cast);
		if(count($notIn)>0)
			$query->whereNotIn("id", $notIn);
		if(count($in)>0)
			$query->whereIn("id", $in);
		$specs = $query->get();
		$ar = [];
		foreach ($specs as $spec) {
			$ar[] = $spec->characterizable;
		}
		return $ar;
	}
	
}