<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('periode', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
        });
    }
};
