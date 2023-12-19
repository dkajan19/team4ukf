<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolaPouzivatelaSeeder::class);
        $this->call(StudijnyProgramSeeder::class);
        $this->call(PredmetSeeder::class);
        $this->call(PouzivatelSeeder::class);
    }
}
