<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function bytes()
    {
        return $this->belongsToMany(Byte::class);
    }
}
