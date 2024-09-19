<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;


class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::all();
        return view('admin.rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rates.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
        ]);

        $rate = Rate::create([
            'name' => $request->input('name'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()->route('admin.rates.index')->with('success', 'Rate added successfully.');
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
        $rate = Rate::findOrFail($id);
        return view('admin.rates.update', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
        ]);

        $rate = Rate::findOrFail($id);
        $rate->update([
            'name' => $request->input('name'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()->route('admin.rates.index')->with('success', 'Rate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        return redirect()->route('admin.rates.index')->with('success', 'Rate deleted successfully.');
    }
}
