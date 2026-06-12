<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variabel', function (Blueprint $table) {
            $table->increments('id_variabel');
            $table->string('nama_variabel', 50);
            $table->timestamps();
        });

        Schema::create('indikator', function (Blueprint $table) {
            $table->increments('id_indikator');
            $table->unsignedInteger('id_variabel');
            $table->string('nama_indikator', 255);
            $table->string('nama_variabel_penilaian', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_variabel')->references('id_variabel')->on('variabel')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator');
        Schema::dropIfExists('variabel');
    }
};
