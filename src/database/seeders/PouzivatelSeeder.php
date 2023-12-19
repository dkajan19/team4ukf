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
            'tel_cislo' => '9876543210',
            'email' => 'denis.kajan@admin.ukf.sk',
            'password' => Hash::make('a'),
            'rola_pouzivatela_id' => 1, //treba zadať správnu rolu pre používateľa podľa idčka
            'firma_id' => null,
            //'remember_token' => str_random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pouzivatel')->insert([
            'meno' => 'Denis',
            'priezvisko' => 'Kajan',
            'tel_cislo' => '9876543210',
            'email' => 'denis.kajan@student.ukf.sk',
            'password' => Hash::make('a'),
            'rola_pouzivatela_id' => 2,
            'firma_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pouzivatel')->insert([
            'meno' => 'Ján',
            'priezvisko' => 'Nový',
            'tel_cislo' => '1234567890',
            'email' => 'jan.novy@ukf.sk',
            'password' => Hash::make('a'),
            'rola_pouzivatela_id' => 3,
            'firma_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pouzivatel')->insert([
            'meno' => 'Jozef',
            'priezvisko' => 'Starý',
            'tel_cislo' => '8765432109',
            'email' => 'jozef.stary@ukf.sk',
            'password' => Hash::make('a'),
            'rola_pouzivatela_id' => 4,
            'firma_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
