<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skala', function (Blueprint $table) {
            $table->increments('id_skala');
            $table->string('skala', 20);
            $table->string('interval', 20);
            $table->char('grade', 1);
            $table->string('keterangan', 40)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skala');
    }
};
