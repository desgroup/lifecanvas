<?php

namespace App\Http\Controllers;

use App\Byte;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function find(Request $request)
    {
        $query = $request->get('q');
        return Byte::search($query)
            ->get();
        //return Byte::select('id','title')->where('title', 'like', '%' . $query . '%')->get();
    }

    public function searchRedirect ()
    {
        switch ($request->type) {
            case "byte":
                return redirect('/bytes/' . $request->id);
                break;
        }
    }
}
