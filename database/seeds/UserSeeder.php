<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'email' => 'teste@teste.com',
            'password' => 'abcd1234',
            'is_admin' => 1
        ]);
        factory(App\User::class, 100)->create();
    }
}
