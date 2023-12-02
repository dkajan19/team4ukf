<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudijnyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('studijny_program')->insert([
            'nazov' => 'Aplikovaná ekológia a environmentalistika',
            'skratka' => 'AEE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Aplikovaná informatika',
            'skratka' => 'AI',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Biológia',
            'skratka' => 'BI',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Fyzika',
            'skratka' => 'FY',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Geografia v regionálnom rozvoji',
            'skratka' => 'GR',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Matematicko-štatistické a informačné metódy v ekonómii a finančníctve',
            'skratka' => 'MM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo biológie v kombinácii',
            'skratka' => 'BI',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo chémie v kombinácii',
            'skratka' => 'CH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo ekológie v kombinácii',
            'skratka' => 'EK',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo fyziky v kombinácii',
            'skratka' => 'FY',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo geografie v kombinácii',
            'skratka' => 'GE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo informatiky v kombinácii',
            'skratka' => 'IN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo matematiky v kombinácii',
            'skratka' => 'MA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Učiteľstvo odborných ekonomických predmetov v kombinácii',
            'skratka' => 'EN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Environmentalistika v krajinnom plánovaní a praxi',
            'skratka' => 'EN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Fyzika materiálov',
            'skratka' => 'FM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Environmentalistika',
            'skratka' => 'EN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Molekulárna biológia',
            'skratka' => 'BI',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Teória vyučovania chémie',
            'skratka' => 'TVCH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'Teória vyučovania matematiky',
            'skratka' => 'MM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('studijny_program')->insert([
            'nazov' => 'NULL',
            'skratka' => 'NULL',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
