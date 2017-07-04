<?php
namespace Ry\Caracteres\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Caracteres\Models\Characteristic;
use Ry\Caracteres\Models\Specification;
use Auth;

class AdminController extends Controller
{
	private $characterizable;
	
	public function __construct() {
		$this->middleware("admin");
	}
	
	public function getCharacteristics() {
		$roots = Characteristic::roots ()->get ();
		$ar = [ ];
		foreach ( $roots as $root ) {
			$obj = $root->getDescendantsAndSelf ()->toHierarchy ();
			foreach ( $obj as $k => $v ) {
				$ar [] = $v;
			}
		}
		return $ar;
	}
	
	public function putSpecs($characterizable, $ar, $parent = null, $lang = null) {
		$user = Auth::user ();
		
		$this->characterizable = $characterizable;
	
		if (! $lang)
			$lang = "fr";
	
		foreach ( $ar as $a ) {
			if (isset ( $a ["deleted"] ) && $a ["deleted"] == true) {
				if (isset ( $a ["id"] )) {
					$this->characterizable->specifications ()->where ( "characteristic_id", "=", $a ["id"] )->delete ();
				}
				continue;
			}
				
			if (isset ( $a ["id"] ))
				$characteristic = Characteristic::where ( "id", "=", $a ["id"] )->first ();
			elseif (isset ( $a ["tempid"] ) && $parent) {
				$characteristic = Characteristic::create ( [
						"active" => 1,
						"multiple" => 1,
						"input" => "text"
				] );
				$characteristic->terms ()->createMany ( [
						[
								"user_id" => $user->id,
								"lang" => $lang,
								"name" => $a ["term"] ["name"]
						]
				] );
				$characteristic->makeChildOf ( $parent );
				$characteristic->save ();
			}
				
			if (isset ( $a ["value"] ) && $a ["value"] != "") {
				$specification = $this->characterizable->specifications ()->where("characteristic_id", "=", $characteristic->id)->first();
				if(!$specification) {
					$specification = $this->characterizable->specifications ()->create ( [
							"characteristic_id" => $characteristic->id
					] );
					$specification->terms ()->create ( [
							"user_id" => $user->id,
							"lang" => "fr",
							"value" => $a ["value"]
					] );
				}
				else {
					$term = $specification->terms ()->where("lang", "=", "fr")->first();
					$term->value = $a ["value"];
					$term->save();
				}
			}
				
			$this->putSpecs ($this->characterizable, $a ["children"], $characteristic );
		}
	}
}