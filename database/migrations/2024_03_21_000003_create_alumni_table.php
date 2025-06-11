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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->year('tahun_lulus');
            $table->unsignedBigInteger('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusans')->onDelete('cascade');
            $table->text('testimoni')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['bekerja', 'kuliah', 'wirausaha'])->default('bekerja');
            $table->string('pekerjaan')->nullable();
            $table->string('perguruan_tinggi')->nullable();
            $table->string('jurusan_kuliah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
}; 