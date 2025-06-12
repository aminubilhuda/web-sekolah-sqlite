<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        // Ambil data sekolah pertama
        $sekolah = Sekolah::first();

        // Jika tidak ada data sekolah, tampilkan pesan error
        if (!$sekolah) {
            return redirect()->route('beranda')->with('error', 'Data sekolah belum tersedia. Silakan hubungi administrator.');
        }

        return view('kontak.index', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        // Simpan pesan ke database
        Kontak::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
            'status' => 'Belum Dibaca'
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
} 