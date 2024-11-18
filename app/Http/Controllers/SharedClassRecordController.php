<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;

class SharedClassRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $instructor = \App\Models\Instructor::where('email', $user->email)->first();
        $sharedClasses = $instructor->sharedClasses()
            ->with(['section', 'subject', 'instructor'])
            ->get();

        return view('instructor.shared-records.index', [
            'sharedClasses' => $sharedClasses
        ]);
    }

    public function show(string $id)
    {
        $sharedRecord = \App\Models\SharedClassRecord::findOrFail($id);
        $schoolClass = $sharedRecord->schoolClass;
        $students = $schoolClass->section->students ?? collect();
        $instructors = Instructor::where('id', '!=', auth()->user()->instructor->id)->get();

        return view('instructor.classes.students', compact('schoolClass', 'students', 'instructors'));
    }
}
