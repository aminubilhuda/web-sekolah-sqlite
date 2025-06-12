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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id('id_sekolah');
            $table->string('npsn')->unique();
            $table->string('nama_sekolah');
            $table->enum('status_sekolah', ['Negeri', 'Swasta']);
            $table->text('alamat_sekolah')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->string('telepon_sekolah')->nullable();
            $table->string('website_sekolah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('sambutan_kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('motto')->nullable();
            $table->string('logo_sekolah')->nullable();
            $table->string('icon_sekolah')->nullable();
            $table->string('akreditasi')->nullable();
            $table->year('tahun_berdiri')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('facebook_sekolah')->nullable();
            $table->string('youtube_sekolah')->nullable();
            $table->string('tiktok_sekolah')->nullable();
            $table->string('instagram_sekolah')->nullable();
            $table->string('whatsapp_sekolah')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->text('google_maps')->nullable();
            $table->enum('jenis_sekolah', ['SMA', 'SMK', 'SLB']);
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};