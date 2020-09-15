<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ref' => $faker->randomElements($array = array ('T','S','G'), $count = 1) . $faker->randomDigit,
        'category' => now(),
        'active' => $faker->randomElements($array = array ('Yes','No'), $count = 1),
        'quantity' => $faker->randomDigit,
        'price_ht' =>  $faker->randomFloat,
    ];
});
