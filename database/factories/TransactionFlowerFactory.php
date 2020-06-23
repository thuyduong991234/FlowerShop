<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TransactionFlower;
use Faker\Generator as Faker;

$factory->define(TransactionFlower::class, function (Faker $faker) {
    return [
        //
        'transaction_id' => App\Models\Transaction::all()->random()->id,
        'flower_id' => App\Models\Flower::all()->random()->id,
        'qty' => $faker->numberBetween($min = 1, $max = 1000),
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'data' => $faker->realText(),
        'status' => '0'
    ];
});
