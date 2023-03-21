<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lulusan', function (Blueprint $table) {
            $table->unsignedBigInteger('kelasmi_id')->nullable();
        });
    }
    public function down()
    {
        Schema::table('lulusan', function (Blueprint $table) {
            $table->dropColumn('kelasmi_id');
        });
    }
};
