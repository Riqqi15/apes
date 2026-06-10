<?php

namespace App\Http\Controllers\Recap;

use App\Http\Controllers\Controller;

class RecapController extends Controller
{
    public function index()
    {
        return view('recaps.index');
    }

    public function show()
    {
        return view('recaps.show');
    }
}
