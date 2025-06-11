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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');
            $table->string('nama_fasilitas');
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->integer('jumlah')->nullable();
            $table->string('kondisi');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_sekolah');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            // Foreign key
            $table->foreign('id_sekolah')->references('id_sekolah')->on('sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};