<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            [
                'kode_jurusan' => 'AK',
                'nama_jurusan' => 'Akuntansi',
                'slug' => 'akuntansi',
                'deskripsi_singkat' => 'Program keahlian yang mempelajari tentang pencatatan, pengelompokan, pengikhtisaran, dan pelaporan transaksi keuangan.',
                'deskripsi' => '<p>Program keahlian Akuntansi dirancang untuk membekali siswa dengan pengetahuan dan keterampilan dalam bidang akuntansi dan keuangan. Siswa akan mempelajari:</p>
                    <ul>
                        <li>Dasar-dasar akuntansi</li>
                        <li>Akuntansi keuangan</li>
                        <li>Akuntansi manajemen</li>
                        <li>Perpajakan</li>
                        <li>Sistem informasi akuntansi</li>
                    </ul>',
                'kepala_jurusan' => 'Dr. Budi Santoso, M.Ak.',
                'jumlah_guru' => 8,
                'jumlah_siswa' => 120,
                'status' => 'Aktif',
            ],
            [
                'kode_jurusan' => 'BD',
                'nama_jurusan' => 'Bisnis Digital',
                'slug' => 'bisnis-digital',
                'deskripsi_singkat' => 'Program keahlian yang mempelajari tentang pemanfaatan teknologi digital dalam menjalankan dan mengembangkan bisnis.',
                'deskripsi' => '<p>Program keahlian Bisnis Digital menggabungkan pengetahuan bisnis dengan teknologi digital. Siswa akan mempelajari:</p>
                    <ul>
                        <li>E-commerce dan marketplace</li>
                        <li>Digital marketing</li>
                        <li>Social media management</li>
                        <li>Content creation</li>
                        <li>Business analytics</li>
                    </ul>',
                'kepala_jurusan' => 'Dr. Siti Rahayu, M.M.',
                'jumlah_guru' => 6,
                'jumlah_siswa' => 90,
                'status' => 'Aktif',
            ],
            [
                'kode_jurusan' => 'PH',
                'nama_jurusan' => 'Perhotelan',
                'slug' => 'perhotelan',
                'deskripsi_singkat' => 'Program keahlian yang mempelajari tentang pengelolaan dan pelayanan di bidang perhotelan.',
                'deskripsi' => '<p>Program keahlian Perhotelan membekali siswa dengan keterampilan dalam industri perhotelan. Siswa akan mempelajari:</p>
                    <ul>
                        <li>Front office operations</li>
                        <li>Housekeeping management</li>
                        <li>Food and beverage service</li>
                        <li>Hotel marketing</li>
                        <li>Customer service excellence</li>
                    </ul>',
                'kepala_jurusan' => 'Drs. Ahmad Hidayat, M.Par.',
                'jumlah_guru' => 7,
                'jumlah_siswa' => 100,
                'status' => 'Aktif',
            ],
            [
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'slug' => 'rekayasa-perangkat-lunak',
                'deskripsi_singkat' => 'Program keahlian yang mempelajari tentang pengembangan perangkat lunak dan aplikasi komputer.',
                'deskripsi' => '<p>Program keahlian RPL fokus pada pengembangan perangkat lunak dan aplikasi. Siswa akan mempelajari:</p>
                    <ul>
                        <li>Pemrograman dasar</li>
                        <li>Pengembangan web</li>
                        <li>Mobile app development</li>
                        <li>Database management</li>
                        <li>Software testing</li>
                    </ul>',
                'kepala_jurusan' => 'Ir. Dian Kusuma, M.Kom.',
                'jumlah_guru' => 9,
                'jumlah_siswa' => 150,
                'status' => 'Aktif',
            ],
            [
                'kode_jurusan' => 'LPFK',
                'nama_jurusan' => 'Lembaga Pelayanan Farmasi Klinis dan Komunitas',
                'slug' => 'lembaga-pelayanan-farmasi-klinis-dan-komunitas',
                'deskripsi_singkat' => 'Program keahlian yang mempelajari tentang pelayanan farmasi di klinik dan komunitas.',
                'deskripsi' => '<p>Program keahlian LPFK membekali siswa dengan pengetahuan farmasi dan pelayanan kesehatan. Siswa akan mempelajari:</p>
                    <ul>
                        <li>Farmakologi dasar</li>
                        <li>Pelayanan farmasi klinis</li>
                        <li>Manajemen obat</li>
                        <li>Konseling pasien</li>
                        <li>Etika farmasi</li>
                    </ul>',
                'kepala_jurusan' => 'Apt. Maya Sari, M.Farm.',
                'jumlah_guru' => 7,
                'jumlah_siswa' => 80,
                'status' => 'Aktif',
            ],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::create($jurusan);
        }
    }
} 