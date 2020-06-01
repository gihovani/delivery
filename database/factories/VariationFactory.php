<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Variation;
use Faker\Generator as Faker;

$factory->define(Variation::class, function (Faker $faker) {
    return [
        'name' => $faker->countryCode,
        'category_id' => factory(\App\Category::class)
    ];
});
