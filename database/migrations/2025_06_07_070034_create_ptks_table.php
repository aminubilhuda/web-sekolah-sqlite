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
        Schema::create('ptks', function (Blueprint $table) {
            $table->id('id_ptk');
            $table->string('nip')->unique()->nullable();
            $table->string('nuptk')->unique()->nullable();
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('kode_pos')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->enum('status_kepegawaian', ['PNS', 'GTT', 'PTT']);
            $table->enum('jenis_ptk', [
                'Guru',
                'Tenaga Administrasi',
                'Tenaga Laboratorium',
                'Tenaga Perpustakaan'
            ]);
            $table->enum('tugas_tambahan', [
                'Kepala Sekolah',
                'Wakil Kepala Sekolah',
                'Tidak Ada'
            ])->default('Tidak Ada');
            $table->enum('status_tugas_tambahan', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->string('foto')->nullable();
            $table->string('kode_wilayah');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptks');
    }
};