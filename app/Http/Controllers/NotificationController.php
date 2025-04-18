<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = Notification::orderBy('created_at', 'desc')->get();
    $user=User::all();
    return view('notification.index', compact('notifications','user'));
}
    // Get all notifications for a specific user
    public function IndexApi(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)
                                     ->orderBy('created_at', 'desc')
                                     ->get();
        return response()->json($notifications);
    }
    public function create()
    {
        $user=User::all();
        return view('notification.create',compact('user'));
    }
    // Store a new notification
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'type' => 'required|string',
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'type' => $request->type,
            'read_status' => false,
        ]);

        return response()->json($notification, 201);
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_status' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    // Delete a notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
