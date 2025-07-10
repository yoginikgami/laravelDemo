<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();
        $totalClasses  = SchoolClass::count();

        $recentStudents = Student::latest()->take(5)->get();
        $recentTeachers = Teacher::latest()->take(5)->get();

        return view('admin.dashboard.admin', compact(
            'totalTeachers',
            'totalStudents',
            'totalClasses',
            'recentStudents',
            'recentTeachers'
        ));
    }
}
