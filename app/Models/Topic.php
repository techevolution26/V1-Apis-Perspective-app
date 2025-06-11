<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'description', 'image_url'];

    public function perceptions()
    {
        return $this->hasMany(Perception::class);
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'topic_follows')
            ->withTimestamps();
    }
}
