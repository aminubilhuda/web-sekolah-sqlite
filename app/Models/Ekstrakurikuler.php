<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ekstrakurikuler extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_ekstrakurikuler';
    public $incrementing = true;

    protected $fillable = [
        'nama_ekstrakurikuler',
        'deskripsi',
        'pembina',
        'hari_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'tempat_kegiatan',
        'foto',
        'status'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
    ];


    // Method untuk format response API
    public function toApiResponse()
    {
        return [
            'id_ekstrakurikuler' => $this->id_ekstrakurikuler,
            'nama_ekstrakurikuler' => $this->nama_ekstrakurikuler,
            'deskripsi' => $this->deskripsi,
            'pembina' => $this->pembina,
            'hari_kegiatan' => $this->hari_kegiatan,
            'jam_mulai' => $this->jam_mulai?->format('H:i'),
            'jam_selesai' => $this->jam_selesai?->format('H:i'),
            'tempat_kegiatan' => $this->tempat_kegiatan,
            'foto' => $this->foto ? asset('storage/' . $this->foto) : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}