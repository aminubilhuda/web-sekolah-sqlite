<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use Symfony\Component\HttpFoundation\Response;

class DetectSekolahAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('id_sekolah_aktif')) {
            $sekolahAktif = Sekolah::where('status_aktif', 'Aktif')->first();
            if ($sekolahAktif) {
                session(['id_sekolah_aktif' => $sekolahAktif->id_sekolah]);
            }
        }

        return $next($request);
    }
} 