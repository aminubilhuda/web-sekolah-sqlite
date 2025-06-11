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

            // Buat konteks dari data yang ada
            $context = "Kamu adalah asisten virtual untuk website sekolah. ";
            
            if ($sekolah) {
                $context .= "Sekolah ini bernama {$sekolah->nama_sekolah}. ";
                if ($sekolah->visi) $context .= "Visi sekolah: {$sekolah->visi}. ";
                if ($sekolah->misi) $context .= "Misi sekolah: {$sekolah->misi}. ";
            }

            if ($jurusan->isNotEmpty()) {
                $context .= "Sekolah ini memiliki jurusan: " . $jurusan->pluck('nama_jurusan')->join(', ') . ". ";
            }

            if ($ekstrakurikuler->isNotEmpty()) {
                $context .= "Ekstrakurikuler yang tersedia: " . $ekstrakurikuler->pluck('nama_ekstrakurikuler')->join(', ') . ". ";
            }

            if ($berita->isNotEmpty()) {
                $context .= "Berita terbaru: " . $berita->pluck('judul')->join(', ') . ". ";
            }

            if ($alumni->isNotEmpty()) {
                $context .= "Beberapa alumni terbaru: " . $alumni->pluck('nama')->join(', ') . ". ";
            }

            if ($fasilitas->isNotEmpty()) {
                $context .= "Fasilitas yang tersedia: " . $fasilitas->pluck('nama_fasilitas')->join(', ') . ". ";
            }

            if ($ptk->isNotEmpty()) {
                $context .= "Jumlah PTK: " . $ptk->count() . " orang. ";
                $context .= "Beberapa PTK: " . $ptk->take(5)->pluck('nama_ptk')->join(', ') . ". ";
            }

            if ($kelas->isNotEmpty()) {
                $context .= "Kelas yang tersedia: " . $kelas->pluck('nama_kelas')->join(', ') . ". ";
            }

            if ($hubunganIndustri->isNotEmpty()) {
                $context .= "Mitra industri: " . $hubunganIndustri->pluck('nama_perusahaan')->join(', ') . ". ";
            }

            if ($siswa->isNotEmpty()) {
                $context .= "Jumlah siswa terdaftar: " . $siswa->count() . " orang. ";
                $context .= "Beberapa siswa terbaru: " . $siswa->pluck('nama_siswa')->join(', ') . ". ";
            }

            // Instruksi format untuk Gemini
            $formatInstructions = "\n\nBerikan jawaban dengan format berikut:\n" .
                "1. Analisis gaya bahasa dan emosi pengguna:\n" .
                "   - Jika pengguna menggunakan bahasa formal, jawab dengan formal\n" .
                "   - Jika pengguna menggunakan bahasa gaul/gen Z, jawab dengan bahasa yang sama\n" .
                "   - Jika pengguna menggunakan emoji, gunakan emoji yang sesuai\n" .
                "   - Jika pengguna menggunakan singkatan, sesuaikan gaya bahasanya\n" .
                "   - Jika pengguna menggunakan bahasa santai, jawab dengan santai\n\n" .
                "2. Untuk curhat atau masalah pribadi:\n" .
                "   - Tunjukkan empati sesuai dengan emosi pengguna\n" .
                "   - Gunakan bahasa yang sesuai dengan gaya pengguna\n" .
                "   - Berikan saran dengan cara yang tidak menggurui\n" .
                "   - Hindari bahasa yang terlalu formal atau kaku\n" .
                "   - Gunakan kata-kata yang familiar dengan pengguna\n\n" .
                "3. Untuk informasi sekolah:\n" .
                "   - Sesuaikan gaya bahasa dengan pengguna\n" .
                "   - Tetap informatif tapi tidak kaku\n" .
                "   - Gunakan format yang mudah dibaca\n" .
                "   - Tambahkan emoji yang sesuai\n\n" .
                "4. Selalu pertahankan konteks percakapan\n" .
                "5. Sesuaikan panjang jawaban dengan konteks\n" .
                "6. Gunakan bahasa yang natural dan mengalir\n\n";

            // Buat prompt untuk Gemini
            $prompt = $context . $formatInstructions . "Riwayat percakapan:\n" . $chatContext . "\nPertanyaan terbaru: " . $request->message;

            // Kirim request ke Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
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
                throw new \Exception('Gagal mendapatkan respons dari Gemini AI');
            }
        } catch (\Exception $e) {
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