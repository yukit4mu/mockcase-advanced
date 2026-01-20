<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
            ->with('course')
            ->latest()
            ->get();
        
        return view('enrollments.index', compact('enrollments'));
    }

    public function store(Request $request)
    {
        // トランザクション処理なし
        Enrollment::create([
            "user_id" => Auth::id(),
            "course_id" => $request->course_id,
        ]);

        return redirect()->route("courses.show", $request->course_id)->with("success", "Enrolled successfully.");
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment cancelled successfully.');
    }
}
