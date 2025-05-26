<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'perception_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function perception() {
        return $this->belongsTo(Perception::class);
    }

    public function comments() {
    return $this->hasMany(Comment::class);
}

}
