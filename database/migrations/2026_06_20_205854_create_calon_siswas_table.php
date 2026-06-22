<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calon_siswas', function (Blueprint $table) {
            $table->id();

            // API IDENTIFIER
            $table->bigInteger('api_id')->nullable()->index();

            // JENJANG
            $table->bigInteger('jenjang_id')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('jenjang_title')->nullable();

            // PENDAFTARAN
            $table->integer('nomor_pendaftaran')->nullable();

            // IDENTITAS
            $table->string('nama')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('nik')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('no_kip')->nullable();
            $table->string('npsn')->nullable();
            $table->string('alumni')->nullable();

            // LAHIR
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // KELUARGA
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();

            // AGAMA & NEGARA
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->nullable();

            // PENDIDIKAN
            $table->string('rencana_pendidikan')->nullable();

            // ALAMAT
            $table->text('alamat_jalan')->nullable();
            $table->string('nama_dusun')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kode_pos')->nullable();

            // FISIK
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('lingkar_kepala')->nullable();

            // STATUS
            $table->string('status')->nullable();
            $table->string('no_registrasi_akta')->nullable();

            // RELASI
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('tapel_id')->nullable();
            $table->bigInteger('kelurahan_desa')->nullable();
            $table->bigInteger('riwayat_kesehatan')->nullable();
            $table->bigInteger('kebutuhan_khusus')->nullable();

            // SEKOLAH
            $table->string('asal_sekolah')->nullable();

            // META
            $table->text('user_agent')->nullable();
            $table->string('ip')->nullable();

            // RAW API
            $table->longText('data_api')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_siswas');
    }
};
