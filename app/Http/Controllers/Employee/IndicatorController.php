<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class IndicatorController extends Controller
{
    public function index()
    {
        return view('indicators.index');
    }
}
