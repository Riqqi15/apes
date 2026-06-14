<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessor_assignments', function (Blueprint $table) {
            $table->increments('id_assignment');
            $table->unsignedInteger('id_periode');
            $table->unsignedInteger('assessor_id');
            $table->unsignedInteger('assessee_id');
            $table->string('jenis_penilai', 30);
            $table->string('status', 20)->default('Menunggu');
            $table->date('deadline')->nullable();
            $table->timestamps();

            $table->foreign('id_periode')->references('id_periode')->on('periode_penilaian')->cascadeOnDelete();
            $table->foreign('assessor_id')->references('id_karyawan')->on('karyawan')->cascadeOnDelete();
            $table->foreign('assessee_id')->references('id_karyawan')->on('karyawan')->cascadeOnDelete();
            $table->unique(['id_periode', 'assessor_id', 'assessee_id', 'jenis_penilai'], 'assignment_unique_pair');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessor_assignments');
    }
};
