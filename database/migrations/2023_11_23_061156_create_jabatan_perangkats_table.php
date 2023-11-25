<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jabatan_perangkat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perangkat_id');
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('jabatan_perangkat');
    }
};
