<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PouzivatelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pouzivatel')->insert([
            'meno' => 'Denis',
            'priezvisko' => 'Kajan',
            'tel_cislo' => '123456789',
            'email' => 'denis.kajan@student.ukf.sk',
            'password' => Hash::make('hesielko'),
            'rola_pouzivatela_id' => 12, //treba zadať správnu rolu pre používateľa podľa idčka
            'firma_id' => null,
            //'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
