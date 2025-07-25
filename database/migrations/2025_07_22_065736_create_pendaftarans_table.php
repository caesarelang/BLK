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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelatihan')->constrained('pelatihan', 'id_pelatihan');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('nik')->unique();
            $table->date('tanggal_lahir')->nullable();
            $table->string('url_foto_ijasah')->nullable();
            $table->string('url_foto_ktp')->nullable();
            $table->enum('status_verifikasi', ['Terverifikasi', 'Menunggu Verifikasi', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
