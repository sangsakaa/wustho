<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nig', function (Blueprint $table) {
            $table->id();
            $table->string('nig');
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('jenjang_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nig');
    }
};
