<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelanggaran');
            $table->string('nama_pelanggaran');
            $table->string('type_pelanggaran');
            $table->integer('poin_pelanggaran');
            $table->timestamps();
        });
    }
};
