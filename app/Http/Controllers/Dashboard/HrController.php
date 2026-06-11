<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class HrController extends Controller
{
    public function index()
    {
        return view('dashboards.hr', [
            'pageRole' => 'hr',
            'userName' => 'Rani Puspita',
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
                    'value' => '148',
                    'subtitle' => '+12 sejak periode lalu',
                    'tone' => 'yellow',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',
                ],
                [
                    'title' => 'Total Variabel',
                    'value' => '6',
                    'subtitle' => 'Semua nilai AKHLAK aktif',
                    'tone' => 'blue',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 9 5-9 5-9-5 9-5Z"></path><path d="m3 13 9 5 9-5"></path><path d="m3 17 9 5 9-5"></path></svg>',
                ],
                [
                    'title' => 'Total Indikator',
                    'value' => '36',
                    'subtitle' => '6 indikator per variabel',
                    'tone' => 'teal',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path><path d="M7 4v16"></path><path d="M17 4v16"></path></svg>',
                ],
                [
                    'title' => 'Penilaian Selesai',
                    'value' => '112',
                    'subtitle' => '76% completion rate',
                    'tone' => 'green',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"></path><path d="M20 12a8 8 0 1 1-4-6.92"></path></svg>',
                ],
            ],
            'progressCards' => [
                ['label' => 'Selesai', 'value' => '76%'],
                ['label' => 'Berjalan', 'value' => '18%'],
                ['label' => 'Belum Mulai', 'value' => '6%'],
            ],
            'completionBars' => [
                ['label' => 'Finance', 'value' => 92],
                ['label' => 'Operations', 'value' => 86],
                ['label' => 'Commercial', 'value' => 78],
                ['label' => 'Human Capital', 'value' => 69],
            ],
            'gradeLabels' => ['A', 'B', 'C', 'D'],
            'gradeValues' => [28, 58, 20, 6],
            'performanceLabels' => ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'],
            'performanceValues' => [88, 84, 86, 81, 79, 87],
            'topEmployees' => [
                ['name' => 'Sinta Lestari', 'department' => 'Finance', 'score' => '94.8', 'grade' => 'A'],
                ['name' => 'Rizky Pratama', 'department' => 'Operations', 'score' => '93.2', 'grade' => 'A'],
                ['name' => 'Maya Sari', 'department' => 'Commercial', 'score' => '91.5', 'grade' => 'A'],
                ['name' => 'Andi Wibowo', 'department' => 'Human Capital', 'score' => '90.7', 'grade' => 'A'],
                ['name' => 'Nadia Putri', 'department' => 'Legal', 'score' => '89.9', 'grade' => 'B'],
            ],
            'departmentRanking' => [
                ['name' => 'Finance', 'score' => '92.4'],
                ['name' => 'Operations', 'score' => '90.8'],
                ['name' => 'Commercial', 'score' => '89.1'],
                ['name' => 'Human Capital', 'score' => '87.6'],
            ],
        ]);
    }
}
