<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensiasrama', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesiasrama_id');
            $table->unsignedBigInteger('pesertaasrama_id');
            $table->string('keterangan');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensiasrama');
    }
};
