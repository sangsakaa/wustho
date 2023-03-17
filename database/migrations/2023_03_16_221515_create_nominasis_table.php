<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nominasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelasmi_id');
            $table->unsignedBigInteger('periode_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nominasi');
    }
};
