<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductItem;
use Faker\Generator as Faker;

$factory->define(ProductItem::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 1, 10)
    ];
});
