<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
        $classes = SchoolClass::all(); // use your actual model
    //return view('your-view-name', compact('classes'));
        return view('./admin/subjects/assignSubject', compact('classes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'subject' => 'required|string',
            'class_id' => 'required|exists:school_classes,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        Subject::create([
            'name' => $request->subject,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('subject.index')->with('success', 'Subject assigned successfully.');
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
        return view('./admin/subjects/editassignSub', compact('subject','classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        $request->validate([
            'name'=> 'required',
            'class_id' =>'required',
            'teacher_id' => 'required'
        ]);

        $exists = Subject::where('name', $request->name)
            // ->where('section', $request->section)
            // ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'duplicate' => "The class '{$request->name} - {$request->section}' already exists."
            ])->withInput();
        }
        $subject->update([
            'name'=> $request->name,
            'section'=> $request->section
        ]);
        return redirect()->route('subject.index')->with('success','Subject Updated Successfully.');
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
