<?php

use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Product::all()->each(function ($product) {
            /** @var App\Product $product */
            if ($product->category_id === 1) {
                $sizes = [1,2,3];
                $prices = [34.90, 42.90, 54.90];
                for ($i = 0; $i < 3; $i++) {
                    $product->variations()->attach([
//                        'product_id' => $product->id,
                        'variation_id' => $sizes[$i]
                    ], ['price' => $prices[$i]]);
                }
            } else {
                $product->variations()->attach([
//                    'product_id' => $product->id,
                    'variation_id' => 4
                ], ['price' => rand(10,50)]);
            }
        });
    }
}
