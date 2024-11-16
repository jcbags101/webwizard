<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRecordItem;

class ClassRecordItemController extends Controller
{
    public function index()
    {
        return view('instructor.class-record-items.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'quiz1_items' => 'nullable|decimal:0,2|min:1',
            'quiz2_items' => 'nullable|decimal:0,2|min:1',
            'quiz3_items' => 'nullable|decimal:0,2|min:1',
            'quiz4_items' => 'nullable|decimal:0,2|min:1',
            'quiz5_items' => 'nullable|decimal:0,2|min:1', 
            'quiz6_items' => 'nullable|decimal:0,2|min:1',
            'oral1_items' => 'nullable|decimal:0,2|min:1',
            'oral2_items' => 'nullable|decimal:0,2|min:1',
            'oral3_items' => 'nullable|decimal:0,2|min:1',
            'oral4_items' => 'nullable|decimal:0,2|min:1',
            'oral5_items' => 'nullable|decimal:0,2|min:1',
            'oral6_items' => 'nullable|decimal:0,2|min:1',
            'project1_items' => 'nullable|decimal:0,2|min:1',
            'project2_items' => 'nullable|decimal:0,2|min:1',
            'project3_items' => 'nullable|decimal:0,2|min:1',
            'project4_items' => 'nullable|decimal:0,2|min:1',
            'midterm_exam_items' => 'nullable|decimal:0,2|min:1',
            'final_exam_items' => 'nullable|decimal:0,2|min:1'
        ]);

        $updateData = [];
        
        // Quiz scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("quiz{$i}_items")) {
                $updateData["quiz_{$i}"] = $request->{"quiz{$i}_items"};
            }
        }
        
        // Oral scores
        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("oral{$i}_items")) {
                $updateData["oral_{$i}"] = $request->{"oral{$i}_items"};
            }
        }
        
        // Project scores
        for ($i = 1; $i <= 4; $i++) {
            if ($request->has("project{$i}_items")) {
                $updateData["project_{$i}"] = $request->{"project{$i}_items"};
            }
        }
        
        // Exam scores
        if ($request->has('midterm_exam_items')) {
            $updateData['midterm'] = $request->midterm_exam_items;
        }
        if ($request->has('final_exam_items')) {
            $updateData['final'] = $request->final_exam_items;
        }

        
        $classRecordItem = \App\Models\ClassRecordItem::updateOrCreate(
            [
                'class_id' => $request->class_id
            ],
            $updateData
        );

        return redirect()->route('instructor.classes.students', ['id' => $request->class_id])->with('success', 'Class record items saved successfully.');
    }
}