<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_users');
            $table->string('username', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('akses_user', 20);
            $table->timestamps();
        });

        Schema::create('hr', function (Blueprint $table) {
            $table->increments('id_hr');
            $table->string('nama_hr', 100);
            $table->string('jabatan', 50);
            $table->string('email', 100);
            $table->unsignedInteger('id_users')->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->nullOnDelete();
        });

        Schema::create('direktur', function (Blueprint $table) {
            $table->increments('id_direktur');
            $table->string('nama_direktur', 100);
            $table->string('jabatan', 50);
            $table->string('email', 100);
            $table->unsignedInteger('id_users')->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->nullOnDelete();
        });

        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id_karyawan');
            $table->unsignedInteger('id_users')->nullable();
            $table->string('nip', 40);
            $table->string('nama_lengkap', 100);
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id_users')->on('users')->nullOnDelete();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('direktur');
        Schema::dropIfExists('hr');
        Schema::dropIfExists('users');
    }
};
