<?php

namespace Ry\Caracteres\Models;

use Baum\Node;
use LaravelLocalization;
use Ry\Medias\Models\Traits\MediableTrait;
use Ry\Medias\Models\Media;
use Ry\Caracteres\Models\Traits\RankableTrait;

/**
 * Characteristic
 */
class Characteristic extends Node {
	
	use MediableTrait, RankableTrait;
	
	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $table = 'ry_caracteres_characteristics';
	
	protected $visible = ["id", "term", "multiple", "active", "input", "icon", "position"];
	
	protected $appends = ["icon", "position"];
	
	protected $with = ["term", "rank"];
	
	// ////////////////////////////////////////////////////////////////////////////
	
	// /**
	// * Column to perform the default sorting
	// *
	// * @var string
	// */
	// protected $orderColumn = null;
	
	// /**
	// * With Baum, all NestedSet-related fields are guarded from mass-assignment
	// * by default.
	// *
	// * @var array
	// */
	// protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
	
	//
	// This is to support "scoping" which may allow to have multiple nested
	// set trees in the same database table.
	//
	// You should provide here the column names which should restrict Nested
	// Set queries. f.ex: company_id, etc.
	//
	
	// /**
	// * Columns which restrict what we consider our Nested Set list
	// *
	// * @var array
	// */
	// protected $scoped = array();
	
	// ////////////////////////////////////////////////////////////////////////////
	public function term() {
		return $this->hasOne ( "Ry\Caracteres\Models\Characteristiclang", "characteristic_id" )->where ( function ($query) {
			$query->where ( "lang", "=", "fr");
		} );
	}
	public function terms() {
		return $this->hasMany ( "Ry\Caracteres\Models\Characteristiclang", "characteristic_id" );
	}
	
	public function getIconAttribute() {
		if($this->medias->count()>0)
			return $this->medias;
		
		$parent = $this->parent();
		if($parent->exists())
			return $parent->first()->getIconAttribute();
		
		$media = new Media();
		$media->type = "image";
		$media->path = "ico_autre.png";
		return [$media];
	}
	
	public static function saveTree($ar, $parent = null) {
		foreach ( $ar as $node ) {
			$input = ["type" => "text"];
			if(isset($node["input"])) {
				if(is_string($node["input"]))
					$input = ["type" => $node["input"]];
				else
					$input = $node["input"];
			}
				
			$me = self::createCharacteristic( $node ["name"] , json_encode($input));
			if(isset($node["icon"])) {
				$me->medias()->create([
						"owner_id" => 1,
						"title" => $node["name"],
						"path" => $node["icon"],
						"type" => "image"
				]);
			}
			if ($parent) {
				$me->makeChildOf ( $parent );
				$me->save();
			}
			if (isset ( $node ["children"] ))
				self::saveTree ( $node ["children"], $me );
		}
	}
	
	private static function createCharacteristic($name, $input, $descriptif = "", $lang = null) {
		$user_id = 1;
		if (! $lang)
			$lang = "fr";
	
		$characteristic = Characteristic::create ( [
				"active" => 1,
				"multiple" => 1,
				"input" => $input
		] );
		$characteristic->terms ()->createMany ([[
				"user_id" => $user_id,
				"lang" => $lang,
				"name" => $name,
				"descriptif" => $descriptif
		]]);
		return $characteristic;
	}
	
}
