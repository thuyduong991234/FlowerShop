<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Admin::class, function (Faker $faker) {
    return [
        //
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'username' => $faker->userName,
        'password' => $faker->password,
    ];
});
