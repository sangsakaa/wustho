<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transkip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mapel_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('jenis_ujian_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('transkip');
    }
};
