<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'nama',
        'tahun_lulus',
        'id_jurusan',
        'testimoni',
        'foto',
        'status',
        'pekerjaan',
        'perguruan_tinggi',
        'jurusan_kuliah'
    ];

    // Relasi dengan Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }
} 