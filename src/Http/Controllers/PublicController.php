<?php
namespace Ry\Caracteres\Http\Controllers;

use App\Http\Controllers\Controller;

class PublicController extends Controller {
	public function getCharacteristic($characteristic) {
		return $characteristic;
	}
}