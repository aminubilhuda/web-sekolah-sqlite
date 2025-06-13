<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ppdbs', function (Blueprint $table) {
            $table->id('id_ppdb');
            $table->string('nomor_registrasi')->unique();
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->string('nik')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('kode_pos')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('telepon_ayah')->nullable();
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable(); 
            $table->string('telepon_ibu')->nullable();
            $table->string('sekolah_asal');
            $table->unsignedBigInteger('id_jurusan');
            $table->enum('gelombang', ['1', '2', '3']);
            $table->enum('jalur', ['Reguler', 'Prestasi', 'Tidak Mampu']);
            $table->text('prestasi')->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak', 'Cadangan'])->default('Menunggu');
            $table->string('foto')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('skhun')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('akta_kelahiran')->nullable();
            $table->string('surat_prestasi')->nullable();
            $table->string('surat_tidak_mampu')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdbs');
    }
};