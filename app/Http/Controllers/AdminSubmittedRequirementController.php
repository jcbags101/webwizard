<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedRequirement;
use App\Models\Requirement;
use App\Models\SchoolClass;

class AdminSubmittedRequirementController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function index()
    {
       $requirements = SubmittedRequirement::all();
       return view('admin.submitted_requirements.index', compact('requirements'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,accepted,rejected',
        ]);
 
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->update([
            'status' => $request->input('status'),
        ]);
 
        return redirect()->route('admin.submitted_requirements.index')->with('success', 'Submitted Requirement status updated successfully.');
    }

    public function destroy($id)
    {
        $submittedRequirement = SubmittedRequirement::findOrFail($id);
        $submittedRequirement->delete();

        return redirect()->route('admin.submitted_requirements.index')->with('success', 'Submitted Requirement deleted successfully.');
    }
}
