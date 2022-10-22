<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensikelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesikelas_id');
            $table->unsignedBigInteger('pesertakelas_id');
            $table->string('keterangan');
            $table->string('alasan');
            $table->timestamps();
        });
    }
};
