<?php

namespace Ry\Caracteres\Http\Controllers;

use App\Http\Controllers\Controller;
use Ry\Caracteres\Models\Characteristic;
use Faker, Auth;
use LaravelLocalization;
use Illuminate\Http\Request;
use Ry\RealEstate\Models\Immobilier;

class PublicJsonController extends Controller {
	public function getIndex(Request $request) {
		$user = Auth::user ();
		$user_id = 1;
		if ($user)
			$user_id = $user->id;
		$specifications = [
			"3" => "3 voitures",
			"4" => "Dépendance pour 2 couples",
			"5" => "Protection armée",
			"6"	=> "Gris",
			"7" => "Aucun",
			"9" => "Industriel",
			"10" => "Calme",
			"15" => 1,
			"17" => 3,
			"18" => "puits"
		];
		$immobilier = Immobilier::where("id", "=", 10)->first();
		foreach($specifications as $characteristic_id => $spec) {
			$characteristic = Characteristic::where("id", "=", $characteristic_id)->first();
			$immobilier->specifications()->create([
					"characteristic_id" => $characteristic->id
			])->terms()->create([
					"lang" => LaravelLocalization::getCurrentLocale (),
					"value" => $spec,
					"user_id" => $user_id
			]);
		}
	}
	
	public function getCharacteristics() {
		return Characteristic::allLeaves()->get();
	}
	
	private function createCharacteristic($name, $descriptif = "", $lang = null) {
		$user = Auth::user ();
		$user_id = 1;
		if ($user)
			$user_id = $user->id;
		if (! $lang)
			$lang = LaravelLocalization::getCurrentLocale ();
		
		$characteristic = Characteristic::create ( [ 
				"active" => 1,
				"multiple" => 1,
				"input" => '<input type="text">' 
		] );
		$characteristic->terms ()->createMany ( [ 				[ 
						"user_id" => $user_id,
						"lang" => $lang,
						"name" => $name,
						"descriptif" => $descriptif
				] 
		] );
		return $characteristic;
	}
	public function getSeeder() {
		$caracteristiques = [ 
				[ 
						"name" => "Exterieur",
						"children" => [ 
								[ 
										"name" => "Cour",
										"children" => [ 
												[ 
														"name" => "Contenance garage" 
												],
												[ 
														"name" => "Gardien" 
												],
												[ 
														"name" => "Portail" 
												],
												[ 
														"name" => "Couleur cloture" 
												],
												[ 
														"name" => "Végétation" 
												] 
										] 
								],
								[ 
										"name" => "Voisinage",
										"children" => [ 
												[ 
														"name" => "Quartier" 
												],
												[ 
														"name" => "Bruit" 
												],
												[ 
														"name" => "Distance marché" 
												],
												[ 
														"name" => "Distance station service" 
												] 
										] 
								]
						] 
				],
				[ 
						"name" => "Intérieur",
						"children" => [ 
								[ 
										"name" => "Généralités",
										"children" => [ 
												[ 
														"name" => "Nombre d'étages" 
												],
												[ 
														"name" => "Nombre de salons" 
												],
												[ 
														"name" => "Nombres de chambres" 
												],
												[ 
														"name" => "Eau" 
												],
												[ 
														"name" => "Electricité" 
												] 
										] 
								]
						] 
				]
		];
		$this->saveTree ( $caracteristiques );
	}
	private function saveTree($ar, $parent = null) {
		foreach ( $ar as $node ) {
			$me = $this->createCharacteristic( $node ["name"] );
			if ($parent)
				$me->makeChildOf ( $parent );
			if (isset ( $node ["children"] ))
				$this->saveTree ( $node ["children"], $me );
		}
		if ($parent) {
			foreach ( $parent->terms as $term )
				$term->makepath ();
		}
	}
}