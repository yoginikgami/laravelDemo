<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjcts = Subject::with(['schoolClass', 'teacher'])->get();
        return view("./admin/subjects/viewassignSub", compact("subjcts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('./admin/subjects/assignSubject', compact('classes'));
    }
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'subject' => 'required|string',
            'class_id' => 'required|array',
            'class_id.*' => 'exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $subjectName = $request->subject;
        $teacherId = $request->teacher_id;
        $classIds = $request->class_id;

        if($validation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ], 422);
        }

        foreach ($classIds as $classId) {
            $exists = Subject::where('name', $subjectName)
                ->where('class_id', $classId)
                ->exists();

            if ($exists) {
                // Optional: continue instead of returning error for one class
                return back()->withErrors([
                    'duplicate' => "Subject '$subjectName' is already assigned to class ID $classId."
                ])->withInput();
            }

            $student = Subject::create([
                'name' => $subjectName,
                'class_id' => $classId,
                'teacher_id' => $teacherId,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subject assigned successfully.',
                'data' => $student,
            ]);
        }

        //return redirect()->route('subject.index')->with('success', 'Subject assigned to selected classes.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subjects = Subject::with(['schoolClass', 'teacher'])->findOrFail($id);
        if(!$subjects){
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Subject fetched successfully.',
            'data' => [
                'id' => $subjects->id,
                'name' => $subjects->name,
                'school_class' => $subjects->schoolClass ? [
                    'name' => $subjects->schoolClass->name,
                    'section' => $subjects->schoolClass->section,
                ] : null,
                'teacher' => $subjects->teacher ? [
                    'name' => $subjects->teacher->user->name,
                ] : null,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        $classes = SchoolClass::all();

        $teachers = Teacher::where('subject', 'REGEXP', "(^|, )" . preg_quote($subject->name) . "(,|$)")->get();

        return view('./admin/subjects/editassignSub', compact('subject', 'classes', 'teachers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'class_id' => 'required',
            'teacher_id' => 'required'
        ]);

        if($validator->fails() ){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error.',
            ], 422);
        }

        $exists = DB::table('subjects')
            ->join('school_classes', 'subjects.class_id', '=', 'school_classes.id')
            ->where('subjects.name', $request->name)
            ->where('school_classes.name', function($query) use ($request) {
                $query->select('name')->from('school_classes')->where('id', $request->class_id);
            })
            ->where('school_classes.section', function($query) use ($request) {
                $query->select('section')->from('school_classes')->where('id', $request->class_id);
            })
            ->where('subjects.id', '!=', $id)
            ->exists();


        if ($exists) {
            return back()->withErrors([
                'duplicate' => 'This class is already assigned this subject.'
            ])->withInput();
        }
        $subject->update([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subject updated successfully.',
            'data' => $subject,
        ]);

        //return redirect()->route('subject.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully.');
    }

    public function list(){
        $subject = Subject::with(['schoolClass', 'teacher'])->get();

        $data = $subject->map(function($subject){
            return[
                'id'=> $subject->id,
                'name'=> $subject->name,
                'class' => [
                    'id' => $subject->schoolClass->id ?? null,
                    'name' => $subject->schoolClass->name ?? null,
                    'section' => $subject->schoolClass->section ?? null,
                ],
                'teacher' => [
                    'id' => $subject->teacher->id ?? null, 
                    'name' => $subject->teacher->user->name ?? null,
                ],
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Subjects fetched successfully.',
            'data' => $data,
        ]);
    }
}
