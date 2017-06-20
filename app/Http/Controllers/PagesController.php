<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller // TODO-KGW Maybe deal with this controller in just the routes file
{
    public function welcome() // TODO-KGW May not need this, dealt with passing hidenav in route closure
    {
        $hidenav = true;

        return view('welcome', compact('hidenav'));
    }

    public function feed()
    {
        return view('feed');
    }
}
