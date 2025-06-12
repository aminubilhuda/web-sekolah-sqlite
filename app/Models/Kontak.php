<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontak extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kontaks';

    protected $fillable = [
        'nama',
        'email',
        'subjek',
        'pesan',
        'status',
        'balasan',
        'dibaca_at',
        'dibalas_at'
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
        'dibalas_at' => 'datetime',
    ];

    // Scope untuk pesan yang belum dibaca
    public function scopeBelumDibaca($query)
    {
        return $query->where('status', 'Belum Dibaca');
    }

    // Scope untuk pesan yang sudah dibaca
    public function scopeSudahDibaca($query)
    {
        return $query->where('status', 'Sudah Dibaca');
    }

    // Scope untuk pesan yang sudah dibalas
    public function scopeSudahDibalas($query)
    {
        return $query->where('status', 'Dibalas');
    }

    // Method untuk menandai pesan sebagai sudah dibaca
    public function tandaiDibaca()
    {
        $this->update([
            'status' => 'Sudah Dibaca',
            'dibaca_at' => now()
        ]);
    }

    // Method untuk membalas pesan
    public function balas($balasan)
    {
        $this->update([
            'status' => 'Dibalas',
            'balasan' => $balasan,
            'dibalas_at' => now()
        ]);
    }
} 