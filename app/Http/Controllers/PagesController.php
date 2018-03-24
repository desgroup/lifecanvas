<?php

namespace App\Http\Controllers;

use App\Byte;
use App\Goal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller // TODO-KGW Maybe deal with this controller in just the routes file
{
    public function welcome() // TODO-KGW May not need this, dealt with passing hidenav in route closure
    {
        $hidenav = true;

        return view('welcome', compact('hidenav'));
    }

    public function feed()
    {
        $user = Auth::user();

        $count = 0;
        $users = array();
        $friends = $user->getAllFriendships();

        foreach ($friends as $friend) {
            if ($friend->sender->id == $user->id) {
                $users[$count] = $friend->recipient->id;
            } else {
                $users[$count] = $friend->sender->id;
            }
            $count++;
        }

        $bytes = Byte::select()
            ->where('user_id', $user->id)
            ->orWhere(function($q) use ($users) {
                $q->where('privacy','>', 0);
                $q->whereIn('user_id', $users);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if( !is_null($user->birthdate)) {
            list($year, $month, $day) = explode("-", $user->birthdate);
            $birthdate = $month . "/" . $day . "/" . $year;
            $aliveTime = Carbon::createFromDate($year, $month, $day)->diff(Carbon::now())->format('%y years, %m months and %d days');
        } else {
            $birthdate = NULL;
        }

        $byteCount = Byte::where('user_id', $user->id)->count();

        $goalCount = Goal::where('user_id', $user->id)->count();

        return view('feed', compact('bytes','user','birthdate','aliveTime','byteCount', 'goalCount'));
    }

    public function users ()
    {
        $currentUser = Auth::user();
        $users = User::where('id', '<>', Auth::user()->id)->orderBy('username')->get();
        //dd($users);

        return view('users', compact('users', 'currentUser'));
    }
}
