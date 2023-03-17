<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daftar_nominasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nominasi_id');
            $table->unsignedBigInteger('pesertakelas_id');
            $table->string('nomor_ujian')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('daftar_nominasi');
    }
};
