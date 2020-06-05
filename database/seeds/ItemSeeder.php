<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'Alho','Amendoim','Atum','Azeite de Oliva','Azeitonas','Bacon','Banana',
            'Batata Palha','Bombom','Brócolis','Calabresa','Calabresa Ralada',
            'Camarão ao Molho','Canela','Carne de Panela','Carne Moida','Cebola',
            'Cebola Caramelizada','Champignon','Cheddar','Chocolate ao Leite',
            'Chocolate Branco','Chocolate Granulado','Coco Ralado','Confetes Coloridos',
            'Coração de Frango','Costela Desfiada','Creme de Leite','Doce de Leite',
            'Ervilha','Filé Mignon','Frango Desfiado','Leite Condensado','Lingüiça Blumenau',
            'Lombinho','Manjericão desidratado','Milho','Molho Barbicue','Molho de Tomate',
            'Morango','Orégano','Ovo Cozido','Palmito','Parmesão','Peito de Peru','Pepperoni',
            'Pimentão','Presunto','Provolone','Queijo Mussarela','Queijo Parmesão','Requeijão',
            'Strogonoff de Carne','Strogonoff de Frango','Tomate','Tomate Cereja'
        ];
        foreach ($items as $item) {
            factory(App\Item::class)->create(['name' => $item]);
        }
    }
}
