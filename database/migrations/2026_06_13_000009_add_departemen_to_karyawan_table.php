<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('departemen', 100)->nullable()->after('nip');
        });
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('departemen');
        });
    }
};
