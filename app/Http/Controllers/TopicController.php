<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    // Listing all topics

    public function index()
    {
        $topics = \App\Models\Topic::select('id', 'name', 'description', 'image_url')->get();

        return response()->json([
            'topics' => $topics
        ]);
    }

    // Show a topic and its perceptions
    public function show($id)
    {
        $topic = Topic::with('perceptions.user')->findOrFail($id);
        return response()->json($topic);
    }
}
