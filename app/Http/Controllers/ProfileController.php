<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perception;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfile(Request $r)
    {
        $user = $r->user();

        $data = $r->validate([
            'profession'  => 'nullable|string|max:255',
            'bio'         => 'nullable|string|max:1000',
            'avatar'      => 'nullable|image|max:8192',
        ]);

        // handling avatar upload
        if ($r->hasFile('avatar')) {
            // deleting old?
            $path = $r->file('avatar')->store('avatars', 'public');
            $user->avatar_url = Storage::url($path);
        }

        $user->profession = $data['profession'] ?? $user->profession;
        $user->bio        = $data['bio']        ?? $user->bio;
        $user->save();

        return response()->json($user);
    }

    //GET /api/user{id}
    public function show($id)
    {
        $user = User::withCount(['perceptions', 'followers', 'following'])
            ->findOrFail($id, ['id', 'name', 'email', 'bio', 'avatar_url', 'profession', 'created_at']);

        return response()->json($user);
    }

    public function perceptions($id)
    {
        // Verifying the user exists
        User::findOrFail($id);

        // -loading user, topic, and counts on each perception
        $perceptions = Perception::with([
            'user:id,name,avatar_url',
            'topic:id,name'
        ])
            ->withCount(['likes', 'comments'])
            ->where('user_id', $id)
            ->latest()
            ->get();

        return response()->json($perceptions);
    }
}
