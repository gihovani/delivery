<?php

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Address::class, 3)->create(['user_id' => 1]);
        App\User::all()->each(function ($user) {
            factory(App\Address::class)
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
