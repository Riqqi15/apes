<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('dashboards.karyawan', [
            'pageRole' => 'karyawan',
            'userName' => $user?->karyawan?->nama_lengkap ?? $user?->username ?? 'Karyawan',
            'userRoleLabel' => 'Karyawan',
            'pageSubtitle' => 'Lihat skor terbaru, status penilaian, dan kontribusi Anda sebagai evaluator.',
            'periods' => [
                ['value' => '2026-q2', 'label' => 'Triwulan II 2026'],
                ['value' => '2026-q1', 'label' => 'Triwulan I 2026'],
                ['value' => '2025-q4', 'label' => 'Triwulan IV 2025'],
            ],
            'stats' => [
                [
                    'title' => 'Latest Score',
                    'value' => '91.2',
                    'subtitle' => 'Peringkat naik 4 posisi',
                    'tone' => 'yellow',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="m8 14 3-3 3 2 5-6"></path></svg>',
                ],
                [
                    'title' => 'Latest Grade',
                    'value' => 'A',
                    'subtitle' => 'Sangat baik',
                    'tone' => 'green',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 15 3.1 1.63-.59-3.45 2.51-2.45-3.47-.5L12 7.1l-1.55 3.13-3.47.5 2.51 2.45-.59 3.45z"></path><circle cx="12" cy="8" r="6"></circle></svg>',
                ],
                [
                    'title' => 'Assessment Status',
                    'value' => 'Berjalan',
                    'subtitle' => '2 dari 4 evaluator selesai',
                    'tone' => 'blue',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3l-8.5-14.1a2 2 0 0 0-3.4 0Z"></path></svg>',
                ],
                [
                    'title' => 'Role as Evaluator',
                    'value' => 'Rekan Sejawat',
                    'subtitle' => 'Penugasan aktif 3 karyawan',
                    'tone' => 'teal',
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
                ],
            ],
            'radarLabels' => ['Amanah', 'Kompeten', 'Harmonis', 'Loyal', 'Adaptif', 'Kolaboratif'],
            'radarValues' => [92, 88, 90, 86, 84, 89],
            'trendLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'trendValues' => [81, 83, 84, 86, 89, 91],
            'evaluationQueue' => [
                ['name' => 'Budi Santoso', 'role' => 'Atasan Langsung', 'status' => 'Menunggu'],
                ['name' => 'Maya Sari', 'role' => 'Rekan Sejawat', 'status' => 'Selesai'],
                ['name' => 'Rico Pradana', 'role' => 'Bawahan', 'status' => 'Menunggu'],
            ],
        ]);
    }
}
