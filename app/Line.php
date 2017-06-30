<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $guarded = [];

    public function bytes()
    {
        return $this->belongsToMany(Byte::class);
    }
}
