<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('operator'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Assign role admin
        $admin->assignRole('admin');
    }
} 