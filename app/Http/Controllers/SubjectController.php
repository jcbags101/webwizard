<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
   {
       $subjects = Subject::all();
       return view('admin.subjects.index', compact('subjects'));
   }

    public function create()
    {
        return view('admin.subjects.add');
    }

    public function store(Request $request)
    {

        $subject = Subject::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'code' => $request->input('code'),
            'units' => $request->input('units'),
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.update', compact('subject'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|max:50',
            'units' => 'required|integer|min:1',
        ]);
 
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'code' => $request->input('code'),
            'units' => $request->input('units'),
        ]);
 
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }
 
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
 
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
