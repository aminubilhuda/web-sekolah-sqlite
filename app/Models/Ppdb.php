<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppdb extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppdbs';
    protected $primaryKey = 'id_ppdb';
    public $incrementing = true;

    protected $fillable = [
        'nomor_registrasi',
        'nama_lengkap',
        'nisn',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'kode_pos',
        'telepon',
        'email',
        'nama_ayah',
        'pekerjaan_ayah',
        'telepon_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'telepon_ibu',
        'sekolah_asal',
        'id_jurusan',
        'gelombang',
        'jalur',
        'prestasi',
        'status',
        'foto',
        'ijazah',
        'skhun', 
        'kartu_keluarga',
        'akta_kelahiran',
        'surat_prestasi',
        'surat_tidak_mampu'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi dengan Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan gelombang
    public function scopeGelombang($query, $gelombang)
    {
        return $query->where('gelombang', $gelombang);
    }

    // Scope untuk filter berdasarkan jalur
    public function scopeJalur($query, $jalur)
    {
        return $query->where('jalur', $jalur);
    }

    // Accessor untuk mendapatkan umur pendaftar
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    // Accessor untuk mendapatkan status lengkap
    public function getStatusLengkapAttribute()
    {
        return match($this->status) {
            'Menunggu' => 'Menunggu Verifikasi',
            'Diterima' => 'Diterima',
            'Ditolak' => 'Ditolak',
            'Cadangan' => 'Diterima sebagai Cadangan',
            default => $this->status
        };
    }

    // Boot method untuk generate nomor registrasi otomatis
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ppdb) {
            if (empty($ppdb->nomor_registrasi)) {
                $tahun = date('Y');
                $count = static::whereYear('created_at', $tahun)->count() + 1;
                $ppdb->nomor_registrasi = 'PPDB-' . $tahun . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}