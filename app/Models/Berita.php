<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_berita';
    public $incrementing = true;

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'gambar',
        'kategori',
        'penulis',
        'status',
        'headline',
        'tanggal_publish',
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
    ];

    // Scope untuk berita yang dipublish
    public function scopePublished($query)
    {
        return $query->where('status', 'Published')
                    ->where('tanggal_publish', '<=', now());
    }

    // Scope untuk berita headline
    public function scopeHeadline($query)
    {
        return $query->where('headline', 'Yes');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_berita' => $this->id_berita,
            'judul' => $this->judul,
            'slug' => $this->slug,
            'isi' => $this->isi,
            'gambar' => $this->gambar,
            'kategori' => $this->kategori,
            'penulis' => $this->penulis,
            'status' => $this->status,
            'headline' => $this->headline,
            'tanggal_publish' => $this->tanggal_publish ? $this->tanggal_publish->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}