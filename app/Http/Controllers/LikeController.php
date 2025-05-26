<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Like a perception
    public function store(Request $request, $id)
    {
        $like = $request->user()->likes()->firstOrCreate([ 'perception_id' => $id ]);
        return response()->json($like, 201);
    }

    // Unlike a perception
    public function destroy(Request $request, $id)
    {
        $request->user()->likes()->where('perception_id', $id)->delete();
        return response()->json(['message' => 'Unliked']);
    }
}
