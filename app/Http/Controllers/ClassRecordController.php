<?php

namespace App\Http\Controllers;

use App\Imports\ClassRecordsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClassRecordController extends Controller
{
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
}

