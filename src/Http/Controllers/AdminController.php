<?php
namespace Ry\Caracteres\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Caracteres\Models\Characteristic;
use Ry\Caracteres\Models\Specification;
use Illuminate\Database\Eloquent\Collection;
use Ry\Caracteres\Models\Characteristiclang;
use Ry\Caracteres\Models\Specificationlang;

class AdminController extends Controller
{
	private $characterizable;
	
	public function __construct() {
		$this->middleware(["web", "admin"]);
	}
	
	public function controller_action($action, Request $request) {
	    $method_name = $request->getMethod() . camel_case($action);
	    return $this->$method_name($request);
	}
	
	public function getCharacteristics(Request $request) {
		$roots = Characteristic::roots ()->get ();
		$ar = [ ];
		foreach ( $roots as $root ) {
			$obj = $root->getDescendantsAndSelf ()->toHierarchy ();
			foreach ( $obj as $k => $v ) {
				$ar [] = $v;
			}
		}
		return new Collection($ar);
	}
	
	public function getRootCharacteristics() {
		return Characteristic::roots ()->get ();
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
			elseif (isset ( $a ["tempid"] )) {
				Characteristic::unguard();
				$characteristic = Characteristic::create ( [
						"active" => 1,
						"multiple" => 1,
						"input" => "text"
				] );
				Characteristiclang::unguard();
				$characteristic->terms ()->createMany ( [
						[
								"user_id" => $user->id,
								"lang" => $lang,
								"name" => $a ["term"] ["name"]
						]
				] );
				if($parent)
					$characteristic->makeChildOf ( $parent );
				$characteristic->save ();
				Characteristic::reguard();
				Characteristiclang::reguard();
			}
				
			if (isset ( $a ["value"] ) && $a ["value"] != "") {
				$specification = $this->characterizable->specifications ()->where("characteristic_id", "=", $characteristic->id)->first();
				if(!$specification) {
					Specification::unguard();
					$specification = $this->characterizable->specifications ()->create ( [
							"characteristic_id" => $characteristic->id
					] );
					Specificationlang::unguard();
					$specification->terms ()->create ( [
							"user_id" => $user->id,
							"lang" => "fr",
							"value" => $a ["value"]
					] );
					Specification::reguard();
					Specificationlang::reguard();
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