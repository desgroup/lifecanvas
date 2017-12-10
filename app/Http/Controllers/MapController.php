<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index ()
    {
        $user_id = auth()->id();
        //dd($user_id);

        $my_stats = DB::select("
            select count(distinct c.`continent_id`) as cont_count, count(distinct c.`id`) as count_count
            from `bytes` as b RIGHT JOIN `places` as p
            on b.`place_id`  = p.`id`
            right join `countries` c
            on c.`id` = p.`country_code`
            where b.`user_id` = $user_id
        ");
        $my_stats = array_shift($my_stats);
        //dd($my_stats);

        $my_countries = DB::select("select distinct co.`country_name_en` as name, co.`id` as code
            from `bytes` as b RIGHT JOIN `places` as p
            on b.`place_id`  = p.`id`
            inner join `countries` co
            on p.`country_code` = co.`id`
            where b.`user_id` = $user_id
            order by co.`country_name_en`
        ");
        //dd($my_countries);
        return view('map.index', compact('my_countries', 'my_stats'));
    }

    public function country ($country_code) {
        return view('map.country', compact('country_code'));
    }
}
