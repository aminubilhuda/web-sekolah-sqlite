<?php

namespace Database\Seeders;

use App\Models\Ptk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ptks = [
            [
                'nip' => '198501012010011001',
                'nuptk' => '1234567890123456',
                'nik' => '3501234567890001',
                'nama' => 'Dr. H. Ahmad Rizki, M.Pd.',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Tuban',
                'tanggal_lahir' => '1985-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 123',
                'kode_pos' => '62319',
                'telepon' => '081234567890',
                'email' => 'ahmad.rizki@example.com',
                'status_kepegawaian' => 'PNS',
                'jenis_ptk' => 'Guru',
                'tugas_tambahan' => 'Kepala Sekolah',
                'status_tugas_tambahan' => 'Aktif',
                'kode_wilayah' => '123456',
            ],
            [
                'nip' => '198601012010011002',
                'nuptk' => '1234567890123457',
                'nik' => '3501234567890002',
                'nama' => 'Muhammad Rizki, S.Pd.',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Tuban',
                'tanggal_lahir' => '1986-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 124',
                'kode_pos' => '62319',
                'telepon' => '081234567891',
                'email' => 'muhammad.rizki@example.com',
                'status_kepegawaian' => 'PNS',
                'jenis_ptk' => 'Tenaga Administrasi',
                'tugas_tambahan' => 'Tidak Ada',
                'status_tugas_tambahan' => 'Tidak Aktif',
                'kode_wilayah' => '123456',
            ],
        ];

        foreach ($ptks as $ptk) {
            Ptk::create($ptk);
        }
    }
}
