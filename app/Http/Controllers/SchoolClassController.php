<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolClasses = SchoolClass::all();
        return view('admin.classes.index', compact('schoolClasses'));
    }

    public function instructorClasses()
    {
        $instructorId = auth()->user()->id;
        $schoolClasses = SchoolClass::where('instructor_id', $instructorId)->get();
        return view('instructor.classes.index', compact('schoolClasses'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $subjects = \App\Models\Subject::all();
        $instructors = \App\Models\Instructor::all();
        return view('admin.classes.add', compact('subjects', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('admin.classes.index')
                         ->with('success', 'SchoolClass created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolClass  $schoolClass
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolClass $schoolClass)
    {
        return view('admin.classes.show', compact('schoolClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolClass  $schoolClass
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $subjects = \App\Models\Subject::all();
        $instructors = \App\Models\Instructor::all();
        return view('admin.classes.update', compact('schoolClass', 'subjects', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolClass  $schoolClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $validatedData = $request->validate([
            'section' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $schoolClass->update($validatedData);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'SchoolClass updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolClass  $schoolClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()->route('admin.classes.index')
                         ->with('success', 'SchoolClass deleted successfully.');
    }
}