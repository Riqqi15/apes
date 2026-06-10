<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    public function periods()
    {
        return view('assessments.periods');
    }

    public function assignments()
    {
        return view('assessments.assignments');
    }

    public function form()
    {
        return view('assessments.form');
    }

    public function personalResult()
    {
        return view('assessments.personal-result');
    }
}
