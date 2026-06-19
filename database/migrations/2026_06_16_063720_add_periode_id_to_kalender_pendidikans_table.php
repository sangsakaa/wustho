<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kalender_pendidikans', function (Blueprint $table) {

            $table->unsignedBigInteger('periode_id')
                ->nullable()
                ->after('id');

            $table->foreign('periode_id')
                ->references('id')
                ->on('periode')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kalender_pendidikans', function (Blueprint $table) {

            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
        });
    }
};
