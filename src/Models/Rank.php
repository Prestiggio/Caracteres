<?php

namespace Ry\Caracteres\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
	protected $table = "ry_caracteres_ranks";
	
	function rankable() {
		return $this->morphTo();
	}
}
