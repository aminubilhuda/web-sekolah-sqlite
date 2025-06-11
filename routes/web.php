<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\HubunganIndustriController;
use App\Http\Controllers\ProfileController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Route untuk Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Route untuk Jurusan
Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/{slug}', [JurusanController::class, 'show'])->name('jurusan.show');

// Route untuk Hubungan Industri
Route::get('/hubungan-industri', [HubunganIndustriController::class, 'index'])->name('hubungan-industri.index');

// Route untuk Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');