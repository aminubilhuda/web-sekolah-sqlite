<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_kelas';
    public $incrementing = true;

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'id_jurusan',
        'id_wali_kelas',
        'kapasitas',
        'jumlah_siswa',
        'tingkat',
        'status'
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'jumlah_siswa' => 'integer',
    ];

    // Relasi dengan Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Relasi dengan Wali Kelas (PTK)
    public function waliKelas()
    {
        return $this->belongsTo(Ptk::class, 'id_wali_kelas');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_kelas' => $this->id_kelas,
            'nama_kelas' => $this->nama_kelas,
            'kode_kelas' => $this->kode_kelas,
            'jurusan' => $this->jurusan ? $this->jurusan->toApiResponse() : null,
            'wali_kelas' => $this->waliKelas ? $this->waliKelas->toApiResponse() : null,
            'kapasitas' => $this->kapasitas,
            'jumlah_siswa' => $this->jumlah_siswa,
            'tingkat' => $this->tingkat,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function infaqs()
    {
        return $this->hasMany(Infaq::class, 'id_kelas');
    }
}