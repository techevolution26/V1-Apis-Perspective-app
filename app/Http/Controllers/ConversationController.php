<?php


namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * GET /api/conversations
     * Returns a list of users you’ve ever chatted with, plus unread counts.
     */
    public function index(Request $request)
    {
        return $request->user()
            ->conversations()
            ->get()
            ->makeHidden(['email', 'password', 'remember_token']);
    }

    /**
     * GET /api/conversations/{peer}
     * Returns the last 50 messages between you and $peer,
     * and marks the peer’s messages as read.
     */
    public function show(Request $request, User $peer)
    {
        $me = $request->user();

        // fetch last 50 messages b/w us
        $msgs = Message::whereIn('from_user_id', [$me->id, $peer->id])
            ->whereIn('to_user_id',   [$me->id, $peer->id])
            ->orderBy('created_at')
            ->limit(50)
            ->get();

        // mark all peer->me messages as read
        Message::where('from_user_id', $peer->id)
            ->where('to_user_id', $me->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return $msgs;
    }

    /**
     * POST /api/conversations/{peer}
     * Store a new message and (optionally) broadcast it.
     */
    // public function store(Request $request, User $peer)
    // {
    //     $me = $request->user();

    //     $data = $request->validate([
    //         'body' => 'required|string',
    //     ]);

    //     $message = Message::create([
    //         'from_user_id' => $me->id,
    //         'to_user_id'   => $peer->id,
    //         'body'          => $data['body'],
    //     ]);

    //     // OPTIONAL: broadcast to the recipient
    //     broadcast(new NewMessage($message))->toOthers();

    //     return response()->json($message, 201);
    // }

public function store(Request $req, $peerId)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    $message = Message::create([
        'from_user_id' => $user->id,
        'to_user_id'   => $peerId,
        'body'         => $req->body,
    ]);

    // fire it to _all_ subscribers
    broadcast(new \App\Events\NewMessage($message));

    return response()->json($message, 201);
}

    /**
     * Send a message to a peer.
     *
     * @param Request $request
     * @param User $peer
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request, User $peer)
    {
        $me = $request->user();

        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'from_user_id' => $me->id,
            'to_user_id'   => $peer->id,
            'body'         => $data['body'],
        ]);

        broadcast(new NewMessage($message))->toOthers();

        return response()->json($message, 201);
    }

}
