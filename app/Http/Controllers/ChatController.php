<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Setting;
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
            // Ambil data sekolah untuk konteks
            $sekolah = \App\Models\Sekolah::first();
            $sekolahInfo = $sekolah ? "Sekolah ini bernama {$sekolah->nama_sekolah}. " : "";
            
            // Buat prompt untuk Gemini
            $prompt = "Kamu adalah asisten virtual untuk website sekolah. {$sekolahInfo} " .
                     "Berikan jawaban yang informatif dan membantu untuk pertanyaan berikut: " .
                     $request->message;

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