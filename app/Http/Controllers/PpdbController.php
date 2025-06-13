<?php

namespace App\Http\Controllers;

use App\Models\Ppdb;
use App\Models\Jurusan;
use App\Models\PpdbInfo;
use App\Models\User;
use App\Mail\PpdbRegistrationNotification;
use App\Mail\PpdbAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PpdbController extends Controller
{
    public function index()
    {
        $infos = PpdbInfo::active()->ordered()->get()->groupBy('kategori');
        return view('ppdb.index', compact('infos'));
    }

    public function create()
    {
        $jurusans = Jurusan::where('status', 'Aktif')->get();
        return view('ppdb.form', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $messages = [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'agama.required' => 'Agama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'sekolah_asal.required' => 'Sekolah asal wajib diisi.',
            'id_jurusan.required' => 'Jurusan wajib dipilih.',
            'id_jurusan.exists' => 'Jurusan yang dipilih tidak valid.',
            'gelombang.required' => 'Gelombang pendaftaran wajib dipilih.',
            'jalur.required' => 'Jalur pendaftaran wajib dipilih.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'ijazah.required' => 'File ijazah wajib diunggah.',
            'ijazah.mimes' => 'Format ijazah harus pdf, jpeg, png, atau jpg.',
            'ijazah.max' => 'Ukuran ijazah maksimal 2MB.',
            'skhun.required' => 'File SKHUN wajib diunggah.',
            'skhun.mimes' => 'Format SKHUN harus pdf, jpeg, png, atau jpg.',
            'skhun.max' => 'Ukuran SKHUN maksimal 2MB.',
            'kartu_keluarga.required' => 'File kartu keluarga wajib diunggah.',
            'kartu_keluarga.mimes' => 'Format kartu keluarga harus pdf, jpeg, png, atau jpg.',
            'kartu_keluarga.max' => 'Ukuran kartu keluarga maksimal 2MB.',
            'akta_kelahiran.required' => 'File akta kelahiran wajib diunggah.',
            'akta_kelahiran.mimes' => 'Format akta kelahiran harus pdf, jpeg, png, atau jpg.',
            'akta_kelahiran.max' => 'Ukuran akta kelahiran maksimal 2MB.',
            'surat_prestasi.mimes' => 'Format surat prestasi harus pdf, jpeg, png, atau jpg.',
            'surat_prestasi.max' => 'Ukuran surat prestasi maksimal 2MB.',
            'surat_tidak_mampu.mimes' => 'Format surat tidak mampu harus pdf, jpeg, png, atau jpg.',
            'surat_tidak_mampu.max' => 'Ukuran surat tidak mampu maksimal 2MB.',
        ];

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:ppdbs,nisn',
            'nik' => 'required|string|size:16|unique:ppdbs,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ibu' => 'nullable|string|max:20',
            'sekolah_asal' => 'required|string|max:255',
            'id_jurusan' => 'required|exists:jurusans,id_jurusan',
            'gelombang' => 'required|in:1,2,3',
            'jalur' => 'required|in:Reguler,Prestasi,Tidak Mampu',
            'prestasi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
            'skhun' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
            'kartu_keluarga' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
            'akta_kelahiran' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
            'surat_prestasi' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
            'surat_tidak_mampu' => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
        ], $messages);

        try {
            DB::beginTransaction();

            // Upload files
            $data = $request->except(['foto', 'ijazah', 'skhun', 'kartu_keluarga', 'akta_kelahiran', 'surat_prestasi', 'surat_tidak_mampu']);
            
            // Handle required files
            $fields = ['foto', 'ijazah', 'skhun', 'kartu_keluarga', 'akta_kelahiran'];
            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('public/ppdb');
                }
            }
            
            // Handle optional files
            $optionalFields = ['surat_prestasi', 'surat_tidak_mampu'];
            foreach ($optionalFields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('public/ppdb');
                }
            }

            // Create PPDB record
            $ppdb = Ppdb::create($data);

            // Send email to applicant if email is provided
            if ($ppdb->email) {
                Mail::to($ppdb->email)->send(new PpdbRegistrationNotification($ppdb));
            }

            // Send email to admin
            $admin = User::role('admin')->first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new PpdbAdminNotification($ppdb));
            }

            DB::commit();

            return redirect()
                ->route('ppdb.success')
                ->with('success', $ppdb->nomor_registrasi);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded files if any
            if (isset($data)) {
                $fields = array_merge($fields, $optionalFields);
                foreach ($fields as $field) {
                    if (isset($data[$field])) {
                        Storage::delete($data[$field]);
                    }
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('ppdb.index');
        }
        return view('ppdb.success');
    }

    public function status()
    {
        return view('ppdb.status');
    }

    // Method untuk cek status pendaftaran (bisa ditambahkan nanti)
    public function checkStatus(Request $request)
    {
        $request->validate([
            'nomor_registrasi' => 'required|string|exists:ppdbs,nomor_registrasi'
        ]);

        $ppdb = Ppdb::where('nomor_registrasi', $request->nomor_registrasi)->first();
        
        return view('ppdb.status', compact('ppdb'));
    }
}