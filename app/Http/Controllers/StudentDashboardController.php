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
         if (!$user->hasRole('Student') || !$user->can('view dashboard')) {
        abort(403, 'Unauthorized access to Student dashboard');
    }

        $student = $user->student;


        // if (!$student) {
        //     abort(404, 'Student not found.');
        // }

        $subjects = Subject::with('teacher')
            ->where('class_id', $student->class_id)
            ->get();
        //dd($student);
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
       $user = Auth::user();

        $teacher = Student::where('user_id', $user->id)->findOrFail($id);

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'contact_no' => 'required|digits:10|unique:teachers,phone,' . $teacher->id,
        ]);

        $teacher->update([
            'address' => $validated['address'],
            'phone' => $validated['contact_no'],
        ]);

        return redirect()->back()->with('success', 'Profile information updated successfully.');
    }

}
