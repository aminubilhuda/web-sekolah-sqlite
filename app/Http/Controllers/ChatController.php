<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Setting;
use App\Models\Sekolah;
use App\Models\Jurusan;
use App\Models\Ekstrakurikuler;
use App\Models\Berita;
use App\Models\Alumni;
use App\Models\Fasilitas;
use App\Models\Ptk;
use App\Models\Kelas;
use App\Models\HubunganIndustri;
use App\Models\Siswa;
use App\Models\PpdbInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'session_id' => 'required|string'
        ]);

        // Simpan pesan user
        $chat = Chat::create([
            'message' => $request->message,
            'is_from_user' => true,
            'session_id' => $request->session_id
        ]);

        // Ambil API Key Gemini
        $apiKey = Setting::getValue('gemini_api_key');
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'API Key Gemini belum diatur'
            ], 500);
        }

        try {
            // Ambil riwayat chat terakhir (5 pesan terakhir)
            $chatHistory = Chat::where('session_id', $request->session_id)
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get()
                             ->reverse();

            // Format riwayat chat
            $chatContext = "";
            foreach ($chatHistory as $history) {
                $role = $history->is_from_user ? "User" : "Assistant";
                $chatContext .= "{$role}: {$history->message}\n";
                if ($history->response) {
                    $chatContext .= "Assistant: {$history->response}\n";
                }
            }

            // Ambil data dari berbagai tabel untuk konteks
            $sekolah = Sekolah::first();
            $jurusan = Jurusan::all();
            $ekstrakurikuler = Ekstrakurikuler::all();
            $berita = Berita::latest()->take(5)->get();
            $alumni = Alumni::latest()->take(5)->get();
            $fasilitas = Fasilitas::all();
            $ptk = Ptk::all();
            $kelas = Kelas::all();
            $hubunganIndustri = HubunganIndustri::all();
            $siswa = Siswa::latest()->take(5)->get();
            $ppdbInfo = PpdbInfo::active()->ordered()->get();

            // Buat konteks dari data yang ada (ringkas)
            $context = "Kamu adalah asisten virtual ramah untuk website " . ($sekolah ? $sekolah->nama_sekolah : 'sekolah') . ". ";
            
            // Informasi PPDB
            if ($ppdbInfo->isNotEmpty()) {
                $context .= "\nInformasi PPDB:\n";
                foreach ($ppdbInfo as $info) {
                    $context .= "- {$info->judul}:\n";
                    if ($info->kategori === 'spp') {
                        $konten = $info->konten;
                        $context .= "  SPP: Rp " . number_format($konten['spp'], 0, ',', '.') . "\n";
                        $context .= "  Makan: Rp " . number_format($konten['makan'], 0, ',', '.') . "\n";
                        $context .= "  Ekstrakurikuler: Rp " . number_format($konten['ekstrakurikuler'], 0, ',', '.') . "\n";
                        $context .= "  Total: Rp " . number_format($konten['total'], 0, ',', '.') . "\n";
                    } else {
                        if (is_array($info->konten)) {
                            foreach ($info->konten as $key => $value) {
                                $context .= "  {$key}: {$value}\n";
                            }
                        } else {
                            $context .= "  " . strip_tags($info->konten) . "\n";
                        }
                    }
                }
            }

            // Informasi lengkap sekolah
            if ($sekolah) {
                if ($sekolah->visi) {
                    $context .= "Visi sekolah: " . strip_tags($sekolah->visi) . ". ";
                }
                if ($sekolah->misi) {
                    $context .= "Misi sekolah: " . strip_tags($sekolah->misi) . ". ";
                }
                if ($sekolah->tahun_berdiri) {
                    $context .= "Tahun berdiri: " . $sekolah->tahun_berdiri . ". ";
                }
                if ($sekolah->alamat_sekolah) {
                    $context .= "Alamat: " . $sekolah->alamat_sekolah . ". ";
                }
                if ($sekolah->telepon_sekolah) {
                    $context .= "Telepon: " . $sekolah->telepon_sekolah . ". ";
                }
                if ($sekolah->email_sekolah) {
                    $context .= "Email: " . $sekolah->email_sekolah . ". ";
                }
                if ($sekolah->website_sekolah) {
                    $context .= "Website: " . $sekolah->website_sekolah . ". ";
                }
                if ($sekolah->akreditasi) {
                    $context .= "Akreditasi: " . $sekolah->akreditasi . ". ";
                }
                if ($sekolah->motto) {
                    $context .= "Motto: " . $sekolah->motto . ". ";
                }
                if ($sekolah->jenis_sekolah) {
                    $context .= "Jenis sekolah: " . $sekolah->jenis_sekolah . ". ";
                }
                if ($sekolah->npsn) {
                    $context .= "NPSN: " . $sekolah->npsn . ". ";
                }
                if ($sekolah->sejarah) {
                    $context .= "Sejarah: " . strip_tags($sekolah->sejarah) . ". ";
                }
                if ($sekolah->sambutan_kepala_sekolah) {
                    $context .= "Sambutan kepala sekolah: " . strip_tags($sekolah->sambutan_kepala_sekolah) . ". ";
                }
                if ($sekolah->provinsi) {
                    $context .= "Provinsi: " . $sekolah->provinsi . ". ";
                }
                if ($sekolah->kabupaten_kota) {
                    $context .= "Kabupaten/Kota: " . $sekolah->kabupaten_kota . ". ";
                }
                if ($sekolah->kecamatan) {
                    $context .= "Kecamatan: " . $sekolah->kecamatan . ". ";
                }
            }

            if ($jurusan->isNotEmpty()) {
                $jurusanList = $jurusan->map(function($j) {
                    return $j->nama_jurusan . ($j->kode_jurusan ? ' (' . $j->kode_jurusan . ')' : '');
                })->join(', ');
                $context .= "Jurusan tersedia ({$jurusan->count()} jurusan): " . $jurusanList . ". ";
                
                // Tambahan detail lengkap jurusan untuk pertanyaan spesifik
                $context .= "\nDetail Lengkap Jurusan:\n";
                foreach ($jurusan as $j) {
                    $context .= "- {$j->nama_jurusan}";
                    if ($j->kode_jurusan) {
                        $context .= " (Kode: {$j->kode_jurusan})";
                    }
                    if ($j->kepala_jurusan) {
                        $context .= " - Kepala Jurusan: {$j->kepala_jurusan}";
                    }
                    if ($j->jumlah_guru) {
                        $context .= " - Jumlah Guru: {$j->jumlah_guru} orang";
                    }
                    if ($j->jumlah_siswa) {
                        $context .= " - Jumlah Siswa: {$j->jumlah_siswa} orang";
                    }
                    if ($j->deskripsi_singkat) {
                        $context .= " - Deskripsi Singkat: {$j->deskripsi_singkat}";
                    }
                    if ($j->deskripsi) {
                        $cleanDesc = strip_tags($j->deskripsi);
                        $cleanDesc = preg_replace('/\s+/', ' ', $cleanDesc);
                        $context .= " - Deskripsi Lengkap: " . Str::limit($cleanDesc, 300);
                    }
                    $context .= "\n";
                }
            }

            if ($berita->isNotEmpty()) {
                $context .= "Berita terbaru: " . $berita->pluck('judul')->map(function($judul) {
                    return Str::limit($judul, 50);
                })->join(', ') . ". ";
            }

            if ($ekstrakurikuler->isNotEmpty()) {
                $context .= "Ekstrakurikuler: " . $ekstrakurikuler->pluck('nama_ekstrakurikuler')->join(', ') . ". ";
                
                // Tambahan detail ekstrakurikuler untuk pertanyaan spesifik
                $context .= "\nDetail Ekstrakurikuler:\n";
                foreach ($ekstrakurikuler as $ekskul) {
                    $context .= "- {$ekskul->nama_ekstrakurikuler}";
                    if ($ekskul->pembina) {
                        $context .= " (Pembina/Pelatih: {$ekskul->pembina})";
                    }
                    if ($ekskul->hari_kegiatan) {
                        $context .= " - Hari: {$ekskul->hari_kegiatan}";
                    }
                    if ($ekskul->jam_mulai && $ekskul->jam_selesai) {
                        $jamMulai = $ekskul->jam_mulai instanceof \DateTime ? $ekskul->jam_mulai->format('H:i') : $ekskul->jam_mulai;
                        $jamSelesai = $ekskul->jam_selesai instanceof \DateTime ? $ekskul->jam_selesai->format('H:i') : $ekskul->jam_selesai;
                        $context .= " - Waktu: {$jamMulai}-{$jamSelesai}";
                    }
                    if ($ekskul->tempat_kegiatan) {
                        $context .= " - Tempat: {$ekskul->tempat_kegiatan}";
                    }
                    if ($ekskul->deskripsi) {
                        $context .= " - Deskripsi: " . strip_tags(Str::limit($ekskul->deskripsi, 200));
                    }
                    $context .= "\n";
                }
            }

            if ($hubunganIndustri->isNotEmpty()) {
                $hubinList = $hubunganIndustri->map(function($hubin) {
                    return $hubin->nama_perusahaan . ' (' . $hubin->bidang_usaha . ')';
                })->join(', ');
                $context .= "Mitra hubungan industri ({$hubunganIndustri->count()} perusahaan): " . $hubinList . ". ";
                
                // Tambahan detail lengkap hubungan industri
                $context .= "\nDetail Mitra Industri:\n";
                foreach ($hubunganIndustri as $hubin) {
                    $context .= "- {$hubin->nama_perusahaan}";
                    if ($hubin->bidang_usaha) {
                        $context .= " (Bidang: {$hubin->bidang_usaha})";
                    }
                    if ($hubin->alamat) {
                        $context .= " - Alamat: {$hubin->alamat}";
                    }
                    if ($hubin->telepon) {
                        $context .= " - Telepon: {$hubin->telepon}";
                    }
                    if ($hubin->email) {
                        $context .= " - Email: {$hubin->email}";
                    }
                    if ($hubin->website) {
                        $context .= " - Website: {$hubin->website}";
                    }
                    if ($hubin->nama_pic) {
                        $context .= " - PIC: {$hubin->nama_pic}";
                        if ($hubin->jabatan_pic) {
                            $context .= " ({$hubin->jabatan_pic})";
                        }
                    }
                    if ($hubin->deskripsi) {
                        $cleanDesc = strip_tags($hubin->deskripsi);
                        $context .= " - Deskripsi: " . Str::limit($cleanDesc, 200);
                    }
                    $context .= "\n";
                }
            }
            $formatInstructions = "\n\nTUGAS: Kamu adalah asisten virtual sekolah yang ramah dan natural.\n\n" .
                "ATURAN RESPONS:\n" .
                "1. Sesuaikan gaya bahasa dengan user:\n" .
                "   - Formal → respons formal\n" .
                "   - Santai/gaul → respons santai\n" .
                "   - Pakai emoji → balasan pakai emoji\n" .
                "2. Untuk curhat: tunjukkan empati natural tanpa menggurui\n" .
                "3. Untuk info sekolah: berikan informasi yang mudah dipahami\n" .
                "4. JANGAN tampilkan analisis atau format terstruktur\n" .
                "5. Berikan jawaban langsung dan natural\n" .
                "6. Gunakan bahasa Indonesia yang mengalir\n" .
                "7. Untuk pertanyaan tentang jurusan: sebutkan SEMUA jurusan yang tersedia\n" .
                "8. Untuk pertanyaan tentang jurusan tertentu: berikan deskripsi lengkap dari detail jurusan\n" .
                "9. JANGAN gunakan tanda *, -, atau bullet points - gunakan kalimat yang natural\n" .
                "10. Untuk daftar: gunakan kata penghubung seperti 'ada', 'yaitu', 'antara lain'\n" .
                "11. Untuk pertanyaan tentang sekolah (tahun berdiri, alamat, visi, misi, dll): berikan informasi berdasarkan data sekolah yang tersedia\n" .
                "12. Gunakan nama sekolah yang benar sesuai data: " . ($sekolah ? $sekolah->nama_sekolah : 'sekolah') . "\n" .
                "13. Untuk pertanyaan tentang ekstrakurikuler: berikan informasi lengkap termasuk pelatih/pembina, jadwal, tempat, dll\n\n";

            // Buat prompt untuk Gemini
            $prompt = $context . $formatInstructions . 
                "CONTOH RESPONS YANG BAIK:\n" .
                "User: 'hai'\n" .
                "Assistant: 'Hai juga! Ada yang bisa kubantu? 😊'\n\n" .
                "User: 'ada jurusan apa aja?'\n" .
                "Assistant: 'Di sekolah kita ada [sebutkan SEMUA jurusan yang tersedia dengan kode jurusan]. Kamu tertarik yang mana? 😉'\n\n" .
                "User: 'berita terbaru apa?'\n" .
                "Assistant: 'Berita terbaru ada tentang [sebutkan dengan kalimat natural tanpa bullet points]. Ada yang mau kamu tau lebih detail? 😊'\n\n" .
                "User: 'Akuntansi itu apa sih?'\n" .
                "Assistant: 'Jurusan Akuntansi (AK) itu [jelaskan berdasarkan deskripsi lengkap dan fasilitas yang tersedia]. Kepala jurusannya [nama kepala jurusan]. Sekarang ada [jumlah siswa] siswa dan [jumlah guru] guru. Menarik kan? 😊'\n\n" .
                "User: 'RPL belajar apa aja?'\n" .
                "Assistant: 'Di Rekayasa Perangkat Lunak (RPL) kamu akan belajar [sebutkan materi berdasarkan deskripsi lengkap]. Jurusannya dipimpin sama [nama kepala jurusan]. Cocok buat yang suka coding! 💻😄'\n\n" .
                "User: 'jurusan mana yang paling banyak siswanya?'\n" .
                "Assistant: 'Dari data yang ada, jurusan [nama jurusan] punya siswa paling banyak yaitu [jumlah] orang. Disusul [jurusan lain] dengan [jumlah] orang. Kamu tertarik yang mana? 😊'\n\n" .
                "User: 'sekolah ini berdiri tahun berapa?'\n" .
                "Assistant: 'SMK Abdi Negara Tuban berdiri pada tahun " . ($sekolah && $sekolah->tahun_berdiri ? $sekolah->tahun_berdiri : '[tahun berdiri]') . ". Udah cukup lama ya! 😊'\n\n" .
                "User: 'alamat sekolah dimana?'\n" .
                "Assistant: 'Alamat sekolah di " . ($sekolah && $sekolah->alamat_sekolah ? $sekolah->alamat_sekolah : '[alamat sekolah]') . ". Kalau mau datang langsung, bisa kok! 😄'\n\n" .
                "User: 'ekstrakurikuler apa aja?'\n" .
                "Assistant: 'Ekstrakurikuler yang ada di sekolah kita antara lain [sebutkan SEMUA ekstrakurikuler yang tersedia]. Ada yang menarik buat kamu? 😊'\n\n" .
                "User: 'pelatih futsal siapa?'\n" .
                "Assistant: 'Pelatih Futsal kita adalah [sebutkan nama pembina/pelatih dari data yang tersedia]. Beliau yang ngajarin teknik-teknik keren futsal! 😄'\n\n" .
                "User: 'ada kerjasama industri?'\n" .
                "Assistant: 'Ada dong! Sekolah kita punya kerjasama dengan [sebutkan mitra industri yang tersedia]. Mereka suka nerima siswa magang dan bahkan rekrut lulusan kita! 😊'\n\n" .
                "User: 'mitra industri apa aja?'\n" .
                "Assistant: 'Mitra industri kita ada [sebutkan SEMUA nama perusahaan mitra dengan bidang usahanya]. Keren kan? Ada yang cocok buat jurusan kamu? 😄'\n\n" .
                "User: 'bisa magang dimana?'\n" .
                "Assistant: 'Kamu bisa magang di [sebutkan perusahaan mitra yang tersedia]. Biasanya untuk durasi 3-6 bulan. Mau tau lebih detail tentang salah satunya? 😊'\n\n" .
                "User: 'info ppdb dong'\n" .
                "Assistant: 'Untuk PPDB, kita punya beberapa gelombang pendaftaran. Gelombang 1 dimulai [tanggal] sampai [tanggal]. Biaya pendaftarannya Rp [jumlah]. Syaratnya antara lain [sebutkan syarat utama]. Mau tau lebih detail tentang [gelombang/biaya/syarat]? 😊'\n\n" .
                "User: 'berapa biaya spp?'\n" .
                "Assistant: 'Biaya SPP per bulan Rp [jumlah], ditambah biaya makan Rp [jumlah] dan ekstrakurikuler Rp [jumlah]. Total per bulan Rp [total]. Ada yang mau ditanyain lagi? 😊'\n\n" .
                "User: 'kapan pendaftaran ppdb?'\n" .
                "Assistant: 'Pendaftaran PPDB dibuka dalam beberapa gelombang. Gelombang 1 mulai [tanggal] sampai [tanggal], Gelombang 2 [tanggal] sampai [tanggal]. Buruan daftar ya, kuotanya terbatas! 😄'\n\n" .
                "User: 'syarat pendaftaran ppdb apa aja?'\n" .
                "Assistant: 'Syarat pendaftaran PPDB yang perlu disiapkan:\n" .
                "- Fotokopi KK: 1 Lembar\n" .
                "- Pas Foto 4x6: 1 Lembar\n" .
                "- Akte Kelahiran: 5 Lembar\n\n" .
                "Jangan lupa siapkan semua berkasnya ya! Ada yang mau ditanyain lagi? 😊'\n\n" .
                "User: 'makasih min'\n" .
                "Assistant: 'Sama-sama! Senang bisa bantu 😄'\n\n" .
                "RIWAYAT PERCAKAPAN:\n" . $chatContext . 
                "\nPERTANYAAN TERBARU: " . $request->message . 
                "\n\nJAWABAN (langsung tanpa analisis, tanpa bullet points):";

            // Kirim request ke Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(60)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                $aiResponse = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa memproses permintaan Anda saat ini.';

                // Simpan respons AI
                $chat->update([
                    'response' => $aiResponse
                ]);

                return response()->json([
                    'message' => $aiResponse
                ]);
            } else {
                // Log error untuk debugging
                \Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
                
                throw new \Exception('Gagal mendapatkan respons dari Gemini AI: HTTP ' . $response->status());
            }
        } catch (\Exception $e) {
            // Log error detail
            \Log::error('Chat Error: ' . $e->getMessage(), [
                'session_id' => $request->session_id,
                'message' => $request->message,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getChatHistory(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $chats = Chat::where('session_id', $request->session_id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response()->json($chats);
    }
} 