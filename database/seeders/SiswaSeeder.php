<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::create([
            'nis' => '123456',
            'nisn' => '654321',
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2007-01-01',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 1, Jakarta',
            'no_hp' => '081234567890',
            'email' => 'budi@example.com',
            'foto' => null,
            'id_jurusan' => 1, // Pastikan jurusan dengan id 1 sudah ada
            'status' => 'Aktif',
        ]);
    }
} 