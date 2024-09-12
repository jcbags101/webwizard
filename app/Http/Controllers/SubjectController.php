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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
 
        $instructor = Instructor::findOrFail($id);
        $instructor->update([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'department' => $request->input('department'),
            'username' => $request->input('username'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $instructor->password,
        ]);
 
        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully.');
    }
 
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();
 
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully.');
    }
}
