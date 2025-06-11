<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Ptk extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $primaryKey = 'id_ptk';
    public $incrementing = true;

    protected $fillable = [
        'nip',
        'nuptk',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'kode_pos',
        'telepon',
        'email',
        'status_kepegawaian',
        'jenis_ptk',
        'tugas_tambahan',
        'status_tugas_tambahan',
        'kode_wilayah',
        'pendidikan_terakhir',
        'jabatan',
        'foto',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi dengan Sekolah sebagai Kepala Sekolah
    public function sekolahKepala()
    {
        return $this->hasOne(Sekolah::class, 'id_kepala_sekolah');
    }

    // Relasi dengan Sekolah sebagai Operator
    public function sekolahOperator()
    {
        return $this->hasOne(Sekolah::class, 'id_operator');
    }

    // Method untuk API response
    public function toApiResponse()
    {
        return [
            'id_ptk' => $this->id_ptk,
            'nip' => $this->nip,
            'nuptk' => $this->nuptk,
            'nik' => $this->nik,
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir->format('Y-m-d'),
            'agama' => $this->agama,
            'alamat' => $this->alamat,
            'kode_pos' => $this->kode_pos,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'status_kepegawaian' => $this->status_kepegawaian,
            'jenis_ptk' => $this->jenis_ptk,
            'tugas_tambahan' => $this->tugas_tambahan,
            'status_tugas_tambahan' => $this->status_tugas_tambahan,
            'kode_wilayah' => $this->kode_wilayah,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    // Accessor untuk nama lengkap
    public function getNamaLengkapAttribute()
    {
        return $this->nama;
    }

    // Accessor untuk status kepegawaian lengkap
    public function getStatusKepegawaianLengkapAttribute()
    {
        return match($this->status_kepegawaian) {
            'PNS' => 'Pegawai Negeri Sipil',
            'GTT' => 'Guru Tidak Tetap',
            'PTT' => 'Pegawai Tidak Tetap',
            default => $this->status_kepegawaian
        };
    }

    // Relasi dengan User
    public function user()
    {
        return $this->hasOne(User::class, 'id_ptk');
    }
}
