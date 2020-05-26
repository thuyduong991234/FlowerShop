<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Customer::class, function (Faker $faker) {
    return [
        //
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => $faker->password,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
