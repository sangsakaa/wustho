<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensiguru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_kelas_guru_id');
            $table->unsignedBigInteger('daftar_jadwal_id');
            $table->string('keterangan');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('absensiguru');
    }
};
