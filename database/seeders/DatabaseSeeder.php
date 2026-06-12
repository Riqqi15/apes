<?php

namespace Database\Seeders;

use App\Models\Direktur;
use App\Models\Hr;
use App\Models\Indikator;
use App\Models\Karyawan;
use App\Models\PeriodePenilaian;
use App\Models\RekapPenilaian;
use App\Models\Skala;
use App\Models\User;
use App\Models\Variabel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $hrUser = User::create([
            'username' => 'hr',
            'email' => 'hr@apes.test',
            'password' => Hash::make('password'),
            'akses_user' => 'hr',
        ]);

        $direkturUser = User::create([
            'username' => 'direktur',
            'email' => 'direktur@apes.test',
            'password' => Hash::make('password'),
            'akses_user' => 'direktur',
        ]);

        $karyawanUser = User::create([
            'username' => 'karyawan',
            'email' => 'karyawan@apes.test',
            'password' => Hash::make('password'),
            'akses_user' => 'karyawan',
        ]);

        Hr::create([
            'nama_hr' => 'Rina Pratama',
            'jabatan' => 'HR Manager',
            'email' => 'hr@apes.test',
            'id_users' => $hrUser->id_users,
        ]);

        Direktur::create([
            'nama_direktur' => 'Budi Santoso',
            'jabatan' => 'Direktur Utama',
            'email' => 'direktur@apes.test',
            'id_users' => $direkturUser->id_users,
        ]);

        $karyawan = Karyawan::create([
            'id_users' => $karyawanUser->id_users,
            'nip' => 'EMP-0003',
            'nama_lengkap' => 'Andi Wijaya',
            'no_hp' => '08123456789',
            'jabatan' => 'Staf Operasional',
            'tanggal_lahir' => '1995-01-10',
            'alamat' => 'Jakarta',
        ]);

        $periode = PeriodePenilaian::create([
            'nama_periode' => '2026-S1',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'status' => 'active',
        ]);

        foreach (['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'] as $name) {
            $variabel = Variabel::create(['nama_variabel' => $name]);

            Indikator::create([
                'id_variabel' => $variabel->id_variabel,
                'nama_indikator' => $name . ' indikator 1',
                'nama_variabel_penilaian' => $name,
            ]);
        }

        foreach ([
            ['A', '0-54', 'A', 'Sangat Kurang'],
            ['B', '55-69', 'B', 'Kurang'],
            ['C', '70-79', 'C', 'Cukup'],
            ['D', '80-89', 'D', 'Baik'],
            ['E', '90-100', 'E', 'Sangat Baik'],
        ] as [$skala, $interval, $grade, $keterangan]) {
            Skala::create(compact('skala', 'interval', 'grade', 'keterangan'));
        }

        RekapPenilaian::create([
            'id_karyawan' => $karyawan->id_karyawan,
            'nilai_atasan' => 85,
            'nilai_peer' => 80,
            'nilai_bawahan' => 82,
            'nilai_self' => 90,
            'nilai_akhir' => 84.3,
            'grade' => 'D',
            'keterangan' => 'Baik',
        ]);
    }
}
