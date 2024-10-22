<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
       $users = User::all();
       return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_type' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        \Log::info('Request Data:', $request->all());

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'user_type' => $request->input('user_type'),
            'role' => 'admin',
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('admin.users.create')->with('success', 'User added successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.update', compact('user'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'user_type' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
 
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'user_type' => $request->input('user_type'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
        ]);
 
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
 
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
 
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
