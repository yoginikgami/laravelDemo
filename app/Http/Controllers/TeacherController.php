<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('./admin/teacher/viewTeacher', compact('teachers'));
    }

    public function create()
    {
        return view('./admin/teacher/addTeacher');
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $validation = Validator::make($request->all(), [
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

        if($validation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request['fname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            // 'role'=> 'Teacher',
        ]);
        $user->assignRole('Teacher');
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'qualification' => $request['qualification'],
            'subject' => implode(', ', $request['subjects']),
            'phone' => $request['phoneno'],
            'address' => $request['address'],
            'profile_photo' => $photoPath,
            'joined_date' => $request['joined_date'],
            [
                'email.unique'    => 'This email is already registered.',
                'phoneno.unique'  => 'Phone number already exists.',
            ]
        ]);
        if ($request->expectsJson()) {
            return response()->json([
                'status'=> true,
                'message'=> 'Teacher created successfully',
                'data' => $teacher->load('user'),
            ]);
        } else {
            return redirect()->route('teacher.index')->with('success', 'Teacher added successfully!');
        }
    }


    public function show(string $id, Request $request)
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $teacher = Teacher::with('user')->findOrFail($id);

        if (!$teacher) {
           return response()->json([
                'status'=> false,
                'message'=> 'Teacher not found',
           ],404);
        }
        if ($request->expectsJson()) {
            return response()->json([
                'status'=> true,
                'message'=> 'Teacher details fetched successfully',
                'data' => [
                    'id' => $teacher->id,
                    'name' => $teacher->user->name,
                    'email' => $teacher->user->email,
                    'qualification' => $teacher->qualification,
                    'subject' => explode(', ', $teacher->subject),
                    'phone' => $teacher->phone,
                    'address' => $teacher->address,
                    'profile_photo' => $teacher->profile_photo ? asset('storage/' . $teacher->profile_photo) : null,
                    'joined_date' => $teacher->joined_date,
                ],
                ]);
        }else{
            return view('./admin/teacher/viewTeacher', compact('teacher'));
        }

    }


    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);

        // if(request()->ajax()){
        //     return view('admin.teacher.editfrom', compact('teacher'))->render();
        // }
       return view('./admin/teacher/editTeacher', compact('teacher'));

    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }
        $teacher = Teacher::with('user')->find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            "fname" => "required",
            "qualification" => "required|string",
            "subjects" => "required|array",
            "phoneno" => "required|max:10",
            "address" => "required|string",
            "photo" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
            "joined_date" => "required|date",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation Error",
                "errors" => $validator->errors(),
            ], 422);
        }

        $teacher->user->name = $request->fname;
        $teacher->user->save();

        $photoPath = $teacher->profile_photo;

        if ($request->hasFile("photo")) {
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        $teacher->update([
            'qualification' => $request->qualification,
            'subject' => implode(', ', $request->subjects),
            'phone' => $request->phoneno,
            'address' => $request->address,
            'profile_photo' => $photoPath,
            'joined_date' => $request->joined_date,
        ]);
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Teacher updated successfully',
                'data' => $teacher->load('user'),
            ]);
        }
        return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully');
    }

    public function destroy(string $id, Request $request)
    {
        $user = Auth::user();
        if(!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ],403);
        }
        $teacher = Teacher::findOrFail($id);

        if ($teacher->profile_photo && Storage::disk('public')->exists($teacher->profile_photo)) {
            Storage::disk('public')->delete($teacher->profile_photo);
        }

        $teacher->user()->delete();

        $teacher->delete();
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Teacher deleted successfully.',
            ]);
        }
        else {
            return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully.');
        }

    }


    public function getBySubject(Request $request)
    {
        $subject = $request->get('subject');

        if(!$subject){
            return response()->json([
                'status' => false,
                'message' => 'Subject is required',
            ], 400);
        }

        // $teacher = Teacher::where('subject','LIKE', '%' . $subject . '%')
        //     ->with('user')
        //     ->get();

        // $data = $teacher->map(function($teacher){
        //     return [
        //         'id' => $teacher->id,
        //         'name' => $teacher->user->name,
        //         'email' => $teacher->user->email,
        //         'qualification' => $teacher->qualification,
        //         'subject' => explode(', ', $teacher->subject),
        //         'phone' => $teacher->phone,
        //         'address' => $teacher->address,
        //         'profile_photo' => $teacher->profile_photo ? asset('storage/' . $teacher->profile_photo) : null,
        //         'joined_date' => $teacher->joined_date,
        //     ];
        // });

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Teachers fetched successfully',
        //     'data' => $data,
        // ]);

        if (!$subject) {
            return response()->json([], 400);
        }

        $teachers = Teacher::where('subject', 'LIKE', '%' . $subject . '%')
            ->with('user')
            ->get();

        $data = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'name' => $teacher->user->name,
            ];
        });

        return response()->json($data);


    }

        public function list(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('Admin')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        $search = $request->input('search');

        $query = Teacher::with('user');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }

        $teachers = $query->paginate(10);

        $data = $teachers->getCollection()->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'name' => $teacher->user->name,
                'email' => $teacher->user->email,
                'qualification' => $teacher->qualification,
                'subject' => explode(', ', $teacher->subject),
                'phone' => $teacher->phone,
                'address' => $teacher->address,
                'profile_photo' => $teacher->profile_photo ? asset('storage/' . $teacher->profile_photo) : null,
                'joined_date' => $teacher->joined_date,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Teacher list fetched successfully.',
            'data' => $data,
            'total' => $teachers->total(),
            'per_page' => $teachers->perPage(),
            'current_page' => $teachers->currentPage(),
            'last_page' => $teachers->lastPage(),
            'next_page_url' => $teachers->nextPageUrl(),
            'prev_page_url' => $teachers->previousPageUrl(),
        ]);
    }

}



