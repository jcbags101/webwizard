<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function dashboard()
    {
        return view('instructor.dashboard');
    }

    public function index()
    {
       $instructors = Instructor::all();
       return view('admin.instructor.index', compact('instructors'));
    }

    public function create()
    {
        return view('admin.instructor.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:instructors,email',
        ]);

        \Log::info('Request Data:', $request->all());

        $instructor = Instructor::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'department' => $request->input('department'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        ]);

        \App\Models\User::create([
            'name' => $instructor->full_name,
            'email' => $instructor->email,
            'username' => $instructor->username,
            'password' => $instructor->password,
            'role' => 'instructor',
        ]);

        return redirect()->route('admin.instructors.create')->with('success', 'Instructor added successfully.');
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('admin.instructor.update', compact('instructor'));
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

        $user = \App\Models\User::where('email', $instructor->email)->first();
        if ($user) {
            $user->delete();
        }
 
        return redirect()->route('admin.instructors.index')->with('success', 'Instructor deleted successfully.');
    }
}
