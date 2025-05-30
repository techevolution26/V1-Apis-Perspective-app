<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    // Follow a user
    public function follow(Request $request, $id)
    {
        if ($request->user()->id == $id) {
            return response()->json(['error' => 'You cannot follow yourself'], 400);
        }

        $other = User::findOrFail($id);

        // detach first to avoid duplicate‐key errors
        $request->user()->following()->detach($other->id);
        $request->user()->following()->attach($other->id);

        return response()->json(['message' => 'Now following user ' . $id], 200);
    }

    // Unfollowing a user
    public function unfollow(Request $request, $id)
    {
        $other = User::findOrFail($id);
        $request->user()->following()->detach($other->id);

        return response()->json(['message' => 'Unfollowed user ' . $id], 200);
    }

    // Listing followers of a user
    public function followers($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user->followers()->paginate(20));
    }

    // List users the user is following
    public function following($id)
    {
        // user exists??
        User::findOrFail($id);

        // the list of users $id is following
        $following = User::whereIn(
            'id',
            Follow::where('follower_id', $id)->pluck('followed_id')
        )
            ->select('id', 'name', 'avatar_url', 'profession')
            ->get();

        return response()->json($following);
    }
}
