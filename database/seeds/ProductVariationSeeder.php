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

        App\Variation::all()->each(function ($variation) use ($items) {
            $variationItems = explode(',', str_replace([' e ', ' + Acompanhamento: '], ', ', $variation->description));
            $listItem = [];
            foreach ($variationItems as $item) {
                $hasItem = array_search(trim($item), $items);
                if ($hasItem) {
                    $listItem[] = $hasItem + 1;
                }
            }
            if ($listItem) {
                $variation->items()->sync($listItem);
            }
        });
    }
}
