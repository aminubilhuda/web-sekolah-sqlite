<?php

namespace Database\Seeders;

use App\Models\PpdbInfo;
use Illuminate\Database\Seeder;

class PpdbInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Syarat Pendaftaran
        PpdbInfo::create([
            'judul' => 'Syarat Pendaftaran Umum',
            'konten' => json_encode([
                'Mengisi formulir pendaftaran online',
                'Fotokopi akta kelahiran (2 lembar)',
                'Fotokopi kartu keluarga (2 lembar)',
                'Pas foto 3x4 (4 lembar)',
                'Fotokopi rapor semester 1-5 (2 lembar)',
                'Surat keterangan lulus (asli)',
                'SKHUN (asli)',
                'Ijazah (asli)'
            ]),
            'kategori' => 'syarat',
            'urutan' => 1
        ]);

        PpdbInfo::create([
            'judul' => 'Syarat Pendaftaran Khusus',
            'konten' => json_encode([
                'Surat keterangan tidak mampu (bagi yang mengajukan beasiswa)',
                'Surat keterangan prestasi (bagi yang memiliki prestasi)',
                'Surat keterangan domisili (bagi yang berdomisili di luar kota)'
            ]),
            'kategori' => 'syarat',
            'urutan' => 2
        ]);

        // Data Gelombang Pendaftaran
        PpdbInfo::create([
            'judul' => 'Gelombang 1',
            'konten' => json_encode([
                'periode' => '1 Januari - 28 Februari 2024',
                'kuota' => '100 Siswa',
                'diskon' => '50%',
                'status' => 'Berakhir'
            ]),
            'kategori' => 'gelombang',
            'urutan' => 1
        ]);

        PpdbInfo::create([
            'judul' => 'Gelombang 2',
            'konten' => json_encode([
                'periode' => '1 Maret - 30 April 2024',
                'kuota' => '75 Siswa',
                'diskon' => '30%',
                'status' => 'Aktif'
            ]),
            'kategori' => 'gelombang',
            'urutan' => 2
        ]);

        PpdbInfo::create([
            'judul' => 'Gelombang 3',
            'konten' => json_encode([
                'periode' => '1 Mei - 30 Juni 2024',
                'kuota' => '50 Siswa',
                'diskon' => '10%',
                'status' => 'Akan Datang'
            ]),
            'kategori' => 'gelombang',
            'urutan' => 3
        ]);

        // Data Jadwal
        PpdbInfo::create([
            'judul' => 'Jadwal Pendaftaran',
            'konten' => json_encode([
                'Senin - Jumat' => '08:00 - 16:00 WIB',
                'Sabtu' => '08:00 - 12:00 WIB',
                'Minggu' => 'Tutup'
            ]),
            'kategori' => 'jadwal',
            'urutan' => 1
        ]);

        // Data Biaya
        PpdbInfo::create([
            'judul' => 'Biaya Daftar Ulang',
            'konten' => json_encode([
                'Biaya Pendaftaran' => 'Rp 200.000',
                'Biaya Seragam' => 'Rp 1.500.000',
                'Biaya Buku' => 'Rp 1.000.000',
                'Biaya Kegiatan' => 'Rp 500.000',
                'Total' => 'Rp 3.200.000'
            ]),
            'kategori' => 'biaya',
            'urutan' => 1
        ]);

        PpdbInfo::create([
            'judul' => 'Biaya SPP Bulanan',
            'konten' => json_encode([
                'SPP' => 'Rp 500.000',
                'Uang Makan' => 'Rp 300.000',
                'Ekstrakurikuler' => 'Rp 100.000',
                'Total' => 'Rp 900.000'
            ]),
            'kategori' => 'spp',
            'urutan' => 1
        ]);

        // Data Seragam
        PpdbInfo::create([
            'judul' => 'Daftar Seragam',
            'konten' => json_encode([
                [
                    'nama' => 'Seragam Putih Abu-abu',
                    'jumlah' => '2 Set',
                    'harga' => 'Rp 400.000'
                ],
                [
                    'nama' => 'Seragam Olahraga',
                    'jumlah' => '2 Set',
                    'harga' => 'Rp 300.000'
                ],
                [
                    'nama' => 'Seragam Pramuka',
                    'jumlah' => '1 Set',
                    'harga' => 'Rp 200.000'
                ],
                [
                    'nama' => 'Seragam Batik',
                    'jumlah' => '2 Set',
                    'harga' => 'Rp 400.000'
                ],
                [
                    'nama' => 'Seragam Muslim',
                    'jumlah' => '2 Set',
                    'harga' => 'Rp 200.000'
                ]
            ]),
            'kategori' => 'seragam',
            'urutan' => 1
        ]);
    }
} 