<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(\App\Customer::class, function (Faker $faker) {
    return [
        //
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => Hash::make('hello'),
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
    ];
});
