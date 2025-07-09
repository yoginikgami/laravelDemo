<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolClass = SchoolClass::get();
        return view('./admin/class/viewClass', compact('schoolClass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('./admin/class/addClass');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=> "required|array",
            "section"=> "required|array",
        ]);

        $names = $request->name;
        $sections = $request->section;

        foreach ($names as $index => $name) {
            $section = $sections[ $index ];

            $exists = SchoolClass::where('name',$name)->where('section',$section)->exists();

            if ($exists) {
                return back()->withErrors([
                    'duplicate' => "The class '$name - $section' already exists.",
                ])->withInput();
            }
            SchoolClass::create([
                'name'=> $name,
                'section'=> $section
            ]);
        }

        return redirect()->route('schoolClass.index')->with('success','Classes added Successfully.');
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
        $schoolClass = SchoolClass::findOrFail($id);

        return view('./admin/class/editClass', compact('schoolClass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $request->validate([
            'name'=> 'required',
            'section' =>'required'
        ]);

        $exists = SchoolClass::where('name', $request->name)
            ->where('section', $request->section)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'duplicate' => "The class '{$request->name} - {$request->section}' already exists."
            ])->withInput();
        }
        $schoolClass->update([
            'name'=> $request->name,
            'section'=> $request->section
        ]);
        return redirect()->route('schoolClass.index')->with('success','Class Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();
         return redirect()->route('schoolClass.index')->with('success', 'Class deleted successfully.');
    }
}
