<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kalender_pendidikans', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kegiatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->enum('kategori', [
                'Pembelajaran',
                'Ujian',
                'Libur',
                'Rapat',
                'Kegiatan Sekolah',
                'Lainnya'
            ])->default('Pembelajaran');

            $table->text('keterangan')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }
};
