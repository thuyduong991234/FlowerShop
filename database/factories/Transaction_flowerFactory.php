<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Transaction_flower::class, function (Faker $faker) {
    return [
        //
        'transaction_id' => factory(App\Transaction::class),
        'flower_id' => factory(App\Flower::class),
        'qty' => $faker->numberBetween($min = 1, $max = 1000),
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'data' => $faker->text,
        'status'=>'0'
    ];
});
