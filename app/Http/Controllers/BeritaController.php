<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::where('status', 'Published')
            ->latest('tanggal_publish')
            ->paginate(9);
            
        Log::info('Berita index accessed', ['count' => $beritas->count()]);
        return view('berita.index', compact('beritas'));
    }

    public function show($slug)
    {
        Log::info('Attempting to show berita', ['slug' => $slug]);
        
        // Tampilkan semua berita untuk debug
        $allBeritas = Berita::all();
        Log::info('All beritas:', ['beritas' => $allBeritas->toArray()]);
        
        $berita = Berita::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();
        
        if (!$berita) {
            Log::error('Berita not found with slug: ' . $slug);
            // Tampilkan semua slug yang ada
            $allSlugs = Berita::pluck('slug')->toArray();
            Log::info('Available slugs:', ['slugs' => $allSlugs]);
            abort(404);
        }
        
        Log::info('Berita found', ['id' => $berita->id_berita, 'slug' => $slug]);
        
        // Get related news (same category, excluding current news)
        $relatedNews = Berita::where('kategori', $berita->kategori)
            ->where('id_berita', '!=', $berita->id_berita)
            ->where('status', 'Published')
            ->latest('tanggal_publish')
            ->take(2)
            ->get();
        
        // Get previous and next news
        $currentDate = $berita->tanggal_publish ? $berita->tanggal_publish->format('Y-m-d H:i:s') : null;
        
        $previousNews = null;
        $nextNews = null;
        
        if ($currentDate) {
            $previousNews = Berita::where('status', 'Published')
                ->where('tanggal_publish', '<', $currentDate)
                ->orderBy('tanggal_publish', 'desc')
                ->first();
                
            $nextNews = Berita::where('status', 'Published')
                ->where('tanggal_publish', '>', $currentDate)
                ->orderBy('tanggal_publish', 'asc')
                ->first();
        }
        
        return view('berita.show', compact('berita', 'relatedNews', 'previousNews', 'nextNews'));
    }
} 