<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurusans';
    protected $primaryKey = 'id_jurusan';
    public $incrementing = true;

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'slug',
        'deskripsi_singkat',
        'deskripsi',
        'gambar',
        'kepala_jurusan',
        'jumlah_guru',
        'jumlah_siswa',
        'status',
    ];

    protected $casts = [
        'jumlah_guru' => 'integer',
        'jumlah_siswa' => 'integer',
    ];

    // Boot method untuk generate slug otomatis
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($jurusan) {
            if (empty($jurusan->slug)) {
                $jurusan->slug = Str::slug($jurusan->nama_jurusan);
            }
        });
    }

    // Scope untuk jurusan yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }


    // Relasi dengan Kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_jurusan');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_jurusan' => $this->id_jurusan,
            'kode_jurusan' => $this->kode_jurusan,
            'nama_jurusan' => $this->nama_jurusan,
            'slug' => $this->slug,
            'deskripsi_singkat' => $this->deskripsi_singkat,
            'deskripsi' => $this->deskripsi,
            'gambar' => $this->gambar,
            'kepala_jurusan' => $this->kepala_jurusan,
            'jumlah_guru' => $this->jumlah_guru,
            'jumlah_siswa' => $this->jumlah_siswa,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}