<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DirekturController extends Controller
{
    public function index()
    {
        return view('dashboards.direktur', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Ringkasan kinerja 360, distribusi grade, dan performa tiap departemen.',
            'periods' => [
                ['value' => '2026-q2', 'label' => 'Triwulan II 2026'],
                ['value' => '2026-q1', 'label' => 'Triwulan I 2026'],
                ['value' => '2025-q4', 'label' => 'Triwulan IV 2025'],
            ],
            'stats' => [
                [
                    'title' => 'Total Karyawan',
                    'value' => '148',
                    'subtitle' => '6 departemen aktif',
                    'tone' => 'yellow',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',
                ],
                [
                    'title' => 'Rata-rata Nilai',
                    'value' => '86.4',
                    'subtitle' => 'Naik 2.1 poin',
                    'tone' => 'blue',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="m8 14 3-3 3 2 5-6"></path></svg>',
                ],
                [
                    'title' => 'Penilaian Selesai',
                    'value' => '112',
                    'subtitle' => '76% dari total target',
                    'tone' => 'green',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"></path><path d="M20 12a8 8 0 1 1-4-6.92"></path></svg>',
                ],
                [
                    'title' => 'Belum Selesai',
                    'value' => '36',
                    'subtitle' => 'Perlu follow-up evaluator',
                    'tone' => 'orange',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3l-8.5-14.1a2 2 0 0 0-3.4 0Z"></path></svg>',
                ],
            ],
            'gradeLabels' => ['A', 'B', 'C', 'D'],
            'gradeValues' => [28, 58, 20, 6],
            'variableLabels' => ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'],
            'variableValues' => [88, 84, 86, 81, 79, 87],
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
