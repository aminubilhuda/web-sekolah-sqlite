<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::where('is_active', true)
            ->orderByDesc('created_at')
            ->paginate(12);
        return view('galeri.index', compact('galeris'));
    }
}