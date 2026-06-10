<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class VariableController extends Controller
{
    public function index()
    {
        return view('variables.index');
    }
}
