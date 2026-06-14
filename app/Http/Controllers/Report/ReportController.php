<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Recap\RecapController;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function print(int $id, RecapController $recapController): View
    {
        $row = collect($recapController->recapRows())->firstWhere('id', $id);

        abort_if(! $row, 404);

        return view('reports.print', [
            'report' => [
                'name' => $row['name'],
                'nip' => $row['nip'],
                'department' => $row['department'],
                'position' => $row['position'],
                'period' => $row['period'],
                'final' => $row['final'],
                'grade' => $row['grade'],
                'components' => [
                    ['label' => 'Atasan Langsung', 'value' => $row['atasan'], 'weight' => '40%'],
                    ['label' => 'Rekan Sejawat', 'value' => $row['rekan'], 'weight' => '20%'],
                    ['label' => 'Bawahan', 'value' => $row['bawahan'], 'weight' => '30%'],
                    ['label' => 'Self Assessment', 'value' => $row['self'], 'weight' => '10%'],
                ],
                'variables' => $row['variables'],
            ],
        ]);
    }
}
