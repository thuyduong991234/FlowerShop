<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Flower;
use Faker\Generator as Faker;

$factory->define(Flower::class, function (Faker $faker) {
    return [
        //
        'catalog_id' => App\Models\Catalog::all()->random()->id,
        'name' => $faker->name,
        'color' => $faker->safeColorName,
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'discount' => $faker->randomFloat($nbMaxDecimals = 1, $min = 0, $max = 1),
        'avatar' => $faker->imageUrl(),
        'images' => $faker->realText(),
        'view' => $faker->randomNumber()
    ];
});
