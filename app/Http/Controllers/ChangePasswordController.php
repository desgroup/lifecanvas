<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChangePasswordForm () {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request){

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        $errors = new MessageBag();

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            $errors->add("error", "Your current password does not matches with the password you provided. Please try again.");
            return redirect()->back()->withErrors($errors);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            $errors->add("error", "New Password cannot be same as your current password. Please choose a different password.");
            return redirect()->back()->withErrors($errors);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()
            ->with('flash', 'Password changed successfully!');

    }
}
