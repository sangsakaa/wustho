<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sesi_perangkat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('sesi_perangkat');
    }
};
