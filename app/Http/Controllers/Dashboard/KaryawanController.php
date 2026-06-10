<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('dashboards.karyawan');
    }
}
