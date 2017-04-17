<?php
use Ry\Caracteres\Models\Characteristic;
$factory->define(\Ry\Caracteres\Models\Specification::class, function (Faker\Generator $faker) {
	
	$characteristic = Characteristic::inRandomOrder()->first();
	
	return [
			
			"characteristic_id" => $characteristic->id,
			
			"characterizable_type" => $faker->name,
			
			"characterizable_id" => 0,
			
	];
});