<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            'Pizza Grande Tradicional', 'Pizza Broto Tradicional',
            'Pizza Grande Doce', 'Pizza Broto Doce',
            'Pizza Grande Nobre', 'Pizza Broto Nobre',
        ];
        $prices = [
            24.90, 14.90,
            24.90, 14.90,
            44.90, 24.90
        ];
        $pieces = [
            8, 4,
            8, 4,
            8, 4
        ];
        foreach ($products as $key => $product) {
            factory(App\Product::class)
                ->create([
                    'category_id' => 1,
                    'name' => $products[$key],
                    'price' => $prices[$key],
                    'pieces' => ($pieces[$key] === 8) ? 2 : 1,
                    'description' => "{$pieces[$key]} fatias"
                ]);
        }

        foreach (['Pureza 2L', 'Coca-cola 2L', 'Fanta 2L', 'Sprite 2L'] as $productName) {
            $product = factory(App\Product::class)
                ->create([
                    'category_id' => 2,
                    'name' => $productName,
                    'pieces' => 1,
                    'description' => ''
                ]);
            $product->variations()
                ->create(['name' => $product->name, 'description' => '']);

        }
    }
}
