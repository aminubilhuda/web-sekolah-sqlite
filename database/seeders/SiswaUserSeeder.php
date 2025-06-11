<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data siswa
        $siswas = Siswa::all();

        foreach ($siswas as $siswa) {
            // Buat user baru dengan NIS sebagai username
            $user = User::create([
                'name' => $siswa->nama,
                'email' => $siswa->email ?? $siswa->nis . '@siswa.sch.id',
                'username' => $siswa->nis,
                'password' => Hash::make($siswa->nis), // Password default adalah NIS
                'is_active' => true,
                'id_siswa' => $siswa->id_siswa
            ]);

            // Berikan role siswa
            $user->assignRole('siswa');
        }
    }
} 