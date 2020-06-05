<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Config::class)->create([
            'store' => 'Jose Pan Pizzaria',
            'address' => 'José Matias Zimmermann, R. Paulo Koester, 60 - Sertão do Maruim, São José - SC',
            'zipcode' => '88122-200',
            'telephone' => '48985009075',
            'is_open' => 0,
            'waiting_time' => App\Config::DEFAULT_WAITING_TIME,
            'google_maps' => 'https://www.google.com.br/maps/place/Panificadora+e+Confeitaria+JosePan/@-27.5975,-48.6825,15z/data=!4m2!3m1!1s0x0:0xddae197fcf8f8e93?sa=X&ved=2ahUKEwjA2rGC2OrpAhWFHrkGHdACCmcQ_BIwCnoECBEQCA'
        ]);
    }
}
