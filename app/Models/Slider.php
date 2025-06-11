<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_slider';
    public $incrementing = true;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'link',
        'urutan',
        'status',
    ];


    // Method untuk format response API
    public function toApiResponse()
    {
        return [
            'id_slider' => $this->id_slider,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'gambar' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'link' => $this->link,
            'urutan' => $this->urutan,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
} 