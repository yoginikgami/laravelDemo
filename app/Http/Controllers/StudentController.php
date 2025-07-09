<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('user')->get();
        return view('./admin/student/viewStudent', compact('students'));

    }

    public function getLastRollNumber(Request $request)
    {
        $classId = $request->class_id;
        $lastRoll = Student::where('class_id', $classId)->max('roll_no') ?? 0;
        return response()->json(['next_roll' => $lastRoll + 1]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $class = SchoolClass::all();
        return view('./admin/student/addStudent', compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "fname"=> "required",
            "email"=> "required|email|unique:users,email",
            "password"=> "required",
            'class_id' => 'required|exists:school_classes,id',
            "roll_no" => "required",
            "gender"=> "required",
            "dob"=> "required|date",
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            "address"=> "required",
            "contact_no"=> "required|unique:teachers,phone|max:10",
        ]);

        $user = User::create([
            'name' => $validation['fname'],
            'email' => $validation['email'],
            'password'=> Hash::make($validation['password']),
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student_photos', 'public');
        }

        Student::create([
            'user_id'=> $user->id,
            'class_id' => $validation['class_id'],
            'roll_no' => $validation['roll_no'],
            'gender'=> $validation['gender'],
            'dob'=> $validation['dob'],
            'photo'=> $photoPath,
            'address' => $validation['address'],
            'contact_no'=> $validation['contact_no'],
        ]);
        return redirect()->route('student.index')->with('success', 'Student added successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $class = SchoolClass::all();
        return view('./admin/student/editStudent', compact('student','class'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;

        $request->validate([
            "fname" => "required",
            'class_id' => 'required|exists:school_classes,id',
            "roll_no" => "required",
            "gender"=> "required",
            "dob"=> "required|date",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            "address"=> "required",
            "contact_no"=> "required|unique:teachers,phone|max:10|min:10",

        ]);

        $user->name = $request->fname;
        $user->save();

        $photoPath = $student->photo;

        if( $request->hasFile("photo") ){
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }
            $ext = $request->file('photo')->getClientOriginalExtension();
            $fileName = strtolower(str_replace(' ', '_', $request->fname)) . '_' . $student->id . '.' . $ext;

            $photoPath = $request->file('photo')->storeAs('student_photos', $fileName, 'public');
        }

        $student->update([
            'user_id'=> $user->id,
            'class_id' => $request->class_id,
            'roll_no' => $request->roll_no,
            'gender'=> $request->gender,
            'dob'=> $request->dob,
            'photo'=> $photoPath,
            'address' => $request->address,
            'contact_no'=> $request->contact_no,
        ]);
        return redirect()->route('student.index')->with('success', 'Student Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->user()->delete();

        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student deleted successfully.');

    }
}
