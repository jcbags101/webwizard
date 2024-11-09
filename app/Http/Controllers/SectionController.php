<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Student;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sections.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'students' => 'required|array',
        ]);


        \Log::info('Section store request:', $request->all());
        $section = Section::create([
            'name' => $request->name,
            'school_year' => $request->school_year,
        ]);
        
        foreach ($request->students as $studentData) {
            $section->students()->create([
                'student_id' => $studentData['student_id'],
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'email' => $studentData['email'],
                'contact_number' => $studentData['contact_number'],
                'gender' => $studentData['gender'],
            ]);
        }

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $section = Section::findOrFail($id);
        return view('admin.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $section = Section::findOrFail($id);
        return view('admin.sections.update', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'students' => 'required|array',
        ]);
        $section = Section::findOrFail($id);
        $section->update([
            'name' => $request->name,
            'school_year' => $request->school_year
        ]);

        // Create new students
        foreach ($request->students as $studentData) {
            if (!empty($studentData['student_id'])) {
                $section->students()->create([
                    'student_id' => $studentData['student_id'],
                    'first_name' => $studentData['first_name'], 
                    'last_name' => $studentData['last_name'],
                    'email' => $studentData['email'],
                    'contact_number' => $studentData['contact_number'],
                    'gender' => $studentData['gender']
                ]);
            }
        }

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully');
    }

    public function showStudents(string $id)
    {
        $section = Section::with('students')->findOrFail($id);
        return view('admin.sections.students', compact('section'));
    }

    public function removeStudent(string $sectionId, string $studentId)
    {
        $section = Section::findOrFail($sectionId);
        $section->students()->detach($studentId);
        return redirect()->route('admin.sections.showStudents', $sectionId)->with('success', 'Student removed from section successfully');
    }

    public function updateStudent(Request $request, string $studentId)
    {
        \Log::info('Updating student with ID: ' . $studentId);
        \Log::info('Request payload:', $request->all());
        $student = Student::findOrFail($studentId);

        $student->update([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'gender' => $request->gender
        ]);

        return response()->json(['success' => true]);
    }
}
