<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function profile()
    {
        $instructor = Auth::user()->instructor;
        return view('instructor.profile.index', compact('instructor'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $instructor = Auth::user()->instructor;
        $passwordChanged = false;
        
        if ($request->password) {
            $passwordChanged = true;
        }
        
        $instructor->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'position' => $request->position,
            'department' => $request->department,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $instructor->password,
            'profile_image' => $request->hasFile('profile_image') ? $request->file('profile_image')->store('profile_images', 'public') : $instructor->profile_image,
        ]);

        // Update associated user record
        $user = Auth::user();
        $user->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($passwordChanged) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Profile updated successfully. Please login with your new password.');
        }

        return redirect()->route('instructor.profile')->with('success', 'Profile updated successfully.');
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
