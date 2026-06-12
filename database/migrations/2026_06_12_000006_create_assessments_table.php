<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->increments('id_penilaian');
            $table->unsignedInteger('id_karyawan');
            $table->unsignedInteger('id_indikator');
            $table->unsignedInteger('id_periode');
            $table->unsignedTinyInteger('nilai');
            $table->date('tanggal_penilaian');
            $table->string('jenis_penilai', 20);
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->cascadeOnDelete();
            $table->foreign('id_indikator')->references('id_indikator')->on('indikator')->cascadeOnDelete();
            $table->foreign('id_periode')->references('id_periode')->on('periode_penilaian')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
