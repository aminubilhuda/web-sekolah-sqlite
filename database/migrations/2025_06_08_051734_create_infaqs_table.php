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
        Schema::create('infaqs', function (Blueprint $table) {
            $table->id('id_infaq');
            $table->unsignedBigInteger('id_kelas')->nullable(); // relasi ke siswa jika perlu
            $table->string('nama_penyetor')->nullable();
            $table->date('tanggal');
            $table->decimal('jumlah', 12, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaqs');
    }
};