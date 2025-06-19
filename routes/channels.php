<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('conversations.{peerId}', function ($user, $peerId) {
    return Message::where(fn($q) =>
        ($q->where('from_user_id', $user->id)->where('to_user_id', $peerId))
        ->orWhere(function ($q2) use ($user, $peerId) {
            $q2->where('from_user_id', $peerId)->where('to_user_id', $user->id);
        })
    )->exists();
});

// Broadcast::channel('conversations.{peerId}', function ($user, $peerId) {
//     Log::info('Broadcast channel hit', ['user' => $user?->id, 'peerId' => $peerId]);

//     return true; // always allow (just for debugging)
// });

