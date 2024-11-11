<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedRequirement;
use App\Models\Requirement;
use App\Models\SchoolClass;

class SubmittedRequirementController extends Controller
{
    public function dashboard()
    {
        return view('instructor.dashboard');
    }

    public function index(Request $request)
    {
        $instructor = \App\Models\Instructor::where('email', auth()->user()->email)->first();
        $query = SubmittedRequirement::where('instructor_id', $instructor->id)
            ->whereHas('class', function($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            });

        if ($request->has('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $requirements = $query->get();
        return view('instructor.requirements.index', compact('requirements'));
    }
    
    public function create()
    {
        $requirements = Requirement::all();
        $classes = SchoolClass::all();
        return view('instructor.requirements.add', compact('requirements', 'classes'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'requirement_id' => 'required|exists:requirements,id',
                'file' => 'required|file|mimes:pdf,doc,docx',
                'class_id' => 'required|exists:classes,id',
            ]);
    
            \Log::info('Request Data:', $request->all());
    
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('submitted_requirements', 'public');
            }
    
            SubmittedRequirement::create([
                'requirement_id' => $request->input('requirement_id'),
                'file' => $filePath,
                'instructor_id' => \App\Models\Instructor::where('email', auth()->user()->email)->first()->id,
                'class_id' => $request->input('class_id'),
            ]);
    
            return redirect()->route('instructor.requirements.create')->with('success', 'Submitted Requirement added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('instructor.requirements.create')->with('error', 'An error occurred while adding the submitted requirement.');
        }
    }

    public function edit($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $requirements = Requirement::all();
        $classes = SchoolClass::all();
        return view('instructor.requirements.update', compact('submittedRequirement', 'requirements', 'classes'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'requirement_id' => 'required|exists:requirements,id',
            'class_id' => 'required|exists:classes,id',
        ]);
 
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->update([
            'requirement_id' => $request->input('requirement_id'),
            'file' => $request->input('file') ?? $submittedRequirement->file,
            'class_id' => $request->input('class_id'),
        ]);
 
        return redirect()->route('instructor.requirements.index')->with('success', 'Submitted Requirement updated successfully.');
    }
 
    public function destroy($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->delete();
 
        return redirect()->route('instructor.requirements.index')->with('success', 'Submitted Requirement deleted successfully.');
    }
}
