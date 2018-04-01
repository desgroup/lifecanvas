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

//    public function hasPermission($permission_name)
//    {
//        $result = \DB::table('users')
//            ->join('role_user','users.id','=','role_user.user_id')
//            ->join('roles','role_user.role_id','=','roles.id')
//            ->join('permission_role','roles.id','=','permission_role.role_id')
//            ->join('permissions','permission_role.permission_id','=','permissions.id')
//            ->select('permissions.*')->where('users.id','=',\Auth::user()->id)->where('permissions.name','=',$permission_name)->count();
//
//        return $result > 0;
//    }
//
//    public function completedGoals($permission_name)
//    {
//        $result = \DB::table('lifelists')
//            ->join('goal_lifelist','lifelists.id','=','goal_lifelist.lifelist_id')
//            ->join('goals','goal_lifelist.goal_id','=','goals.id')
//            ->join('byte_goal','goals.id','=','byte_goal.goal_id')
//            ->join('bytes','byte_goal.byte_id','=','bytes.id')
//            ->join('assets','bytes.asset_id','=','assets.id')
//            ->select('assets.*')->where('lifelists.id','=',$lifelist->id)->where('permissions.name','=',$permission_name)->count();
//
//        return $result > 0;
//    }
//
//    public function completedGoals($permission_name)
//    {
//        $result = \DB::table('lifelists')
//            ->join('goal_lifelist','lifelists.id','=','goal_lifelist.lifelist_id')
//            ->join('goals','goal_lifelist.goal_id','=','goals.id')
//            ->join('byte_goal','goals.id','=','byte_goal.goal_id')
//            ->join('bytes','byte_goal.byte_id','=','bytes.id')
//            ->select('bytes.*')->where('lifelists.id','=',$lifelist->id)->count();
//
//        return $result > 0;
//    }
}
