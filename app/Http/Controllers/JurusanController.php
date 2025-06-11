<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('jurusan.index', compact('jurusans'));
    }

    public function show($slug)
    {
        $jurusan = Jurusan::where('slug', $slug)->firstOrFail();
        return view('jurusan.show', compact('jurusan'));
    }
} 