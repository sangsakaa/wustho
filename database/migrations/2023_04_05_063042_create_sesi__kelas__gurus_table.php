<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sesi_kelas_guru', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('kelasmi_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('sesi_kelas_guru');
    }
};
