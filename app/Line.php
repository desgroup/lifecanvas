<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function bytes()
    {
        return $this->belongsToMany(Byte::class)->withTimestamps();
    }

    public function byteImage ()
    {
        return $this->bytes()->whereNotNull('asset_id')->orderBy('created_at', 'DESC')->first();
    }
}
