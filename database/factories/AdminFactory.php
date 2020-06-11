<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        //
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => "hello",
    ];
});
