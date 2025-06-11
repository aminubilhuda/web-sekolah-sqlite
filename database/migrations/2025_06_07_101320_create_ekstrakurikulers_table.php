<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id('id_ekstrakurikuler');
            $table->string('nama_ekstrakurikuler');
            $table->text('deskripsi')->nullable();
            $table->string('pembina')->nullable();
            $table->string('hari_kegiatan')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_sekolah');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikulers');
    }
}; 