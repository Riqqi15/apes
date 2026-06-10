<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class HrController extends Controller
{
    public function index()
    {
        return view('dashboards.hr');
    }
}
