<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with('jurusan')->get();
        return view('alumni.index', compact('alumni'));
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('alumni.show', compact('alumni'));
    }
} 