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
        $query = SubmittedRequirement::where('instructor_id', $instructor->id);

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
            ]);
    

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('submitted_requirements', 'public');
            }
    
            SubmittedRequirement::create([
                'requirement_id' => $request->input('requirement_id'),
                'file' => $filePath,
                'instructor_id' => \App\Models\Instructor::where('email', auth()->user()->email)->first()->id,
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
        try {
            $request->validate([
                'requirement_id' => 'required|exists:requirements,id',
            ]);
    
            $submittedRequirement = SubmittedRequirement::findOrFail($id);

            $filePath = null;
            
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('submitted_requirements', 'public');
            }

            $submittedRequirement->update([
                'requirement_id' => $request->input('requirement_id'),
                'file' => $filePath ?? $submittedRequirement->file,
                'edit_status' => 'pending'
            ]);
 
            return redirect()->route('instructor.requirements.index')->with('success', 'Submitted Requirement updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('instructor.requirements.index')->with('error', 'An error occurred while updating the submitted requirement.');
        }
    }
 
    public function destroy($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->delete();
 
        return redirect()->route('instructor.requirements.index')->with('success', 'Submitted Requirement deleted successfully.');
    }

    public function requestEdit($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->update(['edit_status' => 'request_submitted']);
        return redirect()->route('instructor.requirements.index')->with('success', 'Request for edit sent successfully.');
    }
}
