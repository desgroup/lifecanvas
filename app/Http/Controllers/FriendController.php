<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function friend (User $recipient)
    {
        $sender = Auth::user();
        $sender->befriend($recipient);
        $recipient->acceptFriendRequest($sender);

        return back()
            ->with('flash', 'You have friended @' . $recipient->username);
    }

    public function unfriend (User $recipient)
    {
        $sender = Auth::user();
        $sender->unfriend($recipient);

        return back()
            ->with('flash', 'You have un-friended @' . $recipient->username);
    }

}
