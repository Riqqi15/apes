<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->unsignedInteger('id_assignment')->nullable()->after('id_periode');
            $table->unsignedInteger('assessor_id')->nullable()->after('id_assignment');

            $table->foreign('id_assignment')->references('id_assignment')->on('assessor_assignments')->nullOnDelete();
            $table->foreign('assessor_id')->references('id_karyawan')->on('karyawan')->nullOnDelete();
            $table->index(['id_assignment', 'assessor_id'], 'penilaian_assignment_assessor_index');
        });
    }

    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropIndex('penilaian_assignment_assessor_index');
            $table->dropForeign(['id_assignment']);
            $table->dropForeign(['assessor_id']);
            $table->dropColumn(['id_assignment', 'assessor_id']);
        });
    }
};
