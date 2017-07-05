<?php

namespace App\Http\Controllers;

use App\Byte;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store (Byte $byte)
    {
        $byte->favorite();

        return back();
    }
}
