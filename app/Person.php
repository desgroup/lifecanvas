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

    public function byteImage ()
    {
        return $this->bytes()->whereNotNull('asset_id')->orderBy('created_at', 'DESC')->first();
    }

}
