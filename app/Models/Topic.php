<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'description'];

    public function perceptions()
    {
        return $this->hasMany(Perception::class);
    }
}
