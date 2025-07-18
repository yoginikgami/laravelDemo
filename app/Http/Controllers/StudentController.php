<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        if(!$user || !$user->hasRole(['Admin','Teacher'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $validation = Validator::make($request->all(), [
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

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request['fname'],
            'email' => $request['email'],
            'password'=> Hash::make($request['password']),
            // 'role'=> 'Student',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student_photos', 'public');
        }
        $user->assignRole('Student');

        // $user->assignRole('Teacher');
        $student = Student::create([
            'user_id'=> $user->id,
            'class_id' => $request['class_id'],
            'roll_no' => $request['roll_no'],
            'gender'=> $request['gender'],
            'dob'=> $request['dob'],
            'photo'=> $photoPath,
            'address' => $request['address'],
            'contact_no'=> $request['contact_no'],
        ]);
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Student created successfully.',
                'data' => $student->load('user'),
            ]);
        } else {
            return redirect()->route('student.index')->with('success', 'Student created successfully!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole(['Admin', 'Teacher'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $student = Student::with(['user', 'schoolClass'])->find($id);

        if(!$student){
            return response()->json([
                'status' => false,
                'message' => 'Student not found.',
            ], 404);
        }
        if($request->expectsJson()) {
            return response()->json([
                'status'=> true,
                'message'=> 'Student fetched successfully.',
                'data' => [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'email' => $student->user->email,
                    'class' => [
                        'id' => $student->schoolClass->id ?? null,
                        'name' => $student->schoolClass->name ?? null,
                        'section' => $student->schoolClass->section ?? null,
                    ],
                    'roll_no' => $student->roll_no,
                    'gender' => $student->gender,
                    'dob' => $student->dob,
                    'contact_no' => $student->contact_no,
                    'address' => $student->address,
                    'photo' => $student->photo ? asset('storage/' . $student->photo) : null,
                ]
            ]);}
        
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
        $user = Auth::user();
        if(!$user || !$user->hasRole(['Admin', 'Teacher'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $user = Auth::user();
        if(!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;

        $validator = Validator::make($request->all(), [
            "fname" => "required",
            'class_id' => 'required|exists:school_classes,id',
            "roll_no" => "required",
            "gender"=> "required",
            "dob"=> "required|date",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            "address"=> "required",
            "contact_no"=> "required|unique:teachers,phone|max:10|min:10",

        ]);

        if($validator->fails() ){
            return response()->json([
                "status"=> false,
                "message"=> "Validation Error",
                "errors"=> $validator->errors(),
            ],422);
        }

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
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Student Updated Successfully',
                'data' => $student->load('user'),
            ]);
        }
        else{
            return redirect()->route('student.index')->with('success', 'Student Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id, Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->hasPermissionTo('delete student')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $student = Student::findOrFail($id);

        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        // Check if it was an AJAX or web request
        if ($request->isJson() || $request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Student deleted successfully.',
            ]);
        }
        return redirect()->route('student.index')->with('success', 'Student deleted successfully!');
    }

    public function list()
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole(['Admin', 'Teacher'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $student = Student::with('user')->get();

        $data = $student->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'class' => [
                    'id' => $student->schoolClass->id ?? null,
                    'name' => $student->schoolClass->name ?? null,
                    'section' => $student->schoolClass->section ?? null,
                ],
                'roll_no' => $student->roll_no,
                'gender' => $student->gender,
                'dob' => $student->dob,
                'contact_no' => $student->contact_no,
                'address' => $student->address,
                'photo' => $student->photo ? asset('storage/' . $student->photo) : null,
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Student list fetched successfully.',
            'data' => $data,
        ]);
    }
}
