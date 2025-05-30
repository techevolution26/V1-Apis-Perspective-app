<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $user->likes()->firstOrCreate(['perception_id' => $id]);

        // total likes on that perception:
        $count = Like::where('perception_id', $id)->count();

        return response()->json([
            'liked'       => true,
            'likes_count' => $count,
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $user->likes()->where('perception_id', $id)->delete();

        $count = Like::where('perception_id', $id)->count();

        return response()->json([
            'liked'       => false,
            'likes_count' => $count,
        ], 200);
    }
}
