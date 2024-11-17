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
        $schoolClasses = SchoolClass::with('section')->get();
        return view('admin.classes.index', compact('schoolClasses'));
    }

    public function instructorClasses()
    {
        $userEmail = auth()->user()->email;
        $instructorId = \App\Models\Instructor::where('email', $userEmail)->value('id');
        $schoolClasses = SchoolClass::where('instructor_id', $instructorId)
            ->with('section')
            ->get();
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
        $sections = \App\Models\Section::all();
        return view('admin.classes.add', compact('subjects', 'instructors', 'sections'));
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
            'section_id' => 'required|exists:sections,id',
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
        $sections = \App\Models\Section::all();
        return view('admin.classes.update', compact('schoolClass', 'subjects', 'instructors', 'sections'));
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
            'section_id' => 'required|exists:sections,id',
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
    public function destroy(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();

        return redirect()->route('admin.classes.index')
                         ->with('success', 'SchoolClass deleted successfully.');
    }

    public function showStudents(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $students = $schoolClass->section->students;
        $grades = $students->map(function ($student) use ($schoolClass) {
            return $student->getClassRecord($schoolClass->id);

        });
        return view('instructor.classes.students', compact('schoolClass', 'students', 'grades'));
    }

    public function updateGrades(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $classId = $request->input('class_id');
        $schoolClass = SchoolClass::findOrFail($classId);

        // Validate that the student belongs to the class's section
        if ($student->section_id !== $schoolClass->section_id) {
            return redirect()->back()->with('error', 'Student does not belong to this class.');
        }

        // Validate quiz scores and items
        $validatedData = [];
        for ($i = 1; $i <= 6; $i++) {
            $validatedData["quiz{$i}"] = $request->input("quiz{$i}");
            $validatedData["quiz{$i}_items"] = $request->input("quiz{$i}_items");
        }

        // Update student's grades
        $student->update($validatedData);

        return redirect()->back()->with('success', 'Grades updated successfully.');
    }

    public function addStudent(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        return view('instructor.classes.add-student', compact('schoolClass'));
    }

    public function addStudentsStore(Request $request, string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $request->validate([
            'students' => 'required|array',
            'students.*.student_id' => 'required',
            'students.*.first_name' => 'required|string|max:255',
            'students.*.last_name' => 'required|string|max:255',
            'students.*.email' => 'required|email|max:255'
        ]);

        foreach ($request->students as $studentData) {
            // Check if student already exists
            $existingStudent = Student::where('student_id', $studentData['student_id'])->first();
            
            if (!$existingStudent) {
                // Create new student if doesn't exist
                $existingStudent = Student::create([
                    'student_id' => $studentData['student_id'],
                    'first_name' => $studentData['first_name'],
                    'last_name' => $studentData['last_name'],
                    'email' => $studentData['email']
                ]);
            }

            // Check if student is already in the class
            if (!$schoolClass->students()->where('student_id', $existingStudent->id)->exists()) {
                $schoolClass->students()->attach($existingStudent->id);
            }
        }

        return redirect()->route('instructor.classes.students', ['id' => $schoolClass->id])
                        ->with('success', 'Students added successfully.');
    }
}
