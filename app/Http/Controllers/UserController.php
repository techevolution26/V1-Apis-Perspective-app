<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;

class UserController extends Controller
{
    // Show authenticated user's profile
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // Update authenticated user's profile
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'bio'  => 'sometimes|string|max:500',
        ]);

        $user = $request->user();
        $user->update($data);

        return response()->json($user);
    }

    // Show any user's public profile
    public function showPublic($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    // Search for users by name or email or profession
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('profession', 'like', "%{$query}%")
            ->get();

        return response()->json($users);
    }
}
