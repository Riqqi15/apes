<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_penilaian', function (Blueprint $table) {
            $table->increments('id_rekap');
            $table->unsignedInteger('id_karyawan');
            $table->double('nilai_atasan')->default(0);
            $table->double('nilai_peer')->default(0);
            $table->double('nilai_bawahan')->default(0);
            $table->double('nilai_self')->default(0);
            $table->double('nilai_akhir')->default(0);
            $table->char('grade', 1)->nullable();
            $table->string('keterangan', 40)->nullable();
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_penilaian');
    }
};
