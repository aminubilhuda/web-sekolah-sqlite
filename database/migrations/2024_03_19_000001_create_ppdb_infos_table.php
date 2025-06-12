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
        Schema::create('ppdb_infos', function (Blueprint $table) {
            $table->id('id_info');
            $table->string('judul');
            $table->text('konten');
            $table->enum('kategori', ['syarat', 'gelombang', 'jadwal', 'biaya', 'seragam', 'spp']);
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_infos');
    }
}; 