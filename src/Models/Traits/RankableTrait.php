<?php
namespace Ry\Caracteres\Models\Traits;

trait RankableTrait
{
	public function rank() {
		return $this->morphOne("Ry\Caracteres\Models\Rank", "rankable");
	}
	
	public function getPositionAttribute() {
		if($this->rank)
			return $this->rank->value;
		return 0;
	}
}