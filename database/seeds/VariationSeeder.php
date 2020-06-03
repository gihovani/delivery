<?php

use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variations = explode(PHP_EOL, 'Baiana;Presunto, Queijo Mussarela, Pimentão, Milho, Ovo Cozido, Tomate, Molho de Tomate e Orégano;1;2
Mexicana;Carne Moida, Pimentão, Tomate, Queijo Mussarela, Molho de Tomate e Orégano;1;2
Atum;Atum, Queijo Mussarela, Tomate, Molho de Tomate e Orégano;1;2
Mussarela;Queijo Mussarela, Tomate, Molho de Tomate e Orégano;1;2
Coração;Coração de Frango, Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano;1;2
Strogonoff de Carne;Strogonoff de Carne, Queijo Mussarela, Batata Palha, Molho de Tomate e Orégano;1;2
Strogonoff de Frango;Strogonoff de Frango, Queijo Mussarela, Batata Palha, Molho de Tomate e Orégano;1;2
Brigadeiro;Creme de Leite, Chocolate ao Leite e Chocolate Granulado;3;4
Chocolate Branco;Creme de Leite e Chocolate Branco;3;4
Prestígio;Creme de Leite, Leite Condensado, Chocolate ao Leite e Coco Ralado;3;4
Confete;Creme de Leite, Chocolate ao Leite e Confetes Coloridos;3;4
Sensação;Creme de Leite, Leite Condensado, Chocolate ao Leite e Morango;3;4
Sedução;Creme de Leite, Leite Condensado, Chocolate Branco e Morango;3;4
Charge;Creme de Leite, Doce de Leite, Chocolate ao Leite e Amendoim;3;4
Bombom;Creme de Leite, Bombom, Leite Condensado e Chocolate ao Leite;3;4
Banana com Canela;Creme de Leite, Banana, Canela e Leite Condensado;3;4
2 Amores;Creme de Leite, Chocolate ao Leite, Chocolate Branco e Leite Condensado;3;4
Filé Josepan;Filé Mignon, Queijo Mussarela, Cheddar, Molho de Tomate e Orégano;5;6
Costela;Costela Desfiada, Cebola Caramelizada , Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano + Acompanhamento: Molho Barbicue;5;6
Moda da Casa Josepan;Lingüiça Blumenau, Queijo Mussarela, Molho de Tomate, Tomate e Orégano;5;6
Pepperoni;Pepperoni, Queijo Mussarela, Molho de Tomate, Azeitonas e Orégano;5;6
Camarão;Camarão ao Molho, Queijo Mussarela, Queijo Parmesão, Molho de Tomate e Orégano;5;6');
        foreach ($variations as $variation) {
            $variation = explode(';', $variation);
            $var = factory(App\Variation::class)
                ->create([
                    'name' => $variation[0],
                    'description' => $variation[1]
                ]);
            $var->products()->attach([$variation[2], $variation[3]]);
        }
    }
}
