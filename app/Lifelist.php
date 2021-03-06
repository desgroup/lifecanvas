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

    public function listImage ()
    {
        return $this->goals()->whereNotNull('asset_id')->orderBy('created_at', 'DESC')->first();;
    }
}
