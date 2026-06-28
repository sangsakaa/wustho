<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensikelas', function (Blueprint $table) {

            $table->unique(
                ['sesikelas_id', 'pesertakelas_id'],
                'uk_absensi'
            );
        });
    }

    public function down(): void
    {
        Schema::table('absensikelas', function (Blueprint $table) {

            $table->dropUnique('uk_absensi');
        });
    }
};
