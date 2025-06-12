<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Siswa extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $primaryKey = 'id_siswa';
    public $incrementing = true;

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'id_jurusan',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];


    // Relasi dengan Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Relasi dengan User
    public function user()
    {
        return $this->hasOne(User::class, 'id_siswa');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_siswa' => $this->id_siswa,
            'nis' => $this->nis,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir->format('Y-m-d'),
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'jurusan' => $this->jurusan ? $this->jurusan->toApiResponse() : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}