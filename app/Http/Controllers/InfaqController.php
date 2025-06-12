<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $infaqs = Infaq::with('kelas')
            ->when($request->bulan, function($query) use ($request) {
                return $query->whereMonth('tanggal', $request->bulan);
            })
            ->when($request->tahun, function($query) use ($request) {
                return $query->whereYear('tanggal', $request->tahun);
            })
            ->when($request->kelas, function($query) use ($request) {
                return $query->where('id_kelas', $request->kelas);
            })
            ->latest()
            ->paginate(10);

        $totalBulanIni = Infaq::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');

        $totalTahunIni = Infaq::whereYear('tanggal', now()->year)
            ->sum('jumlah');

        $jumlahDonatur = Infaq::distinct('nama_penyetor')->count('nama_penyetor');

        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $tahun = range(2020, now()->year);
        $kelas = Kelas::all();

        return view('infaq.index', compact(
            'infaqs', 'totalBulanIni', 'totalTahunIni',
            'jumlahDonatur', 'bulan', 'tahun', 'kelas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $kelas = Kelas::all();
        // return view('infaq.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penyetor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Infaq::create([
                'nama_penyetor' => $request->nama_penyetor,
                'tanggal' => $request->tanggal,
                'jumlah' => $request->jumlah,
                'id_kelas' => $request->id_kelas,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infaq $infaq)
    {
        $kelas = Kelas::all();
        return view('infaq.edit', compact('infaq', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Infaq $infaq)
    {
        $request->validate([
            'nama_penyetor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $infaq->update([
                'nama_penyetor' => $request->nama_penyetor,
                'tanggal' => $request->tanggal,
                'jumlah' => $request->jumlah,
                'id_kelas' => $request->id_kelas,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infaq $infaq)
    {
        try {
            DB::beginTransaction();
            $infaq->delete();
            DB::commit();
            return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 