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
        $categories = ['Pizzas', 'Bebidas'];
        foreach ($categories as $key => $category) {
            factory(App\Category::class)->create(['id' => $key, 'name' => $category]);
        }
    }
}
