<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Listing notifications for authenticated user
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->notifications()->paginate(20)
        );
    }

    // Marking notification as read
    public function markRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();
        return response()->json(['message' => 'Marked as read']);
    }
}
