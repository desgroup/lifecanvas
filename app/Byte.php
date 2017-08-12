<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byte extends Model
{
    use Favoriteable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($buiilder) {
            $buiilder->withCount('comments');
        });

        static::deleting(function ($thread) {
            $thread->comments->each->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function people()
    {
        return $this->belongsToMany('App\Person')->withTimestamps();
    }

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function thumbnail()
    {
        return '/usr/' . auth()->id() . '/thumb/' . $this->asset->file_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     *
     */
    public function favorite()
    {
        if(! $this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

}
