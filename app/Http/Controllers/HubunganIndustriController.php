<?php

namespace App\Http\Controllers;

use App\Models\HubunganIndustri;
use Illuminate\Http\Request;

class HubunganIndustriController extends Controller
{
    public function index()
    {
        $hubins = HubunganIndustri::where('status', 'Aktif')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('hubungan-industri.index', compact('hubins'));
    }
} 