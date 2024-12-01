<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Mail\StudentGradesMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendStudentGrades;
use App\Models\ClassRecordItem;
use App\Models\Instructor;

class SchoolClassController extends Controller
{
    private $transmutationTable = [
        100 => 1.0, 99 => 1.1, 98 => 1.2, 97 => 1.3, 96 => 1.4, 95 => 1.5, 94 => 1.6, 93 => 1.6, 92 => 1.7,
        91 => 1.7, 90 => 1.8, 89 => 1.8, 88 => 1.9, 87 => 1.9, 86 => 2.0, 85 => 2.0, 84 => 2.1, 83 => 2.1,
        82 => 2.2, 81 => 2.2, 80 => 2.3, 79 => 2.3, 78 => 2.4, 77 => 2.4, 76 => 2.5, 75 => 2.5, 74 => 2.6,
        73 => 2.6, 72 => 2.6, 71 => 2.6, 70 => 2.6, 69 => 2.7, 68 => 2.7, 67 => 2.7, 66 => 2.7, 65 => 2.7,
        64 => 2.8, 63 => 2.8, 62 => 2.8, 61 => 2.8, 60 => 2.8, 59 => 2.9, 58 => 2.9, 57 => 2.9, 56 => 2.9,
        55 => 2.9, 54 => 3.0, 53 => 3.0, 52 => 3.0, 51 => 3.0, 50 => 3.0, 49 => 3.1, 48 => 3.1, 47 => 3.1,
        46 => 3.2, 45 => 3.2, 44 => 3.3, 43 => 3.3, 42 => 3.3, 41 => 3.3, 40 => 3.3, 39 => 3.4, 38 => 3.4,
        37 => 3.5, 36 => 3.5, 35 => 3.5, 34 => 3.6, 33 => 3.6, 32 => 3.6, 31 => 3.7, 30 => 3.7, 29 => 3.8,
        28 => 3.8, 27 => 3.8, 26 => 3.8, 25 => 3.9, 24 => 3.9, 23 => 3.9, 22 => 4.0, 21 => 4.0, 20 => 4.1,
        19 => 4.1, 18 => 4.1, 17 => 4.2, 16 => 4.2, 15 => 4.3, 14 => 4.3, 13 => 4.4, 12 => 4.4, 11 => 4.4,
        10 => 4.5, 9 => 4.5, 8 => 4.6, 7 => 4.6, 6 => 4.7, 5 => 4.7, 4 => 4.8, 3 => 4.8, 2 => 4.9, 1 => 4.9,
        0 => 5.0
    ];


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
        $students = $schoolClass->section->students ?? collect();
        $instructors = Instructor::where('id', '!=', auth()->user()->instructor->id)->get();

        return view('instructor.classes.students', compact('schoolClass', 'students', 'instructors'));
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

    public function sendGrades(string $id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $students = $schoolClass->section->students;

        foreach ($students as $student) {
            $record = $student->getClassRecord($schoolClass->id) ;
            if ($record) {
                $classRecordItem = ClassRecordItem::where('class_id', $schoolClass->id)->first();

                $midtermTotal = 0;
                $midtermItems = 0;
                $finalTotal = 0; 
                $finalItems = 0;

                // Midterm calculations
                if ($record->midterm && $classRecordItem->midterm) {
                    $midtermTotal = $record->midterm;
                    $midtermItems = $classRecordItem->midterm;
                }

                // Final calculations  
                if ($record->final && $classRecordItem->final) {
                    $finalTotal = $record->final;
                    $finalItems = $classRecordItem->final;
                }

                // Update computed grades
                // Calculate raw percentage scores
                $midtermPercentage = $midtermItems > 0 ? ($midtermTotal / $midtermItems) * 100 : 0;
                $finalPercentage = $finalItems > 0 ? ($finalTotal / $finalItems) * 100 : 0;

                // Map to transmuted grades using transmutation table
                $record->midterm = 5.0; // Default to lowest grade
                $record->final = 5.0;

                foreach ($this->transmutationTable as $percentage => $grade) {
                    if ($midtermPercentage >= $percentage) {
                        $record->midterm = $grade;
                        break;
                    }
                }

                foreach ($this->transmutationTable as $percentage => $grade) {
                    if ($finalPercentage >= $percentage) {
                        $record->final = $grade;
                        break;
                    }
                }

                \Log::info('Student grade record:', ['record' => $record->toArray()]);

                SendStudentGrades::dispatch($student, $schoolClass->subject->name, $record->toArray());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Grades sending process has been queued'
        ]);
    }

    public function shareClass(Request $request, string $id)
    {
        try {
            // Validate request
            $request->validate([
                'instructor_email' => 'required|email|exists:instructors,email'
            ]);

            // Get the class and instructor
            $schoolClass = SchoolClass::findOrFail($id);
            $instructor = Instructor::where('email', $request->instructor_email)->first();

            // Check if class is already shared with this instructor
            if ($schoolClass->sharedInstructors()->where('instructor_id', $instructor->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class is already shared with ' . $instructor->email
                ], 422);
            }

            // Create shared class record
            $schoolClass->sharedInstructors()->attach($instructor->id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Class shared successfully with ' . $instructor->email
            ]);

        } catch (\Exception $e) {
            \Log::error('Error sharing class: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sharing the class'
            ], 500);
        }
    }
}
