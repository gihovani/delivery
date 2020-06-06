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

        $refrigerantes = ['Coca-cola', 'Coca-cola Zero', 'Fanta Laranja', 'Fanta Uva', 'Sprite', 'Guaraná Antartica', 'Guaraná Antartica Zero', 'Pureza'];
        /** 2L */
        $product = factory(App\Product::class)
                ->create([
                    'category_id' => 2,
                    'name' => 'Refrigerante 2L',
                    'pieces' => 1,
                    'price' => 10,
                    'description' => ''
                ]);
        foreach ($refrigerantes as $variation) {
            $product->variations()
                ->create(['name' => $variation. ' 2L', 'description' => '']);
        }

        /** 1L */
        factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Refrigerante 1L',
                'pieces' => 1,
                'price' => 6,
                'description' => ''
            ])->variations()
            ->create(['name' => 'Pureza 1L', 'description' => '']);

        /** 600 */
        $product = factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Refrigerante 600ml',
                'pieces' => 1,
                'price' => 6,
                'description' => ''
            ]);
        foreach ($refrigerantes as $variation) {
            $product->variations()
                ->create(['name' => $variation. ' 600', 'description' => '']);
        }

        /** 350 */
        $product = factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Refrigerante 350ml (lata)',
                'pieces' => 1,
                'price' => 3.5,
                'description' => ''
            ]);
        foreach ($refrigerantes as $variation) {
            $product->variations()
                ->create(['name' => $variation. ' 350', 'description' => '']);
        }


        /** cervejas 350 */
        $cervejas = ['Skol', 'Budyweiser', 'Amstel', 'Brahma', 'Antartica Subzero'];
        $product = factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Cervejas 350ml (lata)',
                'pieces' => 1,
                'price' => 5,
                'description' => ''
            ]);
        foreach ($cervejas as $variation) {
            $product->variations()
                ->create(['name' => $variation. ' 350', 'description' => '']);
        }

        /** cervejas long neck */
        $cervejas = ['Sol', 'Budyweiser', 'Heineken', 'Eisenbahn', 'Stella Artois'];
        $product = factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Cervejas Long Neck',
                'pieces' => 1,
                'price' => 7,
                'description' => ''
            ]);
        foreach ($cervejas as $variation) {
            $product->variations()
                ->create(['name' => $variation. ' Long Neck', 'description' => '']);
        }

        /** promocionais/combos */
        factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Refrigerante Combo 01',
                'pieces' => 1,
                'price' => 4.1,
                'description' => 'Refrigerante para promoção do combo pizza grande + broto doce'
            ])->variations()
            ->create(['name' => 'Pureza 2L', 'description' => '']);

        factory(App\Product::class)
            ->create([
                'category_id' => 2,
                'name' => 'Refrigerante Combo 02',
                'pieces' => 1,
                'price' => 5,
                'description' => 'Refrigerante para promoção do combo pizza grande'
            ])->variations()
            ->create(['name' => 'Pureza 2L', 'description' => '']);
    }
}
