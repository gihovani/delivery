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
        $sizes = ['Pequena', 'Média', 'Grande'];
        for ($i = 0; $i < 3; $i++) {
            factory(App\Variation::class)
                ->create([
                    'name' => $sizes[$i],
                    'category_id' => 1
                ]);
        }
        factory(App\Variation::class)
            ->create([
                'name' => 'Unidade',
                'category_id' => 2
            ]);
    }
}
