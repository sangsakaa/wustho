<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('sesikelas', 'status')) {

            Schema::table('sesikelas', function (Blueprint $table) {

                $table->enum('status', ['open', 'close'])
                    ->default('open')
                    ->after('tgl');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sesikelas', 'status')) {

            Schema::table('sesikelas', function (Blueprint $table) {

                $table->dropColumn('status');
            });
        }
    }
};
