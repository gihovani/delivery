<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::unprepared('SET auto_increment_increment=1;');
        $this->call(ConfigSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(VariationSeeder::class);
        $this->call(ProductVariationSeeder::class);
    }
}
