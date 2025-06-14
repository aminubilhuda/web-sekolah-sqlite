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
        Schema::create('galeris', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->text('gambar')->nullable();
            $table->enum('kategori', ['foto', 'video'])->default('foto');
            $table->string('url_video')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};