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
                $sizes = [1,2];
                $prices = [14.90, 24.90, 44.90];
                if ($product->id >= 18) {
                    $prices = [24.90, 44.90];
                }
                for ($i = 0; $i < count($sizes); $i++) {
                    $size = $sizes[$i];
                    $price = $prices[$i];
                    $product->variations()->attach([
//                        'product_id' => $product->id,
                        'variation_id' => $size
                    ], ['price' => $price]);
                }
            } else {
                $product->variations()->attach([
//                    'product_id' => $product->id,
                    'variation_id' => 3
                ], ['price' => rand(6,10)]);
            }
        });
    }
}
