<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catalog;
use Faker\Generator as Faker;

$factory->define(Catalog::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'parent_id' => null,
    ];
});
