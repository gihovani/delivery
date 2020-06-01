<?php

use Illuminate\Database\Seeder;

class ProductItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProductItem::class, 30)
            ->create()
            ->each(function ($item) {
                $productIds = array_rand(range(1,10), 5);
                unset($productIds[0]);
                /** @var App\ProductItem $item */
                $item->products()->attach($productIds);
        });

    }
}
