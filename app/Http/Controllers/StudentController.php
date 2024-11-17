<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\SchoolClass;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(): View
    {
        $students = Student::with('section')->latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        $sections = Section::all();
        return view('students.create', compact('sections'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required',
                'first_name' => 'required|string|max:255', 
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'class_id' => 'required|exists:classes,id'
            ]);

            // Get the school class
            $schoolClass = SchoolClass::findOrFail($validated['class_id']);
            
            // Get the section from the class
            $section = $schoolClass->section;

            // Check if student already exists in this section
            $existingStudent = Student::where('student_id', $validated['student_id'])->first();
            
            if (!$existingStudent) {

                \Log::info('Section:', ['section' => $section]);
                $student = Student::create([
                    'student_id' => $validated['student_id'],
                    'first_name' => $validated['first_name'], 
                    'last_name' => $validated['last_name'],
                    'email' => $validated['email']
                ]);
                
                \Log::info('Section students:', ['students' => $section->students]);
                // Attach student to section
                $section->students()->attach($student->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Student added successfully',
                    'student' => $student
                ]);
            } else {

                \Log::info('Section students:', ['students' => $section->students]);
                // Check if student is already in this section
                if (!$section->students->contains($existingStudent->id)) {
                    \Log::info('Student not in section:', ['student' => $existingStudent->id]);
                    // If not, attach student to section
                    $section->students()->attach($existingStudent->id);

                    return response()->json([
                        'success' => true,
                        'message' => 'Student added successfully',
                        'student' => $existingStudent
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Student already exists'
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student): View
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        $sections = Section::all();
        return view('students.edit', compact('student', 'sections'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'contact_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}