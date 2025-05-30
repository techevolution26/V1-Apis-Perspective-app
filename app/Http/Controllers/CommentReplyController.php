<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    // List all replies for a given comment
    public function index($commentId)
    {
        $comment = Comment::with(['replies.user'])->findOrFail($commentId);
        return response()->json($comment->replies);
    }

    // Store a new reply
    public function store(Request $request, $commentId)
    {
        $data = $request->validate([
            'body'    => 'required_without:media|string',
            'media'   => 'nullable|file|mimes:jpeg,png,gif,mp4,webm|max:10240',
        ]);

        // handle optional media upload (same as top-level comments)
        if ($file = $request->file('media')) {
            $path = $file->store('comments_media', 'public');
            $data['media_url'] = url("storage/{$path}");
        }

        $parent = Comment::findOrFail($commentId);

        $reply = Comment::create([
            'user_id'           => $request->user()->id,
            'perception_id'     => $parent->perception_id,
            'parent_comment_id' => $parent->id,
            'body'              => $data['body'] ?? null,
            'media_url'         => $data['media_url'] ?? null,
        ]);

        return response()->json(
            $reply->load('user'),
            201
        );
    }
}
