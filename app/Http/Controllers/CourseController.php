<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        // N+1問題あり
        $courses = Course::where("is_published", true)->latest()->paginate(10);
        return view("courses.index", compact("courses"));
    }

    public function show(Course $course)
    {
        return view("courses.show", compact("course"));
    }
}
