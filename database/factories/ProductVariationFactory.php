<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductVariation;
use Faker\Generator as Faker;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'price' => $faker->randomFloat(2, 30, 60),
        'product_id' => factory(\App\Product::class),
        'variation_id' => factory(\App\Variation::class)
    ];
});
