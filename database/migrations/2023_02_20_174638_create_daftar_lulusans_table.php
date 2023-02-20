<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daftar_lulusan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lulusan_id');
            $table->unsignedBigInteger('pesertakelas_id');
            $table->string('nomor_ijazah')->nullable();
            $table->timestamps();
        });
    }
};
