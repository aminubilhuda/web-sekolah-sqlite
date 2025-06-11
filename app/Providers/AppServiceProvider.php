<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Sekolah;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set nama aplikasi berdasarkan sekolah aktif
        if (Session::has('id_sekolah_aktif')) {
            $sekolah = Sekolah::find(session('id_sekolah_aktif'));
            if ($sekolah) {
                config(['app.name' => $sekolah->nama_sekolah]);
                Filament::setBrandName($sekolah->nama_sekolah);
            }
        }

        // Share data sekolah aktif ke semua view
        View::composer('*', function ($view) {
            if (Session::has('id_sekolah_aktif')) {
                $sekolah = Sekolah::find(session('id_sekolah_aktif'));
                $view->with('sekolah_aktif', $sekolah);
            } else {
                $view->with('sekolah_aktif', null);
            }
        });
    }
}
