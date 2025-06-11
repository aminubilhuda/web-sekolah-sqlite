<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hubin extends Model
{
    use HasFactory, SoftDeletes;

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
        'status'
    ];


    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_hubin' => $this->id_hubin,
            'nama_perusahaan' => $this->nama_perusahaan,
            'bidang_usaha' => $this->bidang_usaha,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'website' => $this->website,
            'nama_pic' => $this->nama_pic,
            'jabatan_pic' => $this->jabatan_pic,
            'telepon_pic' => $this->telepon_pic,
            'email_pic' => $this->email_pic,
            'deskripsi' => $this->deskripsi,
            'logo' => $this->logo,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}