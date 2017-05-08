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
	
}
