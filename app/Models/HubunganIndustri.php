<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubunganIndustri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hubins';
    protected $primaryKey = 'id_hubin';
    public $incrementing = true;

    protected $fillable = [
        'nama_perusahaan',
        'bidang_usaha',
        'alamat',
        'telepon',
        'email',
        'website',
        'nama_pic',
        'jabatan_pic',
        'telepon_pic',
        'email_pic',
        'deskripsi',
        'logo',
        'id_sekolah',
        'status',
    ];

    // Relasi dengan Sekolah
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    // Scope untuk hubin yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
} 