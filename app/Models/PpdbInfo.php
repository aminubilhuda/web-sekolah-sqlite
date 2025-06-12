<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbInfo extends Model
{
    use HasFactory;

    protected $table = 'ppdb_infos';
    protected $primaryKey = 'id_info';

    protected $fillable = [
        'judul',
        'kategori',
        'konten',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'konten' => 'array',
        'is_active' => 'boolean',
    ];

    // Mutator untuk memastikan konten selalu array
    public function setKontenAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['konten'] = json_encode([$value]);
        } else {
            $this->attributes['konten'] = json_encode($value);
        }
    }

    // Accessor untuk memastikan konten selalu array
    public function getKontenAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    // Scope untuk mengambil data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk mengurutkan berdasarkan urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
} 