<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Catalog::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'parent_id' => null,
    ];
});
