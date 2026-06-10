<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DirekturController extends Controller
{
    public function index()
    {
        return view('dashboards.direktur');
    }
}
