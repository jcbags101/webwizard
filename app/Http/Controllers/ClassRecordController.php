<?php

namespace App\Http\Controllers;

use App\Imports\ClassRecordsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF;
class ClassRecordController extends Controller
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // Import the file
        Excel::import(new ClassRecordsImport, $request->file('file'));

        return back()->with('success', 'Class records imported successfully.');
    }

    public function index()
    {
        return view('instructor.class_records.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'quiz1' => 'nullable|numeric|min:0|max:100',
            'quiz2' => 'nullable|numeric|min:0|max:100', 
            'quiz3' => 'nullable|numeric|min:0|max:100',
            'quiz4' => 'nullable|numeric|min:0|max:100',
            'quiz5' => 'nullable|numeric|min:0|max:100',
            'quiz6' => 'nullable|numeric|min:0|max:100',
            'oral1' => 'nullable|numeric|min:0|max:100',
            'oral2' => 'nullable|numeric|min:0|max:100',
            'oral3' => 'nullable|numeric|min:0|max:100', 
            'oral4' => 'nullable|numeric|min:0|max:100',
            'oral5' => 'nullable|numeric|min:0|max:100',
            'oral6' => 'nullable|numeric|min:0|max:100',
            'project1' => 'nullable|numeric|min:0|max:100',
            'project2' => 'nullable|numeric|min:0|max:100',
            'project3' => 'nullable|numeric|min:0|max:100',
            'project4' => 'nullable|numeric|min:0|max:100',
            'midterm' => 'nullable|numeric|min:0|max:100',
            'final' => 'nullable|numeric|min:0|max:100',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'term_type' => 'required|string',
            'pre_final_quiz1' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz2' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz3' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz4' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz5' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz6' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral1' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral2' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral3' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral4' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral5' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral6' => 'nullable|numeric|min:0|max:100',
            'pre_final_project1' => 'nullable|numeric|min:0|max:100',
            'pre_final_project2' => 'nullable|numeric|min:0|max:100',
            'pre_final_project3' => 'nullable|numeric|min:0|max:100',
            'pre_final_project4' => 'nullable|numeric|min:0|max:100',
            'pre_final_midterm' => 'nullable|numeric|min:0|max:100',
            'pre_final_final' => 'nullable|numeric|min:0|max:100',
        ]);

        
        $updateData = [];
        
        // Quiz scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("quiz$i")) {
                $updateData["quiz_$i"] = $request->{"quiz$i"};
            }
        }
        
        // Oral scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("oral$i")) {
                $updateData["oral_$i"] = $request->{"oral$i"};
            }
        }
        
        // Project scores
        for ($i = 1; $i <= 4; $i++) {
            if ($request->has("project$i")) {
                $updateData["project_$i"] = $request->{"project$i"}; 
            }
        }

        // Pre-final quiz scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("pre_final_quiz$i")) {
                $updateData["pre_final_quiz_$i"] = $request->{"pre_final_quiz$i"};
            }
        }

        // Pre-final oral scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("pre_final_oral$i")) {
                $updateData["pre_final_oral_$i"] = $request->{"pre_final_oral$i"};
            }
        }
        
        // Pre-final project scores
        for ($i = 1; $i <= 4; $i++) {
            if ($request->has("pre_final_project$i")) {
                $updateData["pre_final_project_$i"] = $request->{"pre_final_project$i"};
            }
        }


        if ($request->has('pre_final_midterm')) {
            $updateData['pre_final_midterm'] = $request->pre_final_midterm;
        }
        if ($request->has('final')) {
            $updateData['pre_final_final'] = $request->pre_final_final;
        } 
        // Exam scores
        if ($request->has('midterm')) {
            $updateData['midterm'] = $request->midterm;
        }
        if ($request->has('final')) {
            $updateData['final'] = $request->final;
        }
        if ($request->has('final_grade')) {
            $updateData['final_grade'] = $request->final_grade;
        }

        $classRecord = \App\Models\ClassRecord::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'class_id' => $request->class_id
            ],
            $updateData
        );

        // Get class record items for total possible scores
        $classRecordItem = \App\Models\ClassRecordItem::where('class_id', $request->class_id)->first();


        if (!$classRecordItem) {
            return redirect()->route('instructor.classes.students', ['id' => $request->class_id])->with('error', 'Class record items not found.');
        }

        // Calculate percentages for each component
        $quizTotal = 0;
        $quizItems = 0;
        for ($i = 1; $i <= 6; $i++) {
            if ($classRecordItem->{"quiz_$i"}) {
                $quizTotal += $classRecord->{"quiz_$i"};
                $quizItems += $classRecordItem->{"quiz_$i"}; 
            }
        }
        $quizPercentage = $quizItems > 0 ? ($quizTotal / $quizItems) * 0.3 : 0;

        $oralTotal = 0;
        $oralItems = 0;
        for ($i = 1; $i <= 6; $i++) {
            if ($classRecordItem->{"oral_$i"}) {
                $oralTotal += $classRecord->{"oral_$i"};
                $oralItems += $classRecordItem->{"oral_$i"};
            }
        }
        $oralPercentage = $oralItems > 0 ? ($oralTotal / $oralItems) * 0.2 : 0;

        $projectTotal = 0;
        $projectItems = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($classRecordItem->{"project_$i"}) {
                $projectTotal += $classRecord->{"project_$i"};
                $projectItems += $classRecordItem->{"project_$i"};
            }
        }
        $projectPercentage = $projectItems > 0 ? ($projectTotal / $projectItems) * 0.1 : 0;

        $examTotal = 0;
        $examItems = 0;
        if (isset($updateData['midterm']) && $classRecordItem->midterm) {
            $examTotal += $classRecord->midterm;
            $examItems += $classRecordItem->midterm;
        }
        if (isset($updateData['final']) && $classRecordItem->final) {
            $examTotal += $classRecord->final; 
            $examItems += $classRecordItem->final;
        }
        $examPercentage = $examItems > 0 ? ($examTotal / $examItems) * 0.4 : 0;

        $preFinalQuizTotal = 0;
        $preFinalQuizItems = 0;
        for ($i = 1; $i <= 6; $i++) {
            if ($classRecordItem->{"pre_final_quiz_$i"}) {
                $preFinalQuizTotal += $classRecord->{"pre_final_quiz_$i"};
                $preFinalQuizItems += $classRecordItem->{"pre_final_quiz_$i"};
            }
        }
        $preFinalQuizPercentage = $preFinalQuizItems > 0 ? ($preFinalQuizTotal / $preFinalQuizItems) * 0.3 : 0;

        $preFinalOralTotal = 0;
        $preFinalOralItems = 0;
        for ($i = 1; $i <= 6; $i++) {
            if ($classRecordItem->{"pre_final_oral_$i"}) {
                $preFinalOralTotal += $classRecord->{"pre_final_oral_$i"};
                $preFinalOralItems += $classRecordItem->{"pre_final_oral_$i"};
            }
        }
        $preFinalOralPercentage = $preFinalOralItems > 0 ? ($preFinalOralTotal / $preFinalOralItems) * 0.2 : 0;

        $preFinalProjectTotal = 0;
        $preFinalProjectItems = 0;
        for ($i = 1; $i <= 4; $i++) {
            if ($classRecordItem->{"pre_final_project_$i"}) {
                $preFinalProjectTotal += $classRecord->{"pre_final_project_$i"};
                $preFinalProjectItems += $classRecordItem->{"pre_final_project_$i"};
            }
        }
        $preFinalProjectPercentage = $preFinalProjectItems > 0 ? ($preFinalProjectTotal / $preFinalProjectItems) * 0.1 : 0;


        $preFinalExamTotal = 0;
        $preFinalExamItems = 0;
        if (isset($updateData['pre_final_midterm']) && $classRecordItem->pre_final_midterm) {
            $preFinalExamTotal += $classRecord->pre_final_midterm;
            $preFinalExamItems += $classRecordItem->pre_final_midterm;
        }
        if (isset($updateData['pre_final_final']) && $classRecordItem->pre_final_final) {
            $preFinalExamTotal += $classRecord->pre_final_final;
            $preFinalExamItems += $classRecordItem->pre_final_final;
        }
        $preFinalExamPercentage = $preFinalExamItems > 0 ? ($preFinalExamTotal / $preFinalExamItems) * 0.4 : 0;

        // Calculate final percentage
        $finalPercentage = ($quizPercentage + $oralPercentage + $projectPercentage + $examPercentage) * 100;
        $preFinalFinalPercentage = ($preFinalQuizPercentage + $preFinalOralPercentage + $preFinalProjectPercentage + $preFinalExamPercentage) * 100;

        $finalGradePercentage = ($preFinalFinalPercentage + $finalPercentage) / 2;

        // Get transmuted grade
        $finalGrade = 5.0; // Default to lowest grade
        foreach ($this->transmutationTable as $percentage => $grade) {
            if ($finalGradePercentage >= $percentage) {
                $finalGrade = $grade;
                break;
            }
        }

        // Update final grade
        $classRecord->update([
            'final_grade' => $finalGrade
        ]);

        return redirect()->route('instructor.classes.students', ['id' => $request->class_id])->with('success', 'Grades saved successfully.');
    }

    public function generatePDF($classId)
    {
        // Get class details
        $schoolClass = \App\Models\SchoolClass::with(['subject', 'instructor'])->findOrFail($classId);
        
        // Get class records with students
        $classRecords = \App\Models\ClassRecord::with('student')
            ->where('class_id', $classId)
            ->get();

        // Get class record items
        $classRecordItem = \App\Models\ClassRecordItem::where('class_id', $classId)->first();

        // Calculate midterm and final grades for each record
        foreach ($classRecords as $record) {
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
        }
        // Format current date and time
        $currentDateTime = Carbon::now()->format('F d, Y h:i A');

        // Generate PDF
        $pdf = PDF::loadView('instructor.class_records.pdf', [
            'schoolClass' => $schoolClass,
            'classRecords' => $classRecords,
            'currentDateTime' => $currentDateTime
        ]);

        // Set paper size to legal and landscape orientation
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('gradesheet_summary.pdf');
    }
}

