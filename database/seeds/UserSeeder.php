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
            'telephone' => '48996666667',
            'password' => 'abcd1234',
            'roles' => implode(',', App\User::ROLES)
        ]);
//        factory(App\User::class, 100)->create();
    }
}
