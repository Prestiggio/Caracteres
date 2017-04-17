<?php
$factory->define(\Ry\Caracteres\Models\Specificationlang::class, function (Faker\Generator $faker) {
	return [
			
			"specification_id" => 0,
			
			"user_id" => 1,
			
			"lang" => $faker->languageCode,
			
			"value" => $faker->word,
			
	];
});