<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function welcome()
    {
        $hidenav = true;

        return view('welcome', compact('hidenav'));
    }

    public function feed()
    {
        return view('feed');
    }
}
