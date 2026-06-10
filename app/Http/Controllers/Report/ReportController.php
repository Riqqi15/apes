<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function print()
    {
        return view('reports.print');
    }
}
