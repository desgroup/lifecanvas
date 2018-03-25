<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lists()
    {
        return $this->belongsToMany('App\Lifelist')->withTimestamps();
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

    public function bytes()
    {
        return $this->belongsToMany(Byte::class)->withTimestamps();
    }

    public function byteImage ()
    {
        return $this->bytes()->whereNotNull('asset_id')->orderBy('created_at', 'DESC')->first();
    }
}
