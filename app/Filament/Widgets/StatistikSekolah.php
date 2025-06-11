<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Berita;
use App\Models\Ptk;
use App\Models\Hubin;

class StatistikSekolah extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Siswa', Siswa::count()),
            Card::make('Jumlah Kelas', Kelas::count()),
            Card::make('Jumlah Jurusan', Jurusan::count()),
            Card::make('Jumlah Berita', Berita::count()),
            Card::make('Jumlah PTK', Ptk::count()),
            Card::make('Jumlah Hubungan Industri', Hubin::count()),
        ];
    }
}