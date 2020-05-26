<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Transaction::class, function (Faker $faker) {
    return [
        //
        'status'=>'0',
        'customer_id' => \App\Customer::all()->random()->id,
        'customer_last_name' => function (array $trans) {
            return App\Customer::find($trans['customer_id'])->last_name;
        },
        'customer_first_name' => function (array $trans) {
            return App\Customer::find($trans['customer_id'])->first_name;
        },
        'customer_email' => function (array $trans) {
            return App\Customer::find($trans['customer_id'])->email;
        },
        'customer_phone' => function (array $trans) {
            return App\Customer::find($trans['customer_id'])->phone;
        },
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'payment_method' => $faker->text($maxNbChars = 20),
        'payment_info' => $faker->text,
        'message' => $faker->text($maxNbChars = 20),
        'security' => $faker->text($maxNbChars = 20)
    ];
});
