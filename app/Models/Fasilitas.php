<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_fasilitas';
    public $incrementing = true;

    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
        'kategori',
        'jumlah',
        'kondisi',
        'foto',
        'status'
    ];


    // Method untuk format response API
    public function toApiResponse()
    {
        return [
            'id_fasilitas' => $this->id_fasilitas,
            'nama_fasilitas' => $this->nama_fasilitas,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'jumlah' => $this->jumlah,
            'kondisi' => $this->kondisi,
            'foto' => $this->foto ? asset('storage/' . $this->foto) : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}