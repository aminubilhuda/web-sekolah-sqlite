<?php

namespace App\Http\Controllers;

use App\Models\PpdbInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpdbInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infos = PpdbInfo::active()->ordered()->get()->groupBy('kategori');
        return view('ppdb.index', compact('infos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ppdb.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|array',
            'kategori' => 'required|in:syarat,gelombang,jadwal,biaya,seragam,spp',
            'urutan' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            PpdbInfo::create([
                'judul' => $request->judul,
                'konten' => json_encode($request->konten),
                'kategori' => $request->kategori,
                'urutan' => $request->urutan
            ]);

            DB::commit();
            return redirect()->route('ppdb.index')->with('success', 'Informasi PPDB berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PpdbInfo $ppdbInfo)
    {
        return view('ppdb.edit', compact('ppdbInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PpdbInfo $ppdbInfo)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|array',
            'kategori' => 'required|in:syarat,gelombang,jadwal,biaya,seragam,spp',
            'urutan' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $ppdbInfo->update([
                'judul' => $request->judul,
                'konten' => json_encode($request->konten),
                'kategori' => $request->kategori,
                'urutan' => $request->urutan
            ]);

            DB::commit();
            return redirect()->route('ppdb.index')->with('success', 'Informasi PPDB berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PpdbInfo $ppdbInfo)
    {
        try {
            DB::beginTransaction();
            $ppdbInfo->delete();
            DB::commit();
            return redirect()->route('ppdb.index')->with('success', 'Informasi PPDB berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif
     */
    public function toggleStatus(PpdbInfo $ppdbInfo)
    {
        try {
            DB::beginTransaction();
            $ppdbInfo->update(['is_active' => !$ppdbInfo->is_active]);
            DB::commit();
            return redirect()->route('ppdb.index')->with('success', 'Status informasi PPDB berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 