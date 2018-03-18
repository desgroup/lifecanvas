<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lifelist extends Model
{
    protected $guarded = [];

    public function goals()
    {
        return $this->belongsToMany(Goal::class)->withTimestamps();
    }
}
