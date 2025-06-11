<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_infaq';
    public $incrementing = true;

    protected $fillable = [
        'id_kelas',
        'nama_penyetor',
        'tanggal',
        'jumlah',
        'keterangan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}