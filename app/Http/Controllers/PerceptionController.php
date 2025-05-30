<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perception;
use Illuminate\Support\Facades\Storage;

class PerceptionController extends Controller
{
    // Listing perceptions (feed)
    public function index(Request $request)
    {
        // optionally filter by topic_id=$r->topic_id
        $query = Perception::with([
            'user:id,name,avatar_url',
            'topic:id,name'
        ])->withCount(['likes', 'comments'])
            ->latest();

        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        return $query->get();
    }


    // Store a new perception
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
            'media_url' => 'nullable|url|max:8192', // optional media URL
        ]);

        $perception = new Perception([
            'user_id'  => $request->user()->id,
            'topic_id' => $request->input('topic_id'),
            'body'     => $request->input('body'),
        ]);

        if ($request->has('media')) {
            $path = $request->file('media')->store('perceptions', 'public');
            $perception->media_url = url(Storage::url($path));
        }

        $perception->save();

        $perception->load('user:id,name,avatar_url', 'topic:id,name');
        $perception->loadCount(['likes', 'comments']);

        return response()->json($perception, 201);
    }


    // Show a specific perception
     public function show($id)
    {
        $perception = Perception::with([
            'user:id,name,avatar_url',
            'topic:id,name',
            'comments.user:id,name,avatar_url'  // if you eager‐load comments
        ])->withCount(['likes','comments'])
          ->findOrFail($id);

        return response()->json($perception);
    }

    // Show perceptions by topic
    public function byTopic(Request $r, $id)
    {
        $perceptions = Perception::with(['user:id,name', 'topic:id,name'])
            ->withCount(['likes', 'comments'])
            ->where('topic_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($perceptions);
    }


    // Update own perception
    public function update(Request $request, $id)
    {
        $perception = Perception::where('user_id', $request->user()->id)->findOrFail($id);

        $data = $request->validate([
            'body'     => 'sometimes|string|max:280',
            'topic_id' => 'sometimes|exists:topics,id',
        ]);

        $perception->update($data);
        return response()->json($perception);
    }

    // Delete own perception
    public function destroy(Request $request, $id)
    {
        $perception = Perception::where('user_id', $request->user()->id)->findOrFail($id);
        $perception->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
