<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function bytes()
    {
        return $this->hasMany(Byte::class);
    }

    public function timezone()
    {
        return $this->belongsTo('App\Timezone');
    }

}
