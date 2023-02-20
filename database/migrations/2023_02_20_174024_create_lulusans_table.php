<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lulusan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_kelulusan');
            $table->timestamps();
        });
    }
};
