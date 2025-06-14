<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // PtkSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            JurusanSeeder::class,
            // SiswaUserSeeder::class,
            // BeritaSeeder::class,
            SettingSeeder::class,
            // PpdbInfoSeeder::class,
        ]);
    }
}