<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'subject' => 'required|string',
    //         'class_id' => 'required|exists:school_classes,id',
    //         'teacher_id' => 'required|exists:teachers,id',
    //     ]);
    //     $exists = Subject::where('name', $request->subject)
    //         ->where('class_id', $request->class_id)
    //         ->exists();

    //     if ($exists) {
    //         return back()->withErrors([
    //             'duplicate' => 'This class is already assigned this subject.'
    //         ])->withInput();
    //     }

    //     Subject::create([
    //         'name' => $request->subject,
    //         'class_id' => $request->class_id,
    //         'teacher_id' => $request->teacher_id,
    //     ]);

    //     return redirect()->route('subject.index')->with('success', 'Subject assigned successfully.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'subject' => 'required|string',
        'class_id' => 'required|array',
        'class_id.*' => 'exists:school_classes,id',
        'teacher_id' => 'required|exists:teachers,id',
    ]);

    $subjectName = $request->subject;
    $teacherId = $request->teacher_id;
    $classIds = $request->class_id;

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

        Subject::create([
            'name' => $subjectName,
            'class_id' => $classId,
            'teacher_id' => $teacherId,
        ]);
    }

    return redirect()->route('subject.index')->with('success', 'Subject assigned to selected classes.');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            // 'name' => 'required',         // This is your subject
            'class_id' => 'required',
            'teacher_id' => 'required'
        ]);

        // $exists = Subject::where('name', $request->name)
        //     ->where('id', '!=', $id)
        //     ->exists();

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

        return redirect()->route('subject.index')->with('success', 'Subject updated successfully.');
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
}
