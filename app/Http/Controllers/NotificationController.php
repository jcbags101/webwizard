<?php

namespace App\Http\Controllers;

use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->notifications;
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications->where('id', $id)->markAsRead();
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function send(Request $request)
    {
        $user = User::find($request->user_id);
        $user->notify(new GeneralNotification([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type ?? 'info',
            'sender' => auth()->user()->name,
            'link' => $request->link
        ]));

        return response()->json(['success' => true]);
    }
}