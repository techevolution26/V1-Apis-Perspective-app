<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Listing notifications for authenticated user
    public function index(Request $r)
    {
        return $r->user()->notifications()->paginate(20);
    }

    public function read(Request $r, $id)
    {
        $note = $r->user()->notifications()->findOrFail($id);
        $note->markAsRead();
        return response()->json(['ok']);
    }

    public function readAll(Request $r)
    {
        $r->user()->unreadNotifications->markAsRead();
        return response()->json(['ok']);
    }
    //delete
    public function destroy(Request $r, $id)
    {
        $note = $r->user()->notifications()->findOrFail($id);
        $note->delete();
        return response()->json(['ok']);
    }
    //delete all
    public function deleteAll(Request $r)
    {
        $r->user()->notifications()->delete();
        return response()->json(['ok']);
    }
}
