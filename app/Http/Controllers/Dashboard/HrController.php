<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssessorAssignment;
use App\Models\Indikator;
use App\Models\Karyawan;
use App\Models\RekapPenilaian;
use App\Models\Variabel;
use Illuminate\Support\Collection;

class HrController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalEmployees = Karyawan::query()->count();
        $totalVariables = Variabel::query()->count();
        $totalIndicators = Indikator::query()->count();
        $totalAssignments = AssessorAssignment::query()->count();
        $completedAssignments = AssessorAssignment::query()->where('status', 'Selesai')->count();
        $inProgressAssignments = AssessorAssignment::query()->where('status', 'Berjalan')->count();
        $waitingAssignments = AssessorAssignment::query()->where('status', 'Menunggu')->count();
        $completionRate = $totalAssignments > 0
            ? (int) round(($completedAssignments / $totalAssignments) * 100)
            : 0;
        $topEmployees = RekapPenilaian::query()
            ->with('karyawan')
            ->orderByDesc('nilai_akhir')
            ->limit(5)
            ->get()
            ->map(function (RekapPenilaian $recap) {
                return [
                    'name' => $recap->karyawan?->nama_lengkap ?? 'Karyawan',
                    'department' => $recap->karyawan?->departemen ?? '-',
                    'score' => number_format((float) $recap->nilai_akhir, 1),
                    'grade' => $recap->grade ?: '-',
                ];
            });
        $departmentRanking = RekapPenilaian::query()
            ->join('karyawan', 'rekap_penilaian.id_karyawan', '=', 'karyawan.id_karyawan')
            ->selectRaw('karyawan.departemen as name, ROUND(AVG(rekap_penilaian.nilai_akhir), 1) as score')
            ->whereNotNull('karyawan.departemen')
            ->groupBy('karyawan.departemen')
            ->orderByDesc('score')
            ->limit(4)
            ->get();
        $gradeDistribution = RekapPenilaian::query()
            ->selectRaw('grade, COUNT(*) as total')
            ->groupBy('grade')
            ->pluck('total', 'grade');
        $performanceLabels = Variabel::query()
            ->orderBy('id_variabel')
            ->pluck('nama_variabel')
            ->values();
        $performanceValues = $this->buildVariablePerformance($performanceLabels);

        return view('dashboards.hr', [
            'pageRole' => 'hr',
            'userName' => $user?->hr?->nama_hr ?? $user?->username ?? 'HR Department',
            'userRoleLabel' => 'HR Department',
            'pageSubtitle' => 'Pantau data karyawan, indikator, dan progres penilaian dalam satu layar.',
            'periods' => [
                ['value' => '2026-q2', 'label' => 'Triwulan II 2026'],
                ['value' => '2026-q1', 'label' => 'Triwulan I 2026'],
                ['value' => '2025-q4', 'label' => 'Triwulan IV 2025'],
            ],
            'stats' => [
                [
                    'title' => 'Total Karyawan',
                    'value' => (string) $totalEmployees,
                    'subtitle' => 'Master employee terdaftar',
                    'tone' => 'yellow',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',
                ],
                [
                    'title' => 'Total Variabel',
                    'value' => (string) $totalVariables,
                    'subtitle' => 'Nilai AKHLAK aktif',
                    'tone' => 'blue',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 9 5-9 5-9-5 9-5Z"></path><path d="m3 13 9 5 9-5"></path><path d="m3 17 9 5 9-5"></path></svg>',
                ],
                [
                    'title' => 'Total Indikator',
                    'value' => (string) $totalIndicators,
                    'subtitle' => $totalVariables > 0
                        ? number_format($totalIndicators / $totalVariables, 1) . ' indikator per variabel'
                        : 'Belum ada indikator',
                    'tone' => 'teal',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path><path d="M7 4v16"></path><path d="M17 4v16"></path></svg>',
                ],
                [
                    'title' => 'Penilaian Selesai',
                    'value' => (string) $completedAssignments,
                    'subtitle' => $completionRate . '% completion rate',
                    'tone' => 'green',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"></path><path d="M20 12a8 8 0 1 1-4-6.92"></path></svg>',
                ],
            ],
            'progressCards' => [
                ['label' => 'Selesai', 'value' => $completionRate . '%'],
                ['label' => 'Berjalan', 'value' => $totalAssignments > 0 ? (int) round(($inProgressAssignments / $totalAssignments) * 100) . '%' : '0%'],
                ['label' => 'Belum Mulai', 'value' => $totalAssignments > 0 ? (int) round(($waitingAssignments / $totalAssignments) * 100) . '%' : '0%'],
            ],
            'completionBars' => [
                ['label' => 'Finance', 'value' => 92],
                ['label' => 'Operations', 'value' => 86],
                ['label' => 'Commercial', 'value' => 78],
                ['label' => 'Human Capital', 'value' => 69],
            ],
            'gradeLabels' => ['A', 'B', 'C', 'D'],
            'gradeValues' => [
                (int) ($gradeDistribution['A'] ?? 0),
                (int) ($gradeDistribution['B'] ?? 0),
                (int) ($gradeDistribution['C'] ?? 0),
                (int) ($gradeDistribution['D'] ?? 0),
            ],
            'performanceLabels' => $performanceLabels->all(),
            'performanceValues' => $performanceValues,
            'topEmployees' => $topEmployees->isNotEmpty() ? $topEmployees->all() : [
                ['name' => 'Belum ada rekap', 'department' => '-', 'score' => '0.0', 'grade' => '-'],
            ],
            'departmentRanking' => $departmentRanking->isNotEmpty() ? $departmentRanking->map(fn ($item) => [
                'name' => $item->name,
                'score' => number_format((float) $item->score, 1),
            ])->all() : [
                ['name' => 'Belum ada departemen', 'score' => '0.0'],
            ],
        ]);
    }

    private function buildVariablePerformance(Collection $labels): array
    {
        $baseScore = (float) (RekapPenilaian::query()->avg('nilai_akhir') ?? 0);
        $fallbackLabels = collect(['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif']);
        $resolvedLabels = $labels->isNotEmpty() ? $labels->values() : $fallbackLabels;
        $offsets = [3, 1, 0, -2, -3, 2];

        return $resolvedLabels->map(function (string $label, int $index) use ($baseScore, $offsets) {
            return max(0, min(100, round($baseScore + $offsets[$index % count($offsets)])));
        })->all();
    }
}
