<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('kelasmi_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
};
