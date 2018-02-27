<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if( !is_null($user->birthdate)) {
            list($year, $month, $day) = explode("-", $user->birthdate);
            $birthdate = $month . "/" . $day . "/" . $year;
            $aliveTime = Carbon::createFromDate($year, $month, $day)->diff(Carbon::now())->format('%y years, %m months and %d days');
        } else {
            $birthdate = NULL;
        }

        return view('profile.edit', compact('user','birthdate','aliveTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'privacy' => 'required|min:0|max:2|integer',
            'email' => 'required|same:confirm_email'
        ]);

        if ($request->birthdate == "" || !preg_match ( '/^(0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])[\/\-]\d{4}$/' , $request->birthdate)) {
            $birthdate = NULL;
            //dd('ok');
        } else {
            list($month, $day, $year) = explode("/", $request->birthdate);
            $birthdate = $year . "-" . $month . "-" . $day;
        }

        $user->update([
                'birthdate' => $birthdate ?? NULL,
                'first_name' => $request->first_name ?? NULL,
                'last_name' => $request->last_name ?? NULL,
                'email' => $request->email ?? $user->email,
                'privacy' => $request->privacy ?? $user->privacy,
            ]);

        return redirect('/' . $user->username)
            ->with('flash', 'Your profile has been updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function userProfile(User $user)
    {
//        return view('profile.show', [
//            'profileUser' => $user,
//            'bytes' => $user->bytes()->paginate(30)
//        ]);

        return view('profile.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
