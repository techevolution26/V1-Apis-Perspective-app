<?php

namespace App\Http\Controllers;

use App\Models\Perception;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // GET /api/perceptions/{id}/comments
    public function index($id)
    {
        $perception = Perception::findOrFail($id);
        $comments = $perception
            ->comments()
            ->with('user:id,name')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($comments);
    }

    // POST /api/perceptions/{id}/comments
    public function store(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $perception = Perception::findOrFail($id);

        $comment = $perception->comments()->create([
            'user_id' => $request->user()->id,
            'body'    => $request->body,
        ]);

        // $comment = new Comment(['body' => $request ->body]);
        // $comment->user()->associate($request->user());
        // $comment->perception()->associate($perception);
        // $comment->save();

        // load the user relationship
        $comment->load('user:id,name');

        return response()->json($comment, 201);
    }
}
