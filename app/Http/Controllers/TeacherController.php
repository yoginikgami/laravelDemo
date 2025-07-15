<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with('user')->paginate(5);
        return view('./admin/teacher/viewTeacher', compact('teachers'));
    }

    public function create()
    {
        return view('./admin/teacher/addTeacher');
    }


    public function store(Request $request)
    {
        $validation = $request->validate([
            "fname" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "qualification" => "required|string",
            "subjects" => "required|array",
            "phoneno" => "required|unique:teachers,phone|max:10",
            "address" => "required|string",
            "photo" => "required|image|mimes:jpg,jpeg,png|max:2048",
            "joined_date" => "required|date",
        ]);

        $user = User::create([
            'name' => $validation['fname'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password']),
            // 'role'=> 'Teacher',
        ]);
        $user->assignRole('Teacher');
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        Teacher::create([
            'user_id' => $user->id,
            'qualification' => $validation['qualification'],
            'subject' => implode(', ', $validation['subjects']),
            'phone' => $validation['phoneno'],
            'address' => $validation['address'],
            'profile_photo' => $photoPath,
            'joined_date' => $validation['joined_date'],
            [
                'email.unique'    => 'This email is already registered.',
                'phoneno.unique'  => 'Phone number already exists.',
            ]
        ]);
        return redirect()->route('teacher.index')->with('success', 'Teacher added successfully!');
    }


    public function show(string $id) {}


    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('./admin/teacher/editTeacher', compact('teacher'));
    }


    public function update(Request $request, string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $user = $teacher->user;

        $request->validate([
            "fname" => "required",
            "qualification" => "required|string",
            "subjects" => "required|array",
            "phoneno" => "required|max:10",
            "address" => "required|string",
            "photo" => "nullable|image|mimes:jpg,jpeg,png|max:2048", // Make nullable
            "joined_date" => "required|date",
        ]);

        $user->name = $request->fname;
        $user->save();

        $photoPath = $teacher->profile_photo;

        if ($request->hasFile("photo")) {
            if ($teacher->profile_photo && Storage::disk('public')->exists($teacher->profile_photo)) {
                Storage::disk('public')->delete($teacher->profile_photo);
            }
            $ext = $request->file('photo')->getClientOriginalExtension();
            $fileName = strtolower(str_replace(' ', '_', $request->fname)) . '_' . $teacher->id . '.' . $ext;

            $photoPath = $request->file('photo')->storeAs('teacher_photos', $fileName, 'public');
        }

        $teacher->update([
            'qualification' => $request->qualification,
            'subject' => implode(', ', $request->subjects),
            'phone' => $request->phoneno,
            'address' => $request->address,
            'profile_photo' => $photoPath,
            'joined_date' => $request->joined_date,


        ]);


        return redirect()->route('teacher.index')->with('success', 'Teacher Updated Successfully');
    }


    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        if ($teacher->profile_photo && Storage::disk('public')->exists($teacher->profile_photo)) {
            Storage::disk('public')->delete($teacher->profile_photo);
        }

        $teacher->user()->delete();

        $teacher->delete();

        return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully.');
    }


    // public function getBySubject(Request $request)
    // {
    //     $subject = $request->get('subject');

    //     $teachers = Teacher::where('subject', 'LIKE', '%' . $subject . '%')
    //         ->with('user')
    //         ->get();

    //     if ($teachers->isEmpty()) {
    //         return response()->json([], 200); // return empty array safely
    //     }

    //     return response()->json($teachers->map(function ($teacher) {
    //         return [
    //             'id' => $teacher->id,
    //             'name' => $teacher->user->name,
    //         ];
    //     }));
    // }

    public function getBySubject(Request $request)
{
    $subject = $request->get('subject');

    $teachers = Teacher::where('subject', 'LIKE', '%' . $subject . '%')
        ->with('user')
        ->get();

    return response()->json($teachers->map(function ($teacher) {
        return [
            'id' => $teacher->id,
            'name' => $teacher->user->name,
        ];
    }));
}

}



