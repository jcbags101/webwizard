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
            if (isset($updateData[$field]) && $classRecordItem->$field) {
                $percentage = ($updateData[$field] / $classRecordItem->$field) * 100;
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
        $this->validateRequest($request);
        $updateData = $this->prepareUpdateData($request);
        
        $classRecord = \App\Models\ClassRecord::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'class_id' => $request->class_id
            ],
            $updateData
        );

        $classRecordItem = \App\Models\ClassRecordItem::where('class_id', $request->class_id)->first();
        
        if (!$classRecordItem) {
            return redirect()
                ->route('instructor.classes.students', ['id' => $request->class_id])
                ->with('error', 'Class record items not found.');
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

        $classRecord->update(['final_grade' => $finalGradePercentage, 'midterm_grade' => $finalPercentage, 'prefinal_grade' => $preFinalFinalPercentage]);

        return redirect()
            ->route('instructor.classes.students', ['id' => $request->class_id])
            ->with('success', 'Grades saved successfully.');
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

