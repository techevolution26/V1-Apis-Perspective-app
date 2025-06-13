<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motivation extends Model
{
    //
    protected $fillable = ['body', 'topic_id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
