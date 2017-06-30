<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byte extends Model
{
    protected $guarded = [];

    /**
     * @return string
     */
    public function path()
    {
        return '/bytes/' . $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lines()
    {
        return $this->belongsToMany('App\Line')->withTimestamps();
    }
}
