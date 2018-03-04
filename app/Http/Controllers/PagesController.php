<?php

namespace App\Http\Controllers;

use App\Byte;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller // TODO-KGW Maybe deal with this controller in just the routes file
{
    public function welcome() // TODO-KGW May not need this, dealt with passing hidenav in route closure
    {
        $hidenav = true;

        return view('welcome', compact('hidenav'));
    }

    public function feed()
    {
        $user = User::where('id', Auth::user()->id)->first();

        $bytes = Byte::latest()->paginate(30);

        if( !is_null($user->birthdate)) {
            list($year, $month, $day) = explode("-", $user->birthdate);
            $birthdate = $month . "/" . $day . "/" . $year;
            $aliveTime = Carbon::createFromDate($year, $month, $day)->diff(Carbon::now())->format('%y years, %m months and %d days');
        } else {
            $birthdate = NULL;
        }

        $byteCount = Byte::where('user_id',$user->id)->count();
        //dd($count);

        return view('feed', compact('bytes','user','birthdate','aliveTime','byteCount'));
    }

    public function users ()
    {
        $currentUser = Auth::user();
        $users = User::where('id', '<>', Auth::user()->id)->orderBy('username')->get();
        //dd($users);

        return view('users', compact('users', 'currentUser'));
    }
}
