<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_galeri';
    public $incrementing = true;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'url_video',
        'is_active',
    ];

    protected $casts = [
        'gambar' => 'array',
        'is_active' => 'boolean',
    ];
}