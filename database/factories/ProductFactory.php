<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $prices = [8.90, 10.90, 12.90];
    return [
        'name' => $faker->country,
        'category_id' => factory(\App\Category::class),
        'description' => $faker->text,
        'pieces' => rand(1,3),
        'price' => $prices[rand(0,2)]
    ];
});
