<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sekolah extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_sekolah';
    public $incrementing = true;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'status_sekolah',
        'alamat_sekolah',
        'email_sekolah',
        'telepon_sekolah',
        'website_sekolah',
        'visi',
        'misi',
        'sejarah',
        'sambutan_kepala_sekolah',
        'foto_kepala_sekolah',
        'tujuan',
        'motto',
        'logo_sekolah',
        'icon_sekolah',
        'akreditasi',
        'tahun_berdiri',
        'kode_pos',
        'instagram_sekolah',
        'facebook_sekolah',
        'youtube_sekolah',
        'tiktok_sekolah',
        'whatsapp_sekolah',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa_kelurahan',
        'google_maps',
        'jenis_sekolah',
        'status_aktif',
    ];

    protected $casts = [
        'tahun_berdiri' => 'integer',
    ];

    // Relasi dengan Yayasan
    public function yayasan()
    {
        return $this->belongsTo(Yayasan::class, 'id_yayasan');
    }

    // Relasi dengan Kepala Sekolah (PTK)
    public function kepalaSekolah()
    {
        return $this->belongsTo(Ptk::class, 'id_kepala_sekolah');
    }

    // Relasi dengan Operator (PTK)
    public function operator()
    {
        return $this->belongsTo(Ptk::class, 'id_operator');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_sekolah' => $this->id_sekolah,
            'npsn' => $this->npsn,
            'nama_sekolah' => $this->nama_sekolah,
            'status_sekolah' => $this->status_sekolah,
            'alamat_sekolah' => $this->alamat_sekolah,
            'kode_wilayah' => $this->kode_wilayah,
            'email_sekolah' => $this->email_sekolah,
            'telepon_sekolah' => $this->telepon_sekolah,
            'website_sekolah' => $this->website_sekolah,
            'akreditasi' => $this->akreditasi,
            'luas_tanah' => $this->luas_tanah,
            'luas_bangunan' => $this->luas_bangunan,
            'jumlah_ruang' => $this->jumlah_ruang,
            'jumlah_siswa' => $this->jumlah_siswa,
            'jumlah_guru' => $this->jumlah_guru,
            'jumlah_tendik' => $this->jumlah_tendik,
            'status_kepemilikan_tanah' => $this->status_kepemilikan_tanah,
            'tahun_berdiri' => $this->tahun_berdiri,
            'kode_pos' => $this->kode_pos,
            'provinsi' => $this->provinsi,
            'kabupaten_kota' => $this->kabupaten_kota,
            'kecamatan' => $this->kecamatan,
            'desa_kelurahan' => $this->desa_kelurahan,
            'jenis_sekolah' => $this->jenis_sekolah,
            'id_wilayah' => $this->id_wilayah,
            'status_validasi' => $this->status_validasi,
            'tanggal_input' => $this->tanggal_input,
            'tanggal_update' => $this->tanggal_update,
            'status_sinkronisasi' => $this->status_sinkronisasi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}