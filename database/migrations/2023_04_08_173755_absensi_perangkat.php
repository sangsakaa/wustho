<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensi_perangkat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_perangkat_id');
            $table->unsignedBigInteger('perangkat_id');
            $table->string('keterangan');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('absensi_perangkat');
    }
};
