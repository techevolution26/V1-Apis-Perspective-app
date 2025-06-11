<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicFollowController extends Controller
{
    // PUT or POST /api/topics/{id}/follow
    public function follow(Request $r, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->followers()->syncWithoutDetaching($r->user()->id);
        return response()->json(['followed' => true], 200);
    }

    // DELETE /api/topics/{id}/follow
    public function unfollow(Request $r, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->followers()->detach($r->user()->id);
        return response()->json(['followed' => false], 200);
    }
}
