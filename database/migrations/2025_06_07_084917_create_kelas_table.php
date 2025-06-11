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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_kelas');
            $table->string('kode_kelas')->unique();
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_wali_kelas')->nullable();
            $table->integer('kapasitas')->default(36);
            $table->integer('jumlah_siswa')->default(0);
            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusans')->onDelete('cascade');
            $table->foreign('id_wali_kelas')->references('id_ptk')->on('ptks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};