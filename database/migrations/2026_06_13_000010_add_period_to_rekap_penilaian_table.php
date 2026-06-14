<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekap_penilaian', function (Blueprint $table) {
            $table->unsignedInteger('id_periode')->nullable()->after('id_karyawan');
            $table->foreign('id_periode')->references('id_periode')->on('periode_penilaian')->nullOnDelete();
        });

        $defaultPeriodId = DB::table('periode_penilaian')->orderBy('id_periode')->value('id_periode');

        if ($defaultPeriodId) {
            DB::table('rekap_penilaian')
                ->whereNull('id_periode')
                ->update(['id_periode' => $defaultPeriodId]);
        }
    }

    public function down(): void
    {
        Schema::table('rekap_penilaian', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
    }
};
