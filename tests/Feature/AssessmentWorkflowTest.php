<?php

namespace Tests\Feature;

use App\Models\AssessorAssignment;
use App\Models\Indikator;
use App\Models\Karyawan;
use App\Models\PeriodePenilaian;
use App\Models\RekapPenilaian;
use App\Models\User;
use App\Models\Variabel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AssessmentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_assignment_submission_updates_assignment_and_recap(): void
    {
        $assessorUser = User::create([
            'username' => 'assessor',
            'email' => 'assessor@example.com',
            'password' => Hash::make('password'),
            'akses_user' => 'karyawan',
        ]);

        $assessor = Karyawan::create([
            'id_users' => $assessorUser->id_users,
            'nip' => 'EMP-001',
            'departemen' => 'HR',
            'nama_lengkap' => 'Assessor APES',
            'jabatan' => 'Staff',
        ]);

        $assessee = Karyawan::create([
            'nip' => 'EMP-002',
            'departemen' => 'Finance',
            'nama_lengkap' => 'Assessee APES',
            'jabatan' => 'Analyst',
        ]);

        $period = PeriodePenilaian::create([
            'nama_periode' => 'Triwulan II 2026',
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-30',
            'status' => 'active',
        ]);

        $variable = Variabel::create([
            'nama_variabel' => 'Amanah',
        ]);

        $indicator = Indikator::create([
            'id_variabel' => $variable->id_variabel,
            'nama_indikator' => 'Bertanggung jawab',
            'nama_variabel_penilaian' => 'Amanah',
        ]);

        $assignment = AssessorAssignment::create([
            'id_periode' => $period->id_periode,
            'assessor_id' => $assessor->id_karyawan,
            'assessee_id' => $assessee->id_karyawan,
            'jenis_penilai' => 'Atasan Langsung',
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($assessorUser)->post(route('penilaian.submit', $assignment), [
            'scores' => [
                $indicator->id_indikator => 5,
            ],
        ]);

        $response->assertRedirect(route('penilaian.hasil'));

        $this->assertDatabaseHas('penilaian', [
            'id_assignment' => $assignment->id_assignment,
            'assessor_id' => $assessor->id_karyawan,
            'id_karyawan' => $assessee->id_karyawan,
            'id_periode' => $period->id_periode,
            'id_indikator' => $indicator->id_indikator,
            'nilai' => 5,
            'jenis_penilai' => 'Atasan Langsung',
        ]);

        $this->assertSame('Selesai', $assignment->fresh()->status);

        $recap = RekapPenilaian::query()
            ->where('id_karyawan', $assessee->id_karyawan)
            ->where('id_periode', $period->id_periode)
            ->firstOrFail();

        $this->assertSame(100.0, (float) $recap->nilai_atasan);
        $this->assertEqualsWithDelta(100.0, (float) $recap->nilai_akhir, 0.001);
    }

    public function test_duplicate_assignment_is_rejected_with_specific_message(): void
    {
        $hrUser = User::create([
            'username' => 'hr-user',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'akses_user' => 'hr',
        ]);

        $assessor = Karyawan::create([
            'nip' => 'EMP-010',
            'departemen' => 'HR',
            'nama_lengkap' => 'Rosi',
            'jabatan' => 'Manager',
        ]);

        $assessee = Karyawan::create([
            'nip' => 'EMP-011',
            'departemen' => 'Finance',
            'nama_lengkap' => 'Riyadh',
            'jabatan' => 'Analyst',
        ]);

        $period = PeriodePenilaian::create([
            'nama_periode' => 'Triwulan II 2026',
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-30',
            'status' => 'active',
        ]);

        AssessorAssignment::create([
            'id_periode' => $period->id_periode,
            'assessor_id' => $assessor->id_karyawan,
            'assessee_id' => $assessee->id_karyawan,
            'jenis_penilai' => 'Rekan Sejawat',
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($hrUser)->post(route('kelola.penilaian.assignments.store'), [
            'id_periode' => $period->id_periode,
            'assessor_id' => $assessor->id_karyawan,
            'assessee_id' => $assessee->id_karyawan,
            'jenis_penilai' => 'Rekan Sejawat',
            'status' => 'Menunggu',
        ]);

        $response->assertSessionHasErrors([
            'assignment_exists' => 'Assignment untuk periode ini sudah ada untuk kombinasi assessor, assessee, dan tipe penilai tersebut.',
        ]);
    }
}
