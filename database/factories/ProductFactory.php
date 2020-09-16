<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $faker->addProvider(new \JansenFelipe\FakerBR\FakerBR($faker));

    return [
        'name' => 'Tshirt',
        'ref' => 'T001',
        'category' => 'Tshirt',
        'active' => 'Yes',
        'quantity' => $faker->randomDigit,
        'price_ht' =>  $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 2),
    ];
});
