<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedRequirement;
use App\Models\Requirement;
use App\Models\SchoolClass;
use App\Models\Instructor;
class AdminSubmittedRequirementController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index(Request $request)
    {
        $instructor_id = $request->query('instructor_id');
        

        \Log::info('Instructor ID: ' . $instructor_id);
        if ($instructor_id) {
            if (auth()->user()->user_type === 'DOI') {
                $requirements = SubmittedRequirement::where('instructor_id', $instructor_id)
                    ->whereIn('status', ['chairman_approved', 'accepted'])
                    ->get();
            } else {
                $requirements = SubmittedRequirement::where('instructor_id', $instructor_id)->get();
            }
        } else {
            if (auth()->user()->user_type === 'DOI') {
                $requirements = SubmittedRequirement::whereIn('status', ['chairman_approved', 'accepted'])->get();
            } else {
                $requirements = SubmittedRequirement::all();
            }
        }

        if ($request->has('edit_status')) {
            $requirements = $requirements->where('edit_status', $request->edit_status);
        }

        $instructors = Instructor::all();

        return view('admin.submitted_requirements.index', compact('requirements', 'instructors'));
    }

    public function edit(string $id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $requirements = Requirement::all();
        $schoolClasses = SchoolClass::all();
        return view('admin.submitted_requirements.update', compact('submittedRequirement', 'requirements', 'schoolClasses'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,accepted,rejected,chairman_approved',
            'remarks' => 'nullable|string|max:255',
        ]);
 
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->update([
            'status' => $request->input('status'),
            'remarks' => $request->input('remarks'),
        ]);
 
        return redirect()->route('admin.submitted_requirements.index')->with('success', 'Submitted Requirement status and remarks updated successfully.');
    }

    public function destroy($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->delete();

        return redirect()->route('admin.submitted_requirements.index')->with('success', 'Submitted Requirement deleted successfully.');
    }

    public function approveEdit($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->update(['edit_status' => 'approved']);
        return redirect()->route('admin.submitted_requirements.index')->with('success', 'Edit request approved successfully.');
    }

    public function showLateMessage($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        return view('admin.submitted_requirements.late_message', compact('submittedRequirement'));
    }

    public function activityLogs($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $activityLogs = $submittedRequirement->activityLogs ?? [];
        return view('admin.submitted_requirements.activity_logs', compact('submittedRequirement', 'activityLogs'));
    }
}
