<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $fillable = ['user_id', 'perception_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perception()
    {
        return $this->belongsTo(Perception::class);
    }
}
