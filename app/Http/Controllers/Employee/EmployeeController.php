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

    public function edit($id = null)
    {
        return view('employees.edit', [
            'employee' => [
                'name' => 'Dewi Anggraini',
                'nip' => 'EMP-2026-0042',
                'department' => 'Finance',
                'position' => 'Senior Analyst',
                'email' => 'dewi.anggraini@apes.co.id',
                'phone' => '0812-3456-7890',
            ],
        ]);
    }
}
