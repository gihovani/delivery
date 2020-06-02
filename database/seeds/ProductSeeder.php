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
        $items = [
            'Amendoim', 'Atum', 'Azeitonas', 'Banana', 'Batata Palha',
            'Bombom', 'Camarão ao Molho', 'Canela', 'Carne Moida',
            'Cebola Caramelizada ', 'Cheddar', 'Chocolate ao Leite',
            'Chocolate Branco', 'Chocolate Granulado', 'Coco Ralado',
            'Confetes Coloridos', 'Coração de Frango', 'Costela Desfiada',
            'Creme de Leite', 'Doce de Leite', 'Filé Mignon',
            'Leite Condensado', 'Lingüiça Blumenau', 'Milho',
            'Molho Barbicue', 'Molho de Tomate', 'Morango', 'Orégano',
            'Ovo Cozido', 'Pepperoni', 'Pimentão', 'Presunto', 'Queijo Mussarela',
            'Queijo Parmesão', 'Strogonoff de Carne', 'Strogonoff de Frango',
            'Tomate'
        ];
        $products = explode(PHP_EOL, 'Baiana;Presunto, Queijo Mussarela, Pimentão, Milho, Ovo Cozido, Tomate, Molho de Tomate e Orégano;14.9;24.9
Mexicana;Carne Moida, Pimentão, Tomate, Queijo Mussarela, Molho de Tomate e Orégano;14.9;24.9
Atum;Atum, Queijo Mussarela, Tomate, Molho de Tomate e Orégano;14.9;24.9
Mussarela;Queijo Mussarela, Tomate, Molho de Tomate e Orégano;14.9;24.9
Coração;Coração de Frango, Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano;14.9;24.9
Strogonoff de Carne;Strogonoff de Carne, Queijo Mussarela, Batata Palha, Molho de Tomate e Orégano;14.9;24.9
Strogonoff de Frango;Strogonoff de Frango, Queijo Mussarela, Batata Palha, Molho de Tomate e Orégano;14.9;24.9
Brigadeiro;Creme de Leite, Chocolate ao Leite e Chocolate Granulado;14.9;24.9
Chocolate Branco;Creme de Leite e Chocolate Branco;14.9;24.9
Prestígio;Creme de Leite, Leite Condensado, Chocolate ao Leite e Coco Ralado;14.9;24.9
Confete;Creme de Leite, Chocolate ao Leite e Confetes Coloridos;14.9;24.9
Sensação;Creme de Leite, Leite Condensado, Chocolate ao Leite e Morango;14.9;24.9
Sedução;Creme de Leite, Leite Condensado, Chocolate Branco e Morango;14.9;24.9
Charge;Creme de Leite, Doce de Leite, Chocolate ao Leite e Amendoim;14.9;24.9
Bombom;Creme de Leite, Bombom, Leite Condensado e Chocolate ao Leite;14.9;24.9
Banana com Canela;Creme de Leite, Banana, Canela e Leite Condensado;14.9;24.9
2 Amores;Creme de Leite, Chocolate ao Leite, Chocolate Branco e Leite Condensado;14.9;24.9
Filé Josepan;Filé Mignon, Queijo Mussarela, Cheddar, Molho de Tomate e Orégano;24.9;44.9
Costela;Costela Desfiada, Cebola Caramelizada , Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano + Acompanhamento: Molho Barbicue;24.9;44.9
Moda da Casa Josepan;Lingüiça Blumenau, Queijo Mussarela, Molho de Tomate, Tomate e Orégano;24.9;44.9
Pepperoni;Pepperoni, Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano;24.9;44.9
Camarão;Camarão ao Molho, Queijo Mussarela, Queijo Parmesão, Molho de Tomate e Orégano;24.9;44.9');
        foreach ($products as $product) {
            $product = explode(';', $product);
            factory(App\Product::class)
                ->create([
                    'category_id' => 1,
                    'name' => $product[0],
                    'description' => $product[1]
                ])->each(function ($product) use ($items) {
                    /** @var App\Product $product */
                    $listItem = [];
                    $productItems = explode(',', str_replace([' e ', ' + Acompanhamento: '], ', ', $product->description));
                    foreach ($productItems as $item) {
                        $hasItem = array_search(trim($item), $items);
                        if ($hasItem) {
                            $listItem[] = $hasItem + 1;
                        }
                    }
                    if ($listItem) {
                        $product->items()->sync($listItem);
                    }
                });
        }

        foreach (['Pureza 2L', 'Coca-cola 2L', 'Fanta 2L', 'Sprite 2L'] as $productName) {
            factory(App\Product::class)
                ->create(['category_id' => 2, 'name' => $productName, 'description' => '']);
        }
    }
}
