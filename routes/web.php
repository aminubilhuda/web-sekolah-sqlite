<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\HubunganIndustriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\KontakController;

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

// Route untuk Chat
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/history', [ChatController::class, 'getChatHistory'])->name('chat.history');

// Route untuk Alumni
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{id}', [AlumniController::class, 'show'])->name('alumni.show');

// Route untuk Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');