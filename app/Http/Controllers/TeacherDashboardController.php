<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $teacher = $user->teacher;
        $teacher = Teacher::where('user_id', $user->id)->first();

        $assignedSubjects = Subject::with('schoolClass')
            ->where('teacher_id', $teacher->id)
            ->get();


        $classIds = $assignedSubjects->pluck('class_id')->unique();


        $studentsByClass = Student::with('user', 'schoolClass')
            ->whereIn('class_id', $classIds)
            ->get()
            ->groupBy('class_id');

        return view("admin.dashboard.teacher", compact("user", "teacher", "assignedSubjects", "studentsByClass"));
    }

    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('./admin/dashboard/teacher', compact('teacher'));
    }

    public function updatePhoto(Request $request, string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Delete old photo if it exists
        if ($teacher->profile_photo && Storage::disk('public')->exists($teacher->profile_photo)) {
            Storage::disk('public')->delete($teacher->profile_photo);
        }

        if ($request->hasFile('photo')) {
            $teacherName = Str::slug($teacher->user->name, '_');
            $date = now()->format('Y-m-d');
            $ext = $request->file('photo')->getClientOriginalExtension(); // ✅ Fixed here

            $fileName = "{$teacherName}_{$date}.{$ext}";

            $path = $request->file('photo')->storeAs('teacher_photos', $fileName, 'public');

            $teacher->profile_photo = $path;
            $teacher->save();
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }


    public function update(Request $request, string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $user = $teacher->user;

        $request->validate([
            "address" => "required",
            "contact_no" => "required|unique:teachers,phone|max:10|min:10",
        ]);


        $teacher->update([
            'address' => $request->address,
            'contact_no' => $request->contact_no,
        ]);
        return redirect()->route('admin.teacherDashboard')->with('success', 'teacher Data Updated Successfully');
    }
}
