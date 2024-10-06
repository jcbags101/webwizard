<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRecord;


class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $grades = ClassRecord::all();
        return view('instructor.grades.index', compact('grades'));
    }


}
