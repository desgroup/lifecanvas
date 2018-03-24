<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Byte extends Model
{
    use Favoriteable, RecordsActivity;
    use SearchableTrait;

    protected $guarded = [];

    protected $with = ['creator'];

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'story' => 5
        ]
    ];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('commentCount', function ($buiilder) {
//            $buiilder->withCount('comments');
//        });

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

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function timezone()
    {
        return $this->belongsTo('App\Timezone');
    }

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function thumbnail()
    {
        return '/usr/' . $this->user_id . '/thumb/' . $this->asset->file_name;
    }

    public function small()
    {
        return '/usr/' . $this->user_id . '/small/' . $this->asset->file_name;
    }

    public function medium()
    {
        return '/usr/' . $this->user_id . '/medium/' . $this->asset->file_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }


    public function favorite()
    {
        if(! $this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class)->withTimestamps();
    }
}
