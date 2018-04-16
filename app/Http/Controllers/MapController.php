<?php

namespace App\Http\Controllers;

use App\Country;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index ()
    {
        $user_id = auth()->id();

        $countries = DB::select("
                select *
                from countries
            ");

        $my_stats = DB::select("
            select count(distinct c.`continent_id`) as cont_count, count(distinct c.`id`) as contr_count
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

        $byteCountryCount = [];
        foreach ($my_countries as $country) {
            $byteCountryCount[$country->code] = count(DB::select("
                    SELECT *
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`country_code` = '$country->code'")
            );
        }

        $byteCount = array_sum($byteCountryCount);
        //dd($byteCountryCount);
        //dd($byteCount);

        $provincesSupported = Province::select('country_code')->groupby('country_code')->pluck('country_code')->toArray();
        //dd($provincesSupported);
        return view('map.index', compact('countries', 'my_countries', 'byteCount', 'byteCountryCount', 'my_stats', 'provincesSupported'));
    }

    public function country ($country_code) {

        $user_id = auth()->id();

        $provinces = DB::select("
                select *
                from provinces
                where `country_code` = '$country_code'
            ");

        //dd($provinces);

        $my_provinces = DB::select("
            select pr.`province_name_en`, pr.`province_code`, pr.`country_code`
              from provinces as pr INNER JOIN (SELECT t1.province, t1.country_code
                  FROM places AS t1 INNER JOIN bytes AS t2 ON t1.id = t2.place_id
                  WHERE t2.`user_id` = $user_id and t1.`country_code` = '$country_code'
                  group by t1.`province`) as list on pr.`province_code` = list.`province`
        ");

        $byteProvinceCount = [];
        foreach ($my_provinces as $province) {
            $byteProvinceCount[$province->province_code] = count(DB::select("
                    SELECT *
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`province` = '$province->province_code'")
            );
        }

        $byteCount = count(DB::select("
                    SELECT *
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`country_code` = '$country_code'")
        );

        $byteCount = array_sum($byteProvinceCount);

        $country = Country::where('id', $country_code)->first();
        $provinceCount = Province::where('country_code', $country_code)->count();
        $provinceVisitedCount = count($my_provinces);

        return view('map.country', compact('provinces', 'country', 'country_code', 'byteCount', 'byteProvinceCount', 'provinceCount', 'provinceVisitedCount', 'my_provinces', 'byteCount'));
    }

    public function province (Country $country, Province $province)
    {
        $user_id = auth()->id();

        $bytes = DB::select("
                    SELECT *
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`province` = '$province->province_code'");

        //dd($bytes);

        return view('develop', compact('bytes', 'province'));
    }
}
