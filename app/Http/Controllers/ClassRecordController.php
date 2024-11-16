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
        100 => 1.00, 99 => 1.10, 98 => 1.20, 97 => 1.30, 96 => 1.40, 95 => 1.50, 94 => 1.60, 93 => 1.60, 92 => 1.70,
        91 => 1.70, 90 => 1.80, 89 => 1.80, 88 => 1.90, 87 => 1.90, 86 => 2.00, 85 => 2.00, 84 => 2.10, 83 => 2.10,
        82 => 2.20, 81 => 2.20, 80 => 2.30, 79 => 2.30, 78 => 2.40, 77 => 2.40, 76 => 2.50, 75 => 2.50, 74 => 2.60,
        73 => 2.60, 72 => 2.70, 71 => 2.70, 70 => 2.80, 69 => 2.80, 68 => 2.90, 67 => 2.90, 66 => 3.00, 65 => 3.00,
        64 => 3.10, 63 => 3.10, 62 => 3.20, 61 => 3.20, 60 => 3.30, 59 => 3.30, 58 => 3.40, 57 => 3.40, 56 => 3.50,
        55 => 3.50, 54 => 3.60, 53 => 3.60, 52 => 3.70, 51 => 3.70, 50 => 3.80, 49 => 3.80, 48 => 3.90, 47 => 3.90,
        46 => 4.00, 45 => 4.00, 44 => 4.10, 43 => 4.10, 42 => 4.20, 41 => 4.20, 40 => 4.30, 39 => 4.30, 38 => 4.40,
        37 => 4.40, 36 => 4.50, 35 => 4.50, 34 => 4.60, 33 => 4.60, 32 => 4.70, 31 => 4.70, 30 => 4.80, 29 => 4.80,
        28 => 4.90, 27 => 4.90, 26 => 5.00
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
            'final_grade' => 'nullable|numeric|min:0|max:100'
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

        // Calculate final percentage
        $finalPercentage = ($quizPercentage + $oralPercentage + $projectPercentage + $examPercentage) * 100;

        // Get transmuted grade
        $finalGrade = 5.0; // Default to lowest grade
        foreach ($this->transmutationTable as $percentage => $grade) {
            if ($finalPercentage >= $percentage) {
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

