<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    $ufs = Address::ufs();

    return [
        'zipcode' => $faker->numberBetween(10000, 99999) . '-000',
        'street' => $faker->streetName,
        'number' => $faker->numberBetween(0, 9999),
        'city' => $faker->city,
        'state' => array_rand($ufs),
        'neighborhood' => $faker->city,
        'user_id' => factory(App\User::class)
    ];
});
