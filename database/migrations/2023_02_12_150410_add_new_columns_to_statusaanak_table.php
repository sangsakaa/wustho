<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('statusanak', function (Blueprint $table) {
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('nomor_hp_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nomor_hp_ibu')->nullable();
        });
    }
    public function down()
    {
        Schema::table('statusanak', function (Blueprint $table) {
            $table->dropColumn('nama_ayah');
            $table->dropColumn('pekerjaan_ayah');
            $table->dropColumn('pekerjaan_ibu');
            $table->dropColumn('nomor_hp_ayah');
            $table->dropColumn('nama_ibu');
            $table->dropColumn('nomor_hp_ibu');
        });
    }
};
