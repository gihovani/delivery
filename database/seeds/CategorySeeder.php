<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Pizzas', 'Refrigerantes', 'Cervejas'];
        foreach ($categories as $category) {
            factory(App\Category::class)->create(['name' => $category]);
        }
    }
}
