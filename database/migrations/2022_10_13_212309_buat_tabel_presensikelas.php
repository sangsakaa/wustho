<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('presensikelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesertakelas_id');
            $table->integer('izin')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('alfa')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presensikelas');
    }
};