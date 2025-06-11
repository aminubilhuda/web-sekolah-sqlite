<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beritas = [
            [
                'judul' => 'Pembukaan PPDB Tahun Ajaran 2024/2025',
                'slug' => 'pembukaan-ppdb-tahun-ajaran-2024-2025',
                'isi' => '<p>SMK Negeri 1 Jakarta membuka pendaftaran Peserta Didik Baru (PPDB) untuk Tahun Ajaran 2024/2025. Pendaftaran dibuka mulai tanggal 1 Maret 2024 hingga 30 April 2024.</p>
                    <p>Persyaratan pendaftaran:</p>
                    <ul>
                        <li>Lulusan SMP/MTs tahun 2024</li>
                        <li>Usia maksimal 21 tahun</li>
                        <li>Membawa fotokopi ijazah dan SKHUN</li>
                        <li>Pas foto 3x4 (2 lembar)</li>
                    </ul>
                    <p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB di nomor (021) 1234567.</p>',
                'kategori' => 'Pengumuman',
                'penulis' => 'Admin',
                'status' => 'Published',
                'headline' => 'Yes',
                'tanggal_publish' => Carbon::now(),
            ],
            [
                'judul' => 'Workshop Pengembangan Kurikulum Merdeka',
                'slug' => 'workshop-pengembangan-kurikulum-merdeka',
                'isi' => '<p>SMK Negeri 1 Jakarta mengadakan workshop pengembangan Kurikulum Merdeka untuk seluruh guru. Workshop ini bertujuan untuk meningkatkan pemahaman dan implementasi Kurikulum Merdeka di sekolah.</p>
                    <p>Kegiatan ini diikuti oleh:</p>
                    <ul>
                        <li>Seluruh guru mata pelajaran</li>
                        <li>Tim pengembang kurikulum</li>
                        <li>Kepala program keahlian</li>
                    </ul>
                    <p>Workshop dilaksanakan selama 3 hari dengan menghadirkan narasumber dari Kemendikbudristek.</p>',
                'kategori' => 'Kegiatan',
                'penulis' => 'Tim Kurikulum',
                'status' => 'Published',
                'headline' => 'No',
                'tanggal_publish' => Carbon::now()->subDays(2),
            ],
            [
                'judul' => 'Prestasi Tim Robotik di Kompetisi Nasional',
                'slug' => 'prestasi-tim-robotik-di-kompetisi-nasional',
                'isi' => '<p>Tim Robotik SMK Negeri 1 Jakarta berhasil meraih juara 1 dalam Kompetisi Robotik Nasional 2024. Tim yang terdiri dari 3 siswa ini berhasil mengalahkan 50 tim dari berbagai sekolah di Indonesia.</p>
                    <p>Prestasi yang diraih:</p>
                    <ul>
                        <li>Juara 1 Kategori Robot Line Follower</li>
                        <li>Best Design Award</li>
                        <li>Best Innovation Award</li>
                    </ul>
                    <p>Tim akan mewakili Indonesia di kompetisi robotik internasional yang akan diselenggarakan di Jepang.</p>',
                'kategori' => 'Prestasi',
                'penulis' => 'Tim Humas',
                'status' => 'Published',
                'headline' => 'No',
                'tanggal_publish' => Carbon::now()->subDays(5),
            ],
            [
                'judul' => 'Kunjungan Industri ke PT Astra International',
                'slug' => 'kunjungan-industri-ke-pt-astra-international',
                'isi' => '<p>Sebanyak 50 siswa dari program keahlian Teknik Kendaraan Ringan melakukan kunjungan industri ke PT Astra International. Kunjungan ini bertujuan untuk memberikan wawasan tentang dunia kerja dan industri otomotif.</p>
                    <p>Kegiatan yang dilakukan:</p>
                    <ul>
                        <li>Tour pabrik</li>
                        <li>Workshop perakitan mesin</li>
                        <li>Diskusi dengan praktisi industri</li>
                    </ul>
                    <p>Kunjungan ini merupakan bagian dari program pengembangan kompetensi siswa sesuai dengan kebutuhan industri.</p>',
                'kategori' => 'Kegiatan',
                'penulis' => 'Tim TKR',
                'status' => 'Published',
                'headline' => 'No',
                'tanggal_publish' => Carbon::now()->subDays(7),
            ],
            [
                'judul' => 'Pelatihan K3 untuk Siswa Prakerin',
                'slug' => 'pelatihan-k3-untuk-siswa-prakerin',
                'isi' => '<p>Sebelum memulai Praktik Kerja Industri (Prakerin), seluruh siswa kelas XI mengikuti pelatihan Keselamatan dan Kesehatan Kerja (K3). Pelatihan ini wajib diikuti sebagai syarat untuk mengikuti prakerin.</p>
                    <p>Materi yang disampaikan:</p>
                    <ul>
                        <li>Dasar-dasar K3</li>
                        <li>Prosedur keselamatan kerja</li>
                        <li>Penanganan keadaan darurat</li>
                        <li>Penggunaan APD</li>
                    </ul>
                    <p>Pelatihan dilaksanakan selama 2 hari dengan instruktur dari Dinas Tenaga Kerja.</p>',
                'kategori' => 'Pengumuman',
                'penulis' => 'Tim Prakerin',
                'status' => 'Published',
                'headline' => 'No',
                'tanggal_publish' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }
    }
} 