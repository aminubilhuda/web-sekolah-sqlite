<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Berita;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::where('status', 'Aktif')->get();
        $beritas = Berita::where('status', 'Published')
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();
            
        return view('beranda', compact('jurusans', 'beritas'));
    }
}