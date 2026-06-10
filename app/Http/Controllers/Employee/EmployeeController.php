<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }

    public function create()
    {
        return view('employees.create');
    }

    public function edit()
    {
        return view('employees.edit');
    }
}
