<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();
        $totalClasses  = SchoolClass::count();

        $recentStudents = Student::latest()->take(5)->get();
        $recentTeachers = Teacher::latest()->take(5)->get();

        $user = Auth::user();
        $teacher = $user->teacher;

        $studentCountsByClass = DB::table('students')
            ->select('school_classes.name', 'school_classes.section', DB::raw('COUNT(students.id) as student_count'))
            ->join('school_classes', 'students.class_id', '=', 'school_classes.id')
            ->groupBy('school_classes.name', 'school_classes.section')
            ->orderBy('school_classes.name')
            ->get();

        $teachersWithSubjects = Teacher::with(['subjects.schoolClass'])->get();

        return view('admin.dashboard.admin', compact(
            'totalTeachers',
            'totalStudents',
            'totalClasses',
            'recentStudents',
            'recentTeachers',
            'teacher',
            'studentCountsByClass',
            'teachersWithSubjects'
        ));
    }
}
