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

    // Mutator untuk memastikan konten selalu array dan memformat angka untuk kategori SPP
    public function setKontenAttribute($value)
    {
        if ($this->kategori === 'spp') {
            // Untuk kategori SPP, pastikan semua nilai numerik
            if (is_string($value)) {
                $value = json_decode($value, true);
            }
            
            // Pastikan semua nilai numerik dan dalam format yang benar
            $formattedValue = [
                'spp' => (string)intval($value['spp'] ?? 0),
                'makan' => (string)intval($value['makan'] ?? 0),
                'ekstrakurikuler' => (string)intval($value['ekstrakurikuler'] ?? 0),
                'total' => intval($value['spp'] ?? 0) + intval($value['makan'] ?? 0) + intval($value['ekstrakurikuler'] ?? 0)
            ];
            
            $this->attributes['konten'] = json_encode($formattedValue);
        } else {
            // Untuk kategori lain, gunakan format yang sudah ada
            if (is_string($value)) {
                $this->attributes['konten'] = json_encode([$value]);
            } else {
                $this->attributes['konten'] = json_encode($value);
            }
        }
    }

    // Accessor untuk memastikan konten selalu array dan memvalidasi format SPP
    public function getKontenAttribute($value)
    {
        $decoded = json_decode($value, true);
        
        if ($this->kategori === 'spp' && is_array($decoded)) {
            // Pastikan semua kunci yang diperlukan ada
            $decoded = array_merge([
                'spp' => '0',
                'makan' => '0',
                'ekstrakurikuler' => '0',
                'total' => 0
            ], $decoded);
        }
        
        return $decoded ?? [];
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