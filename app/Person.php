<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function bytes()
    {
        return $this->belongsToMany(Byte::class);
    }
}
