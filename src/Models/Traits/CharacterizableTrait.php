<?php
namespace Ry\Caracteres\Models\Traits;

trait CharacterizableTrait
{
	private $spectree = [];
	
	public function specifications() {
		return $this->morphMany('Ry\Caracteres\Models\Specification', 'characterizable');
	}
	
}
