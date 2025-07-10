<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user(); // ✅ this defines $user
        // $teacher = Teacher::where('user_id', $user->id)->first();

        // $assignments = $teacher->assignedSubjects()->with('class')->get();
        // $studentCount = Student::whereIn('class_id', $assignments->pluck('class_id'))->count();

        // // ✅ Make sure to pass $user to the view
        // //return view('admin.dashboard.admin', compact('user', 'teacher', 'assignments', 'studentCount'));

        // dd(compact('user', 'teacher', 'assignments', 'studentCount'));


    }

}
