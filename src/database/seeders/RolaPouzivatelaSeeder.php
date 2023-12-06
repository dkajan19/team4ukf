<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolaPouzivatelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rola_pouzivatela')->insert([
            'rola' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('rola_pouzivatela')->insert([
            'rola' => 'Študent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rola_pouzivatela')->insert([
            'rola' => 'Poverený pracovník pracoviska',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rola_pouzivatela')->insert([
            'rola' => 'Vedúci pracoviska',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rola_pouzivatela')->insert([
            'rola' => 'Zástupca firmy alebo organizácie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
