<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['from_user_id', 'to_user_id', 'body'];

    // Sender
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // Recipient
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // Scope to only unread messages
    public function scopeUnread(Builder $q)
    {
        return $q->whereNull('read_at');
    }
}
