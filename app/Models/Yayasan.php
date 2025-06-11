<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Yayasan extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_yayasan';
    public $incrementing = true;

    // Menonaktifkan timestamps default
    public $timestamps = false;

    // Mengatur nama kolom timestamps custom
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'nama',
        'alamat_jalan',
        'rt',
        'rw',
        'nama_dusun',
        'desa_kelurahan',
        'kecamatan',
        'kode_pos',
        'lintang',
        'bujur',
        'nomor_telepon',
        'nomor_fax',
        'email',
        'website',
        'nama_pimpinan_yayasan',
        'nomor_pendirian_yayasan',
        'tanggal_pendirian_yayasan',
        'nomor_pengesahan_pn_ln',
        'nomor_sk_bn',
        'tanggal_sk_bn',
        'soft_delete',
        'create_date',
        'last_update',
        'expired_date',
        'last_sync'
    ];

    protected $casts = [
        'tanggal_pendirian_yayasan' => 'date',
        'tanggal_sk_bn' => 'date',
        'soft_delete' => 'boolean',
        'create_date' => 'datetime',
        'last_update' => 'datetime',
        'expired_date' => 'datetime',
        'last_sync' => 'datetime'
    ];

    // Relasi dengan model Sekolah
    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class, 'id_yayasan');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_yayasan' => $this->id_yayasan,
            'nama' => $this->nama,
            'alamat' => [
                'jalan' => $this->alamat_jalan,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'dusun' => $this->nama_dusun,
                'desa_kelurahan' => $this->desa_kelurahan,
                'kecamatan' => $this->kecamatan,
                'kode_pos' => $this->kode_pos,
                'koordinat' => [
                    'lintang' => $this->lintang,
                    'bujur' => $this->bujur
                ]
            ],
            'kontak' => [
                'telepon' => $this->nomor_telepon,
                'fax' => $this->nomor_fax,
                'email' => $this->email,
                'website' => $this->website
            ],
            'pimpinan' => $this->nama_pimpinan_yayasan,
            'dokumen' => [
                'nomor_pendirian' => $this->nomor_pendirian_yayasan,
                'tanggal_pendirian' => $this->tanggal_pendirian_yayasan,
                'nomor_pengesahan_pn_ln' => $this->nomor_pengesahan_pn_ln,
                'nomor_sk_bn' => $this->nomor_sk_bn,
                'tanggal_sk_bn' => $this->tanggal_sk_bn
            ],
            'status' => [
                'soft_delete' => $this->soft_delete,
                'create_date' => $this->create_date,
                'last_update' => $this->last_update,
                'expired_date' => $this->expired_date,
                'last_sync' => $this->last_sync
            ]
        ];
    }
}
