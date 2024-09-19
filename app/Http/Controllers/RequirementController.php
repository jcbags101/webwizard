<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requirement;


class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $requirements = Requirement::all();
        return view('admin.requirements.index', compact('requirements'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.requirements.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $requirement = Requirement::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requirement added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $requirement = Requirement::findOrFail($id);
        return view('admin.requirements.edit', compact('requirement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $requirement = Requirement::findOrFail($id);
        $requirement->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.requirements.index')->with('success', 'Requirement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $requirement = Requirement::findOrFail($id);
        $requirement->delete();

        return redirect()->route('admin.requirements.index')->with('success', 'Requirement deleted successfully.');
    }
}