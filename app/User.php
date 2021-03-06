<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'birthdate', 'first_name', 'last_name', 'privacy', 'avatar', 'home_country_code'
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
    public function myByteImages() {
        return $this->hasMany('App\Byte')->whereNotNull('asset_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myLines() {
        return $this->hasMany('App\Line');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myLists() {
        return $this->hasMany('App\Lifelist');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myPlaces() {
        return $this->hasMany('App\Place');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myPeople() {
        return $this->hasMany('App\Person');
    }

    public function myGoals() {
        return $this->hasMany('App\Goal');
    }

    public function myGoalsByLine($list) {
        return $this->myGoals()
            ->join('goal_lifelist','goals.id','=','goal_lifelist.goal_id')
//            ->join('byte_goal','goals.id','=','byte_goal.goal_id')
//            ->join('bytes','byte_goal.byte_id','=','bytes.id')
            ->select('goals.*')
            ->where('goal_lifelist.lifelist_id', '=', $list)
            ->orderBy('name');
    }

    public function myCompletedGoals() {

        return $this->myGoals()->has('bytes')->orderBy('name');
    }

    public function myCompletedGoalsByLine($list) {
        return $this->myGoals()
            ->has('bytes')
            ->join('goal_lifelist','goals.id','=','goal_lifelist.goal_id')
            ->select('goals.*')
            ->where('goal_lifelist.lifelist_id', '=', $list)
            ->orderBy('name');
    }

    public function myUnCompletedGoals() {

        return $this->myGoals()->doesntHave('bytes')->orderBy('name');
    }

    public function myUnCompletedGoalsByLine($list) {
        return $this->myGoals()
            ->doesntHave('bytes')
            ->join('goal_lifelist','goals.id','=','goal_lifelist.goal_id')
            ->select('goals.*')
            ->where('goal_lifelist.lifelist_id', '=', $list)
            ->orderBy('name');
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

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
