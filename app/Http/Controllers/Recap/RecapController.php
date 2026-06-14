<?php

namespace App\Http\Controllers\Recap;

use App\Http\Controllers\Controller;
use App\Models\PeriodePenilaian;
use App\Models\RekapPenilaian;
use App\Models\Variabel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RecapController extends Controller
{
    public function index(Request $request): View
    {
        $selectedPeriod = (string) $request->string('period');
        $selectedDepartment = (string) $request->string('department');
        $allRows = collect($this->recapRows());

        $rows = $allRows
            ->when($selectedPeriod !== '', fn ($collection) => $collection->where('period_id', (int) $selectedPeriod))
            ->when($selectedDepartment !== '', fn ($collection) => $collection->where('department', $selectedDepartment))
            ->map(function (array $row) {
                $row['print_url'] = URL::signedRoute('laporan.cetak', ['id' => $row['id']]);

                return $row;
            })
            ->values();

        $summaryCards = [
            ['title' => 'Karyawan Dinilai', 'value' => (string) $rows->count()],
            ['title' => 'Rata-rata Akhir', 'value' => number_format((float) $rows->avg('final_raw'), 1)],
            ['title' => 'Grade A', 'value' => (string) $rows->where('grade', 'A')->count()],
            ['title' => 'Perlu Follow Up', 'value' => (string) $rows->filter(fn (array $row) => $row['final_raw'] < 80)->count()],
        ];

        return view('recaps.index', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Filter penilaian per periode dan departemen sebelum masuk detail hasil.',
            'periods' => $this->periodOptions(),
            'summaryCards' => $summaryCards,
            'rows' => $rows->all(),
            'departments' => $allRows->pluck('department')->filter()->unique()->sort()->values()->all(),
            'filters' => [
                'period' => $selectedPeriod,
                'department' => $selectedDepartment,
            ],
            'resultCount' => $rows->count(),
        ]);
    }

    public function show($id = null): View
    {
        $row = collect($this->recapRows())->firstWhere('id', (int) $id);

        abort_if(! $row, 404);

        return view('recaps.show', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Detail lengkap komponen penilaian dan hasil 360.',
            'periods' => $this->periodOptions(),
            'employee' => [
                'name' => $row['name'],
                'nip' => $row['nip'],
                'department' => $row['department'],
                'position' => $row['position'],
                'period' => $row['period'],
                'finalScore' => $row['final'],
                'grade' => $row['grade'],
            ],
            'variableScores' => $row['variables'],
            'componentScores' => [
                ['label' => 'Atasan Langsung', 'value' => $row['atasan'], 'weight' => '40%'],
                ['label' => 'Rekan Sejawat', 'value' => $row['rekan'], 'weight' => '20%'],
                ['label' => 'Bawahan', 'value' => $row['bawahan'], 'weight' => '30%'],
                ['label' => 'Self Assessment', 'value' => $row['self'], 'weight' => '10%'],
            ],
            'editUrl' => route('rekap.edit', $row['id']),
        ]);
    }

    public function edit(int $id): View
    {
        $rekap = RekapPenilaian::query()
            ->with(['karyawan', 'period'])
            ->findOrFail($id);

        $preview = $this->buildRecapRow($rekap, $this->variableLabels(), $this->fallbackPeriodLabel());

        return view('recaps.edit', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Perbarui komponen nilai sebelum dibawa ke laporan final.',
            'periods' => $this->periodOptions(),
            'rekap' => $rekap,
            'preview' => $preview,
            'employee' => $rekap->karyawan,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $rekap = RekapPenilaian::query()->findOrFail($id);

        $validated = $request->validate([
            'nilai_atasan' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_peer' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_bawahan' => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_self' => ['required', 'numeric', 'min:0', 'max:100'],
            'id_periode' => ['nullable', Rule::exists('periode_penilaian', 'id_periode')],
        ]);

        $finalScore = round(
            ((float) $validated['nilai_atasan'] * 0.40) +
            ((float) $validated['nilai_peer'] * 0.20) +
            ((float) $validated['nilai_bawahan'] * 0.30) +
            ((float) $validated['nilai_self'] * 0.10),
            1
        );

        $gradeInfo = $this->resolveGrade($finalScore);

        $rekap->update([
            'id_periode' => $validated['id_periode'] ?: $rekap->id_periode,
            'nilai_atasan' => $validated['nilai_atasan'],
            'nilai_peer' => $validated['nilai_peer'],
            'nilai_bawahan' => $validated['nilai_bawahan'],
            'nilai_self' => $validated['nilai_self'],
            'nilai_akhir' => $finalScore,
            'grade' => $gradeInfo['grade'],
            'keterangan' => $gradeInfo['label'],
        ]);

        return redirect()
            ->route('rekap.show', $rekap->id_rekap)
            ->with('status', 'Nilai rekap berhasil diperbarui.');
    }

    public function recapRows(): array
    {
        $variableLabels = $this->variableLabels();
        $fallbackPeriod = $this->fallbackPeriodLabel();

        return RekapPenilaian::query()
            ->with(['karyawan', 'period'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(fn (RekapPenilaian $rekap) => $this->buildRecapRow($rekap, $variableLabels, $fallbackPeriod))
            ->all();
    }

    private function buildRecapRow(RekapPenilaian $rekap, array $variableLabels, string $fallbackPeriod): array
    {
        $gradeInfo = $this->resolveGrade((float) $rekap->nilai_akhir);
        $employee = $rekap->karyawan;

        return [
            'id' => $rekap->id_rekap,
            'period_id' => $rekap->id_periode,
            'period' => $rekap->period?->nama_periode ?? $fallbackPeriod,
            'name' => $employee?->nama_lengkap ?? 'Karyawan',
            'nip' => $employee?->nip ?? '-',
            'department' => $employee?->departemen ?? 'Belum diatur',
            'position' => $employee?->jabatan ?? 'Belum diatur',
            'atasan' => number_format((float) $rekap->nilai_atasan, 1),
            'rekan' => number_format((float) $rekap->nilai_peer, 1),
            'bawahan' => number_format((float) $rekap->nilai_bawahan, 1),
            'self' => number_format((float) $rekap->nilai_self, 1),
            'final' => number_format((float) $rekap->nilai_akhir, 1),
            'final_raw' => (float) $rekap->nilai_akhir,
            'grade' => $gradeInfo['grade'],
            'variables' => $this->variableScores((float) $rekap->nilai_akhir, $variableLabels),
        ];
    }

    private function variableLabels(): array
    {
        $labels = Variabel::query()
            ->orderBy('id_variabel')
            ->pluck('nama_variabel')
            ->all();

        return $labels !== []
            ? $labels
            : ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'];
    }

    private function variableScores(float $finalScore, array $labels): array
    {
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

    private function periodOptions(): array
    {
        return PeriodePenilaian::query()
            ->orderByDesc('tanggal_mulai')
            ->get()
            ->map(fn (PeriodePenilaian $period) => [
                'value' => $period->id_periode,
                'label' => $period->nama_periode,
            ])
            ->all();
    }

    private function fallbackPeriodLabel(): string
    {
        return PeriodePenilaian::query()
            ->where('status', 'active')
            ->value('nama_periode')
            ?? PeriodePenilaian::query()->orderByDesc('tanggal_mulai')->value('nama_periode')
            ?? 'Periode aktif';
    }
}
