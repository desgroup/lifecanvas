<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myBytes() {
        return $this->hasMany('App\Byte');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myLines() {
        return $this->hasMany('App\Line');
    }

    public function bytes()
    {
        return $this->hasMany(Byte::class)->latest();
    }

    /**
     * Changes the binding reference to username vs id for route model binding
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }
}
