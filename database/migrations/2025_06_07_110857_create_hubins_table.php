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
        Schema::create('hubins', function (Blueprint $table) {
            $table->id('id_hubin');
            $table->string('nama_perusahaan');
            $table->string('bidang_usaha');
            $table->text('alamat');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('nama_pic');
            $table->string('jabatan_pic');
            $table->string('telepon_pic')->nullable();
            $table->string('email_pic')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('id_sekolah');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubins');
    }
};