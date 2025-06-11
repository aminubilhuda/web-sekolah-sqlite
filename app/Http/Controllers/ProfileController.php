<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Berita;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::first();

        if (!$sekolah) {
            return redirect()->back()->with('error', 'Data sekolah belum tersedia. Silakan lengkapi data sekolah terlebih dahulu.');
        }

        return view('profile.index', compact('sekolah'));
    }
}