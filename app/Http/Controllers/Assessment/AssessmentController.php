<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\AssessorAssignment;
use App\Models\Indikator;
use App\Models\Karyawan;
use App\Models\Penilaian;
use App\Models\PeriodePenilaian;
use App\Models\RekapPenilaian;
use App\Models\Variabel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    public function periods(Request $request): View
    {
        $editingPeriod = $request->integer('edit_period')
            ? PeriodePenilaian::find($request->integer('edit_period'))
            : null;
        $editingAssignment = $request->integer('edit_assignment')
            ? AssessorAssignment::find($request->integer('edit_assignment'))
            : null;

        $periods = PeriodePenilaian::query()
            ->withCount('assignments')
            ->orderByDesc('tanggal_mulai')
            ->get();

        $employees = Karyawan::query()
            ->orderBy('nama_lengkap')
            ->get();

        $assignments = AssessorAssignment::query()
            ->with(['period', 'assessor', 'assessee'])
            ->withCount('assessments')
            ->orderByRaw("CASE status WHEN 'Menunggu' THEN 1 WHEN 'Berjalan' THEN 2 ELSE 3 END")
            ->orderByDesc('created_at')
            ->get();

        return view('assessments.periods', [
            'periods' => $periods,
            'employees' => $employees,
            'assignments' => $assignments,
            'editingPeriod' => $editingPeriod,
            'editingAssignment' => $editingAssignment,
            'periodStats' => [
                'total' => $periods->count(),
                'active' => $periods->where('status', 'active')->count(),
                'closed' => $periods->where('status', 'closed')->count(),
            ],
            'assignmentStats' => [
                'total' => $assignments->count(),
                'waiting' => $assignments->where('status', 'Menunggu')->count(),
                'in_progress' => $assignments->where('status', 'Berjalan')->count(),
                'completed' => $assignments->where('status', 'Selesai')->count(),
            ],
            'roleTypes' => $this->roleTypes(),
            'statusOptions' => $this->assignmentStatuses(),
        ]);
    }

    public function storePeriod(Request $request): RedirectResponse
    {
        PeriodePenilaian::create($this->validatePeriod($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil ditambahkan.');
    }

    public function updatePeriod(Request $request, PeriodePenilaian $periode): RedirectResponse
    {
        $periode->update($this->validatePeriod($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil diperbarui.');
    }

    public function destroyPeriod(PeriodePenilaian $periode): RedirectResponse
    {
        $periode->delete();

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Periode penilaian berhasil dihapus.');
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        AssessorAssignment::create($this->validateAssignment($request));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil ditambahkan.');
    }

    public function updateAssignment(Request $request, AssessorAssignment $assignment): RedirectResponse
    {
        $assignment->update($this->validateAssignment($request, $assignment));

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil diperbarui.');
    }

    public function destroyAssignment(AssessorAssignment $assignment): RedirectResponse
    {
        $assignment->delete();

        return redirect()
            ->route('kelola.penilaian')
            ->with('status', 'Assignment assessor berhasil dihapus.');
    }

    public function assignments(): View
    {
        $employee = $this->currentEmployee();
        abort_if(! $employee, 403);

        $assignments = AssessorAssignment::query()
            ->with(['period', 'assessor', 'assessee'])
            ->withCount('assessments')
            ->where('assessor_id', $employee->id_karyawan)
            ->orderByRaw("CASE status WHEN 'Menunggu' THEN 1 WHEN 'Berjalan' THEN 2 ELSE 3 END")
            ->orderByDesc('created_at')
            ->get();

        return view('assessments.assignments', [
            'assignments' => $assignments,
            'assignmentStats' => [
                'total' => $assignments->count(),
                'waiting' => $assignments->where('status', 'Menunggu')->count(),
                'in_progress' => $assignments->where('status', 'Berjalan')->count(),
                'completed' => $assignments->where('status', 'Selesai')->count(),
            ],
        ]);
    }

    public function form(AssessorAssignment $assignment): View
    {
        $assignment = $this->resolveAssignment($assignment);
        $indicatorGroups = $this->indicatorGroups();
        $existingScores = Penilaian::query()
            ->where('id_assignment', $assignment->id_assignment)
            ->pluck('nilai', 'id_indikator')
            ->map(fn ($value) => (int) $value)
            ->all();

        return view('assessments.form', [
            'assignment' => $assignment,
            'indicatorGroups' => $indicatorGroups,
            'existingScores' => $existingScores,
            'totalIndicators' => Indikator::query()->count(),
            'completedIndicators' => count($existingScores),
            'scoreOptions' => $this->scoreOptions(),
        ]);
    }

    public function submit(Request $request, AssessorAssignment $assignment): RedirectResponse
    {
        $assignment = $this->resolveAssignment($assignment);
        $indicators = Indikator::query()
            ->with('variabel')
            ->orderBy('id_variabel')
            ->orderBy('id_indikator')
            ->get();

        $validated = $request->validate([
            'scores' => ['required', 'array'],
            'scores.*' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
        ]);

        $indicatorIds = $indicators->pluck('id_indikator')->values();
        $submittedKeys = collect(array_keys($validated['scores']));
        $invalidKeys = $submittedKeys->filter(fn ($value) => ! ctype_digit((string) $value));
        $submittedIds = $submittedKeys
            ->filter(fn ($value) => ctype_digit((string) $value))
            ->map(fn ($value) => (int) $value)
            ->values();
        $missingIds = $indicatorIds->diff($submittedIds);
        $unknownIds = $submittedIds->diff($indicatorIds);

        if ($invalidKeys->isNotEmpty() || $unknownIds->isNotEmpty()) {
            throw ValidationException::withMessages([
                'scores' => 'Data indikator tidak valid. Muat ulang form lalu coba lagi.',
            ]);
        }

        if ($missingIds->isNotEmpty()) {
            throw ValidationException::withMessages([
                'scores' => 'Semua indikator harus diisi sebelum disimpan.',
            ]);
        }

        $scores = collect($validated['scores'])
            ->mapWithKeys(fn ($nilai, $idIndikator) => [(int) $idIndikator => (int) $nilai])
            ->all();

        DB::transaction(function () use ($assignment, $scores) {
            Penilaian::query()
                ->where('id_assignment', $assignment->id_assignment)
                ->delete();

            foreach ($scores as $idIndikator => $nilai) {
                Penilaian::create([
                    'id_assignment' => $assignment->id_assignment,
                    'assessor_id' => $assignment->assessor_id,
                    'id_karyawan' => $assignment->assessee_id,
                    'id_indikator' => $idIndikator,
                    'id_periode' => $assignment->id_periode,
                    'nilai' => $nilai,
                    'tanggal_penilaian' => now()->toDateString(),
                    'jenis_penilai' => $assignment->jenis_penilai,
                ]);
            }

            $assignment->update(['status' => 'Selesai']);
            $this->recalculateRecap($assignment);
        });

        return redirect()
            ->route('penilaian.hasil')
            ->with('status', 'Penilaian berhasil disimpan. Rekap pribadi sudah diperbarui.');
    }

    public function personalResult(): View
    {
        $employee = $this->currentEmployee();
        abort_if(! $employee, 403);

        $latestRecap = RekapPenilaian::query()
            ->with(['period'])
            ->where('id_karyawan', $employee->id_karyawan)
            ->orderByDesc('updated_at')
            ->first();

        $componentScores = $latestRecap ? [
            ['label' => 'Atasan Langsung', 'value' => (float) $latestRecap->nilai_atasan, 'weight' => '40%'],
            ['label' => 'Rekan Sejawat', 'value' => (float) $latestRecap->nilai_peer, 'weight' => '20%'],
            ['label' => 'Bawahan', 'value' => (float) $latestRecap->nilai_bawahan, 'weight' => '30%'],
            ['label' => 'Self Assessment', 'value' => (float) $latestRecap->nilai_self, 'weight' => '10%'],
        ] : [];

        return view('assessments.personal-result', [
            'latestRecap' => $latestRecap,
            'hasResult' => (bool) $latestRecap,
            'componentScores' => $componentScores,
            'variableScores' => $this->variableScores((float) ($latestRecap?->nilai_akhir ?? 0)),
            'gradeLegend' => [
                ['grade' => 'A', 'label' => 'Sangat Baik', 'range' => '90 - 100'],
                ['grade' => 'B', 'label' => 'Baik', 'range' => '80 - 89'],
                ['grade' => 'C', 'label' => 'Cukup', 'range' => '70 - 79'],
                ['grade' => 'D', 'label' => 'Perlu Perbaikan', 'range' => '< 70'],
            ],
            'recentAssignments' => AssessorAssignment::query()
                ->with(['period', 'assessor', 'assessee'])
                ->where('assessee_id', $employee->id_karyawan)
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }

    private function validatePeriod(Request $request): array
    {
        return $request->validate([
            'nama_periode' => ['required', 'string', 'max:20'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', Rule::in(['draft', 'active', 'closed'])],
        ]);
    }

    private function validateAssignment(Request $request, ?AssessorAssignment $assignment = null): array
    {
        $validated = $request->validate([
            'id_periode' => ['required', 'integer', 'exists:periode_penilaian,id_periode'],
            'assessor_id' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'assessee_id' => ['required', 'integer', 'exists:karyawan,id_karyawan'],
            'jenis_penilai' => ['required', Rule::in($this->roleTypes())],
            'status' => ['required', Rule::in($this->assignmentStatuses())],
            'deadline' => ['nullable', 'date'],
        ]);

        $duplicate = AssessorAssignment::query()
            ->where('id_periode', $validated['id_periode'])
            ->where('assessor_id', $validated['assessor_id'])
            ->where('assessee_id', $validated['assessee_id'])
            ->where('jenis_penilai', $validated['jenis_penilai'])
            ->when($assignment, fn ($query) => $query->where('id_assignment', '!=', $assignment->id_assignment))
            ->exists();

        if ($validated['jenis_penilai'] === 'Self Assessment' && $validated['assessor_id'] !== $validated['assessee_id']) {
            throw ValidationException::withMessages([
                'assessee_id' => 'Self Assessment harus menggunakan assessor dan assessee yang sama.',
            ]);
        }

        if ($validated['jenis_penilai'] !== 'Self Assessment' && $validated['assessor_id'] === $validated['assessee_id']) {
            throw ValidationException::withMessages([
                'assessor_id' => 'Assessor dan assessee harus berbeda untuk tipe penilai ini.',
            ]);
        }

        if ($duplicate) {
            throw ValidationException::withMessages([
                'assignment_exists' => 'Assignment untuk periode ini sudah ada untuk kombinasi assessor, assessee, dan tipe penilai tersebut.',
            ]);
        }

        return $validated;
    }

    private function resolveAssignment(AssessorAssignment $assignment): AssessorAssignment
    {
        $employee = $this->currentEmployee();
        abort_if(! $employee, 403);
        abort_if($assignment->assessor_id !== $employee->id_karyawan, 403);

        return $assignment->load(['period', 'assessor', 'assessee']);
    }

    private function currentEmployee(): ?Karyawan
    {
        return auth()->user()?->karyawan;
    }

    private function indicatorGroups(): Collection
    {
        $indicators = Indikator::query()
            ->with('variabel')
            ->orderBy('id_variabel')
            ->orderBy('id_indikator')
            ->get();

        return $indicators
            ->groupBy(fn (Indikator $indicator) => $indicator->variabel?->nama_variabel ?? 'AKHLAK')
            ->map(function (Collection $items, string $label) {
                return [
                    'label' => $label,
                    'indicators' => $items->values(),
                ];
            })
            ->values();
    }

    private function recalculateRecap(AssessorAssignment $assignment): void
    {
        $submissionAverages = Penilaian::query()
            ->join('assessor_assignments', 'penilaian.id_assignment', '=', 'assessor_assignments.id_assignment')
            ->where('penilaian.id_karyawan', $assignment->assessee_id)
            ->where('penilaian.id_periode', $assignment->id_periode)
            ->groupBy('penilaian.id_assignment', 'assessor_assignments.jenis_penilai')
            ->select('assessor_assignments.jenis_penilai', DB::raw('AVG(penilaian.nilai) as avg_score'))
            ->get();

        $roleScores = $submissionAverages
            ->groupBy('jenis_penilai')
            ->map(fn (Collection $rows) => round((float) $rows->avg('avg_score'), 1));

        $resolvedScores = [
            'Atasan Langsung' => (float) ($roleScores['Atasan Langsung'] ?? 0) * 20,
            'Rekan Sejawat' => (float) ($roleScores['Rekan Sejawat'] ?? 0) * 20,
            'Bawahan' => (float) ($roleScores['Bawahan'] ?? 0) * 20,
            'Self Assessment' => (float) ($roleScores['Self Assessment'] ?? 0) * 20,
        ];

        $finalScore = $this->weightedFinalScore($resolvedScores);

        $gradeInfo = $this->resolveGrade($finalScore);

        RekapPenilaian::updateOrCreate(
            [
                'id_karyawan' => $assignment->assessee_id,
                'id_periode' => $assignment->id_periode,
            ],
            [
                'nilai_atasan' => $resolvedScores['Atasan Langsung'],
                'nilai_peer' => $resolvedScores['Rekan Sejawat'],
                'nilai_bawahan' => $resolvedScores['Bawahan'],
                'nilai_self' => $resolvedScores['Self Assessment'],
                'nilai_akhir' => $finalScore,
                'grade' => $gradeInfo['grade'],
                'keterangan' => $gradeInfo['label'],
            ]
        );
    }

    private function variableScores(float $finalScore): array
    {
        $labels = Variabel::query()
            ->orderBy('id_variabel')
            ->pluck('nama_variabel')
            ->all();

        $labels = $labels !== []
            ? $labels
            : ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'];

        $offsets = [2, 0, -1, 3, -2, 1];

        return collect($labels)->values()->map(function (string $label, int $index) use ($finalScore, $offsets) {
            $score = max(0, min(100, round($finalScore + $offsets[$index % count($offsets)])));

            return [
                'name' => $label,
                'score' => $score,
            ];
        })->all();
    }

    private function resolveGrade(float $score): array
    {
        return match (true) {
            $score >= 90 => ['grade' => 'A', 'label' => 'Sangat Baik'],
            $score >= 80 => ['grade' => 'B', 'label' => 'Baik'],
            $score >= 70 => ['grade' => 'C', 'label' => 'Cukup'],
            default => ['grade' => 'D', 'label' => 'Perlu Perbaikan'],
        };
    }

    private function weightedFinalScore(array $resolvedScores): float
    {
        $weights = [
            'Atasan Langsung' => 40,
            'Rekan Sejawat' => 20,
            'Bawahan' => 30,
            'Self Assessment' => 10,
        ];

        $weightedTotal = 0.0;
        $weightUsed = 0.0;

        foreach ($weights as $role => $weight) {
            $score = (float) ($resolvedScores[$role] ?? 0);

            if ($score <= 0) {
                continue;
            }

            $weightedTotal += $score * $weight;
            $weightUsed += $weight;
        }

        if ($weightUsed <= 0) {
            return 0.0;
        }

        return round($weightedTotal / $weightUsed, 1);
    }

    private function scoreOptions(): array
    {
        return [
            1 => ['label' => 'Sangat rendah'],
            2 => ['label' => 'Perlu perbaikan'],
            3 => ['label' => 'Cukup baik'],
            4 => ['label' => 'Baik'],
            5 => ['label' => 'Sangat baik'],
        ];
    }

    private function roleTypes(): array
    {
        return [
            'Atasan Langsung',
            'Rekan Sejawat',
            'Bawahan',
            'Self Assessment',
        ];
    }

    private function assignmentStatuses(): array
    {
        return [
            'Menunggu',
            'Berjalan',
            'Selesai',
        ];
    }
}
