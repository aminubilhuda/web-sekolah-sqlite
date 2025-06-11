<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'gemini_api_key',
            'value' => '',
            'description' => 'API Key untuk Gemini AI'
        ]);

        Setting::create([
            'key' => 'fontte_api_key',
            'value' => '',
            'description' => 'API Key untuk Fontte'
        ]);
    }
}
