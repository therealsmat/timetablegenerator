<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    public function index(Department $department, Course $course, Request $request)
    {
        $level = $request->level ?? 0;
        $sem = $request->sem ?? 0;
        $sess = $request->sess ?? 0;
        $dept = $request->dept ?? 0;

        $courses = $course->where([
            'level' => $level,
            'semester' => $sem,
            'session' => $sess,
            'dept'    => $dept
        ])->get();
        $title = 'Level';
        return view('level', compact('title', 'courses'));
    }
}
