<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE kalender_pendidikans
            MODIFY kategori ENUM(
                'Pembelajaran',
                'Ujian',
                'Libur',
                'Hari Besar Nasional',
                'Hari Besar Keagamaan',
                'Peringatan Internasional',
                'Rapat',
                'Kegiatan Sekolah',
                'Ekstrakurikuler',
                'PPDB',
                'Kelulusan',
                'Asesmen',
                'Lainnya'
            ) NOT NULL DEFAULT 'Pembelajaran'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE kalender_pendidikans
            MODIFY kategori ENUM(
                'Pembelajaran',
                'Ujian',
                'Libur',
                'Rapat',
                'Kegiatan Sekolah',
                'Lainnya'
            ) NOT NULL DEFAULT 'Pembelajaran'
        ");
    }
};

