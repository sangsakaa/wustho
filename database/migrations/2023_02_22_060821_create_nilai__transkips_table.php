<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_transkip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daftar_lulusan_id');
            $table->unsignedBigInteger('transkip_id');
            $table->integer('nilai_akhir');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nilai_transkip');
    }
};
