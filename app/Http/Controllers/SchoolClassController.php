<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validation = Validator::make($request->all(), [
            "name"=> "required|array",
            "section"=> "required|array",
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validation->errors(),
            ], 422);
        }

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
            $class = SchoolClass::create([
                'name'=> $name,
                'section'=> $section
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Classes added Successfully.',
            'data' => $class,
        ]);

       // return redirect()->route('schoolclass.index')->with('success','Classes added Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id); // will throw 404 if not found

        return response()->json([
            'status' => true,
            'message' => 'Class fetched successfully.',
            'data' => [
                'id' => $schoolClass->id,
                'name' => $schoolClass->name,
                'section' => $schoolClass->section,
            ]
        ]);
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
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'section' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "status" =>false,
                "message" => "Validation Error",
                "errors" => $validator->errors(),
            ],422);
        }

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

        return response()->json([
            'status'=>true,
            'message'=> 'Class Updated Successfully',
            'data' => $schoolClass,
        ]);
        //return redirect()->route('schoolclass.index')->with('success','Class Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();
        
        // if(!$schoolClass) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Class not found.',
        //     ], 404);
        // }
        // if($id->wantsJson()){
            return response()->json([
                'status' => true,
                'message' => 'Class deleted successfully.',
            ]);
        // }

        // return redirect()->route('schoolclass.index')->with('success', 'Class deleted successfully.');
    }

    public function list(){
        $schoolClass = SchoolClass::get();
        $data = $schoolClass->map(function ($schoolClass) {
            return [
                'id' => $schoolClass->id,
                'name' => $schoolClass->name,
                'section' => $schoolClass->section,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Classes fetched successfully.',
            'data' => $data,
        ]);
    }
}
