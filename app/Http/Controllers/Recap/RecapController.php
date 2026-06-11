<?php

namespace App\Http\Controllers\Recap;

use App\Http\Controllers\Controller;

class RecapController extends Controller
{
    public function index()
    {
        return view('recaps.index', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Filter penilaian per periode dan departemen sebelum masuk detail hasil.',
            'periods' => [
                ['value' => '2026-q2', 'label' => 'Triwulan II 2026'],
                ['value' => '2026-q1', 'label' => 'Triwulan I 2026'],
                ['value' => '2025-q4', 'label' => 'Triwulan IV 2025'],
            ],
            'summaryCards' => [
                ['title' => 'Karyawan Dinilai', 'value' => '112'],
                ['title' => 'Rata-rata Akhir', 'value' => '86.4'],
                ['title' => 'Grade A', 'value' => '28'],
                ['title' => 'Perlu Follow Up', 'value' => '36'],
            ],
            'rows' => [
                ['name' => 'Sinta Lestari', 'department' => 'Finance', 'atasan' => '94.0', 'rekan' => '93.0', 'bawahan' => '92.0', 'self' => '95.0', 'final' => '94.8', 'grade' => 'A'],
                ['name' => 'Rizky Pratama', 'department' => 'Operations', 'atasan' => '92.0', 'rekan' => '94.0', 'bawahan' => '91.0', 'self' => '95.0', 'final' => '93.2', 'grade' => 'A'],
                ['name' => 'Maya Sari', 'department' => 'Commercial', 'atasan' => '90.0', 'rekan' => '92.0', 'bawahan' => '89.0', 'self' => '94.0', 'final' => '91.5', 'grade' => 'A'],
                ['name' => 'Andi Wibowo', 'department' => 'Human Capital', 'atasan' => '89.0', 'rekan' => '91.0', 'bawahan' => '88.0', 'self' => '94.0', 'final' => '90.7', 'grade' => 'A'],
                ['name' => 'Nadia Putri', 'department' => 'Legal', 'atasan' => '87.0', 'rekan' => '90.0', 'bawahan' => '87.0', 'self' => '94.0', 'final' => '89.9', 'grade' => 'B'],
            ],
        ]);
    }

    public function show($id = null)
    {
        return view('recaps.show', [
            'pageRole' => 'direktur',
            'userName' => 'Direktur Utama',
            'userRoleLabel' => 'Direktur',
            'pageSubtitle' => 'Detail lengkap komponen penilaian dan hasil 360.',
            'employee' => [
                'name' => 'Sinta Lestari',
                'nip' => 'P-2026-0148',
                'department' => 'Finance',
                'position' => 'Senior Analyst',
                'period' => 'Triwulan II 2026',
                'finalScore' => '94.8',
                'grade' => 'A',
            ],
            'variableScores' => [
                ['name' => 'Amanah', 'score' => 95],
                ['name' => 'Kompeten', 'score' => 94],
                ['name' => 'Harmonis', 'score' => 92],
                ['name' => 'Loyal', 'score' => 96],
                ['name' => 'Adaptif', 'score' => 91],
                ['name' => 'Kolaboratif', 'score' => 93],
            ],
            'componentScores' => [
                ['label' => 'Atasan Langsung', 'value' => '95.0', 'weight' => '40%'],
                ['label' => 'Rekan Sejawat', 'value' => '94.0', 'weight' => '20%'],
                ['label' => 'Bawahan', 'value' => '92.0', 'weight' => '30%'],
                ['label' => 'Self Assessment', 'value' => '95.0', 'weight' => '10%'],
            ],
        ]);
    }
}
