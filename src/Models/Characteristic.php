<?php

namespace Ry\Caracteres\Models;

use Baum\Node;
use LaravelLocalization;

/**
 * Characteristic
 */
class Characteristic extends Node {
	
	/**
	 * Table name.
	 *
	 * @var string
	 */
	protected $table = 'characteristics';
	
	protected $visible = ["id", "term", "multiple", "active", "input"];
	
	protected $with = ["term"];
	
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
			$query->where ( "lang", "=", LaravelLocalization::getCurrentLocale () );
		} );
	}
	public function terms() {
		return $this->hasMany ( "Ry\Caracteres\Models\Characteristiclang", "characteristic_id" );
	}
	
}
