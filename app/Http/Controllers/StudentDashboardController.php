<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $student = $user->student;

        if (!$student) {
            abort(404, 'Student profile not found.');
        }

        $subjects = Subject::with('teacher')
            ->where('class_id', $student->class_id)
            ->get();

        return view('admin.dashboard.student', compact('student', 'subjects'));
    }

    public function updatePhoto(Request $request, string $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        $studentName = Str::slug($student->user->name, '_');
        $date = now()->format('Y-m-d');
        $ext = $request->photo->getClientOriginalExtension();

        $fileName = "{$studentName}_{$date}.{$ext}";

        $path = $request->file('photo')->storeAs('student_photos', $fileName, 'public');

        $student->photo = $path;
        $student->save();

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        return view('./admin/dashboard/student', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;

        $request->validate([
            "address" => "required",
            "contact_no" => "required|unique:teachers,phone|max:10|min:10",
        ]);


        $student->update([
            'address' => $request->address,
            'contact_no' => $request->contact_no,
        ]);
        return redirect()->route('admin.studentDashboard')->with('success', 'Student Data Updated Successfully');
    }

    // public function profile(){
    //     return view('./admin/student/profile');
    // }
}
