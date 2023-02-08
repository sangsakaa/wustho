<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->string('status')->nullable()->after('tanggal_masuk')->default('Aktif');
        });
    }
};
