<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    protected $guarded = [];

    public function timezone()
    {
        return $this->belongsTo('App\Timezone');
    }

}
