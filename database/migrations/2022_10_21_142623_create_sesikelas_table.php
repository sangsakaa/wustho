<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sesikelas', function (Blueprint $table) {
            $table->id();
            $table->date('tgl');
            $table->unsignedBigInteger('kelasmi_id');
            $table->timestamps();
        });
    }
};