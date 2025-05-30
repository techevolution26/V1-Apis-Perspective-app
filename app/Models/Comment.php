<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'perception_id',
        'parent_comment_id',
        'body',
        'media_url',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id')
            ->with('user')
            ->with('replies');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function perception()
    {
        return $this->belongsTo(Perception::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
