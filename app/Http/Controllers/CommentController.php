<?php

namespace App\Http\Controllers;

use App\Models\Perception;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // GET /api/perceptions/{id}/comments
    public function index($perceptionId)
    {

        $comments = Comment::with(['user', 'replies'])   // eager‐load top‐level replies (and theirs)
            ->where('perception_id', $perceptionId)
            ->whereNull('parent_comment_id')            // only roots
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    // POST /api/perceptions/{id}/comments
    public function store(Request $request, $perceptionId)
    {
        $data = $request->validate([
            'body'           => 'required_without:media|string',
            'media'          => 'nullable|file|mimes:jpeg,png,gif,mp4,webm|max:10240',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        if ($file = $request->file('media')) {
            $path = $file->store('comments_media', 'public');
            $data['media_url'] = url("storage/$path");
        }

        $comment = Comment::create([
            'user_id'           => $request->user()->id,
            'perception_id'     => $perceptionId,
            'parent_comment_id' => $data['parent_comment_id'] ?? null,
            'body'              => $data['body'] ?? null,
            'media_url'         => $data['media_url'] ?? null,
        ]);

        return response()->json($comment->load('user'), 201);
    }
}
