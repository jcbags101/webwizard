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

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'term_type' => 'required|string',
            // Group similar validations
            ...$this->getScoreValidationRules(),
        ]);
    }

    private function getScoreValidationRules()
    {
        $rules = [];
        $scoreTypes = ['quiz', 'oral', 'project', 'pre_final_quiz', 'pre_final_oral', 'pre_final_project'];
        $maxItems = ['quiz' => 6, 'oral' => 6, 'project' => 4];

        foreach ($scoreTypes as $type) {
            $max = $maxItems[str_replace('pre_final_', '', $type)] ?? 6;
            for ($i = 1; $i <= $max; $i++) {
                $rules["{$type}{$i}"] = 'nullable|numeric|min:0|max:100';
            }
        }

        // Add exam rules
        $examTypes = ['midterm', 'final', 'final_grade', 'pre_final_midterm', 'pre_final_final'];
        foreach ($examTypes as $type) {
            $rules[$type] = 'nullable|numeric|min:0|max:100';
        }

        return $rules;
    }

    private function prepareUpdateData(Request $request)
    {
        $updateData = [];
        
        // Handle regular scores
        $this->processScores($updateData, $request, ['quiz', 'oral', 'project']);
        
        // Handle pre-final scores
        $this->processScores($updateData, $request, ['pre_final_quiz', 'pre_final_oral', 'pre_final_project']);
        
        // Handle exam scores
        $examTypes = ['midterm', 'final', 'final_grade', 'pre_final_midterm', 'pre_final_final'];
        foreach ($examTypes as $type) {
            if ($request->has($type)) {
                $updateData[$type] = $request->$type;
            }
        }
        
        return $updateData;
    }

    private function processScores(&$updateData, Request $request, array $types)
    {
        $maxItems = ['quiz' => 6, 'oral' => 6, 'project' => 4];
        
        foreach ($types as $type) {
            $baseType = str_replace('pre_final_', '', $type);
            $max = $maxItems[$baseType];
            
            for ($i = 1; $i <= $max; $i++) {
                $requestKey = "{$type}{$i}";
                $dbKey = str_replace('final_', 'final_', "{$type}_{$i}");
                
                if ($request->has($requestKey)) {
                    $updateData[$dbKey] = $request->$requestKey;
                }
            }
        }
    }

    private function calculateComponentPercentage($classRecord, $classRecordItem, $component, $maxItems, $weight)
    {
        $total = 0;
        $items = 0;
        
        for ($i = 1; $i <= $maxItems; $i++) {
            $field = "{$component}_{$i}";
            if ($classRecordItem->$field) {
                $percentage = ($classRecord->$field / $classRecordItem->$field) * 100;
                $transmutedGrade = $this->calculateFinalGrade($percentage);
                $total += $transmutedGrade;
                $items++;
            }
        }
        
        return $items > 0 ? ($total / $items) * $weight : 0;
    }

    private function calculateExamPercentage($classRecord, $classRecordItem, $updateData, $examFields, $weight)
    {
        $total = 0;
        $items = 0;
        
        foreach ($examFields as $field) {
            if ($classRecordItem->$field) {
                $percentage = ($classRecord[$field] / $classRecordItem->$field) * 100;
                $transmutedGrade = $this->calculateFinalGrade($percentage);
                $total += $transmutedGrade;
                $items++;
            }
        }
        
        return $items > 0 ? ($total / $items) * $weight : 0;
    }

    private function calculateFinalGrade($finalPercentage)
    {
        $finalGrade = 5.0; // Default to lowest grade
        foreach ($this->transmutationTable as $percentage => $grade) {
            if ($finalPercentage >= $percentage) {
                return $grade;
            }
        }
        return $finalGrade;
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id.*' => 'required|exists:students,id',
            'term_type.*' => 'required|string',
            // Add validation for arrays
            'quiz1.*' => 'nullable|numeric|min:0|max:100',
            'quiz2.*' => 'nullable|numeric|min:0|max:100',
            'quiz3.*' => 'nullable|numeric|min:0|max:100',
            'quiz4.*' => 'nullable|numeric|min:0|max:100',
            'quiz5.*' => 'nullable|numeric|min:0|max:100',
            'quiz6.*' => 'nullable|numeric|min:0|max:100',
            'oral1.*' => 'nullable|numeric|min:0|max:100',
            'oral2.*' => 'nullable|numeric|min:0|max:100',
            'oral3.*' => 'nullable|numeric|min:0|max:100',
            'oral4.*' => 'nullable|numeric|min:0|max:100',
            'oral5.*' => 'nullable|numeric|min:0|max:100',
            'oral6.*' => 'nullable|numeric|min:0|max:100',
            'project1.*' => 'nullable|numeric|min:0|max:100',
            'project2.*' => 'nullable|numeric|min:0|max:100',
            'project3.*' => 'nullable|numeric|min:0|max:100',
            'project4.*' => 'nullable|numeric|min:0|max:100',
            'midterm.*' => 'nullable|numeric|min:0|max:100',
            'final.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz1.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz2.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz3.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz4.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz5.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_quiz6.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral1.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral2.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral3.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral4.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral5.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_oral6.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_project1.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_project2.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_project3.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_project4.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_midterm.*' => 'nullable|numeric|min:0|max:100',
            'pre_final_final.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // dd($request->all());

        \DB::beginTransaction();
        try {
            $studentIds = $request->input('student_id');

            foreach ($studentIds as $index => $studentId) {
                $updateData = [
                    // Regular term grades
                    'quiz_1' => $request->input("quiz1.{$index}", null),
                    'quiz_2' => $request->input("quiz2.{$index}", null),
                    'quiz_3' => $request->input("quiz3.{$index}", null),
                    'quiz_4' => $request->input("quiz4.{$index}", null),
                    'quiz_5' => $request->input("quiz5.{$index}", null),
                    'quiz_6' => $request->input("quiz6.{$index}", null),
                    'oral_1' => $request->input("oral1.{$index}", null),
                    'oral_2' => $request->input("oral2.{$index}", null),
                    'oral_3' => $request->input("oral3.{$index}", null),
                    'oral_4' => $request->input("oral4.{$index}", null),
                    'oral_5' => $request->input("oral5.{$index}", null),
                    'oral_6' => $request->input("oral6.{$index}", null),
                    'project_1' => $request->input("project1.{$index}", null),
                    'project_2' => $request->input("project2.{$index}", null),
                    'project_3' => $request->input("project3.{$index}", null),
                    'project_4' => $request->input("project4.{$index}", null),
                    'midterm' => $request->input("midterm.{$index}", null),
                    'final' => $request->input("final.{$index}", null),
                    // Pre-final grades
                    'pre_final_quiz_1' => $request->input("pre_final_quiz1.{$index}", null),
                    'pre_final_quiz_2' => $request->input("pre_final_quiz2.{$index}", null),
                    'pre_final_quiz_3' => $request->input("pre_final_quiz3.{$index}", null),
                    'pre_final_quiz_4' => $request->input("pre_final_quiz4.{$index}", null),
                    'pre_final_quiz_5' => $request->input("pre_final_quiz5.{$index}", null),
                    'pre_final_quiz_6' => $request->input("pre_final_quiz6.{$index}", null),
                    'pre_final_oral_1' => $request->input("pre_final_oral1.{$index}", null),
                    'pre_final_oral_2' => $request->input("pre_final_oral2.{$index}", null),
                    'pre_final_oral_3' => $request->input("pre_final_oral3.{$index}", null),
                    'pre_final_oral_4' => $request->input("pre_final_oral4.{$index}", null),
                    'pre_final_oral_5' => $request->input("pre_final_oral5.{$index}", null),
                    'pre_final_oral_6' => $request->input("pre_final_oral6.{$index}", null),
                    'pre_final_project_1' => $request->input("pre_final_project1.{$index}", null),
                    'pre_final_project_2' => $request->input("pre_final_project2.{$index}", null),
                    'pre_final_project_3' => $request->input("pre_final_project3.{$index}", null),
                    'pre_final_project_4' => $request->input("pre_final_project4.{$index}", null),
                    'pre_final_midterm' => $request->input("pre_final_midterm.{$index}", null),
                    'pre_final_final' => $request->input("pre_final_final.{$index}", null),
                ];

                $classRecord = \App\Models\ClassRecord::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'class_id' => $request->class_id[0]
                    ],
                    $updateData
                );

                $classRecordItem = \App\Models\ClassRecordItem::where('class_id', $request->class_id)->first();
                
                if (!$classRecordItem) {
                    \DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Class record items not found.'
                    ], 404);
                }

                // Calculate regular term percentages
                $quizPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'quiz', 6, 0.3);
                $oralPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'oral', 6, 0.2);
                $projectPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'project', 4, 0.1);
                $examPercentage = $this->calculateExamPercentage($classRecord, $classRecordItem, $updateData, ['midterm', 'final'], 0.4);

                // Calculate pre-final percentages
                $preFinalQuizPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'pre_final_quiz', 6, 0.3);
                $preFinalOralPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'pre_final_oral', 6, 0.2);
                $preFinalProjectPercentage = $this->calculateComponentPercentage($classRecord, $classRecordItem, 'pre_final_project', 4, 0.1);
                $preFinalExamPercentage = $this->calculateExamPercentage($classRecord, $classRecordItem, $updateData, ['pre_final_midterm', 'pre_final_final'], 0.4);

                // Calculate final percentages
                $finalPercentage = ($quizPercentage + $oralPercentage + $projectPercentage + $examPercentage);
                $preFinalFinalPercentage = ($preFinalQuizPercentage + $preFinalOralPercentage + $preFinalProjectPercentage + $preFinalExamPercentage);
                
                $finalGradePercentage = ($preFinalFinalPercentage + $finalPercentage) / 2;
                
                $classRecord->update([
                    'final_grade' => $finalGradePercentage,
                    'midterm_grade' => $finalPercentage,
                    'prefinal_grade' => $preFinalFinalPercentage
                ]);
            }

            \DB::commit();
                    // Calculate final percentages
        $finalPercentage = ($quizPercentage + $oralPercentage + $projectPercentage + $examPercentage);
        $preFinalFinalPercentage = ($preFinalQuizPercentage + $preFinalOralPercentage + $preFinalProjectPercentage + $preFinalExamPercentage);
        
        $finalGradePercentage = ($preFinalFinalPercentage + $finalPercentage) / 2;

        $classRecord->update(['final_grade' => $finalGradePercentage, 'midterm_grade' => $finalPercentage, 'prefinal_grade' => $preFinalFinalPercentage]);

        return redirect()
            ->route('instructor.classes.students', ['id' => $request->class_id[0]])
            ->with('success', 'Grades saved successfully.');


        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error saving grades: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving grades. Please try again.'
            ], 500);
        }
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
        $pdf->setPaper('legal', 'portrait');

        return $pdf->stream('gradesheet_summary.pdf');
    }
    public function showClassRecords($classId)
{
    $schoolClass = SchoolClass::findOrFail($classId);
    $students = $schoolClass->section->students()->orderBy('full_name', 'asc')->get(); // Sorted by full name

    return view('instructor.class_records.index', compact('schoolClass', 'students'));
}

}
