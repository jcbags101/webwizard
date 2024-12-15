<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function notifyInstructors(Request $request)
    {
        // Get all instructors
        $instructors = \App\Models\User::where('role', 'instructor')->get();

        
        // Send notification to each instructor
        foreach ($instructors as $instructor) {
            $instructor->notify(new \App\Notifications\GeneralNotification([
                'title' => 'Requirements Update',
                'message' => $request->message,
                'sender' => auth()->user()->name,
                'type' => 'warning',
                'link' => route('instructor.requirements.index')
            ]));
        }

        return redirect()->back()->with('success', 'Notification sent to all instructors successfully');
    }

    public function notifyInstructor(Request $request)
    {
        $instructor = \App\Models\Instructor::find($request->instructor_id);
        $instructor->user->notify(new \App\Notifications\GeneralNotification([
            'title' => 'Requirements Update',
            'message' => $request->message,
            'type' => 'warning',
            'sender' => auth()->user()->name,
            'link' => route('instructor.requirements.index')
        ]));

        return redirect()->back()->with('success', 'Notification sent to instructor successfully');
    }
}
