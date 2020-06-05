<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Config;
use Faker\Generator as Faker;

$factory->define(Config::class, function (Faker $faker) {
    return [
        'store' => $faker->name, //'Jose Pan Pizzaria',
        'address' => $faker->address, //'José Matias Zimmermann, R. Paulo Koester, 60 - Sertão do Maruim, São José - SC',
        'zipcode' => rand(10000,99999).'', //88122-200
        'telephone' => $faker->phoneNumber, //48985009075,
        'is_open' => rand(0,1),
        'waiting_time' => rand(1,100)
    ];
});
