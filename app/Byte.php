<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byte extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/bytes/' . $this->id;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }
}
