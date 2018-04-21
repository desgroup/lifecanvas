<?php

namespace App\Http\Controllers;

use App\Byte;
use App\Country;
use App\Lifecanvas\Utilities\Cluster;
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

    public function countryDetail ($country_code) {

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

    public function country ($country_code, $distance = 1000, $zoom = 11, $moreThen = 0)
    {

        $user_id = auth()->id();

        $points = array();

        //$bytes = Byte::where('lat', '!=', NULL)->get();

//        $bytes = DB::select("
//            SELECT * , CONCAT (lat, lng) AS latlng
//            FROM bytes
//            WHERE lat IS NOT NULL
//            ORDER BY latlng
//        ");

        $bytes = DB::select("
                    SELECT p.lat, p.lng, CONCAT (p.lat, p.lng) AS latlng
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`country_code` = '$country_code'");

        //dd($bytes);
        $byteCount = 0;
        $latlng = "";
        foreach ($bytes as $byte) {
            if ($latlng != $byte->latlng and !is_null($byte->lat)){
                array_push ($points, array("location" => array($byte->lat, $byte->lng)));
            }
            $latlng = $byte->latlng;
            $byteCount ++;
        }

        //dd($points);

        $clusters = new Cluster;
        $clusterPoints = $clusters->createCluster($points, $distance, $zoom, $moreThen);

        //dd($clusterPoints);


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

        //$byteCount = array_sum($byteProvinceCount);

        $country = Country::where('id', $country_code)->first();
        $provinceCount = Province::where('country_code', $country_code)->count();
        $provinceVisitedCount = count($my_provinces);

        return view('map.cluster', compact('clusterPoints', 'provinces', 'country', 'country_code', 'byteCount', 'byteProvinceCount', 'provinceCount', 'provinceVisitedCount', 'my_provinces', 'byteCount'));

    }

    public function cluster ($country_code, $province_code, $distance = 500, $zoom = 11, $moreThen = 0)
    {
        //dd($province);
        //dd($country_code);

        $user_id = auth()->id();

        $province = Province::where([['country_code', $country_code], ['province_code', $province_code]])->first();

        //dd($province);

        $points = array();

        //$bytes = Byte::where('lat', '!=', NULL)->get();

//        $bytes = DB::select("
//            SELECT * , CONCAT (lat, lng) AS latlng
//            FROM bytes
//            WHERE lat IS NOT NULL
//            ORDER BY latlng
//        ");

        $bytes = DB::select("
                    SELECT p.lat, p.lng, CONCAT (p.lat, p.lng) AS latlng
                    from `bytes` as b RIGHT JOIN `places` as p
                    on b.`place_id`  = p.`id` 
                    where b.`user_id` = $user_id and p.`country_code` = '$country_code' and p.`province` = '$province->province_code'");

        //dd($bytes);
        $byteCount = 0;
        $latlng = "";
        foreach ($bytes as $byte) {
            if ($latlng != $byte->latlng and !is_null($byte->lat)){
                array_push ($points, array("location" => array($byte->lat, $byte->lng)));
            }
            $latlng = $byte->latlng;
            $byteCount ++;
        }

        //dd($points);

        $clusters = new Cluster;
        $clusterPoints = $clusters->createCluster($points, $distance, $zoom, $moreThen);

        //dd($clusterPoints);


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

//        $byteProvinceCount = [];
//        foreach ($my_provinces as $province) {
//            $byteProvinceCount[$province->province_code] = count(DB::select("
//                    SELECT *
//                    from `bytes` as b RIGHT JOIN `places` as p
//                    on b.`place_id`  = p.`id`
//                    where b.`user_id` = $user_id and p.`province` = '$province->province_code'")
//            );
//        }

//        $byteCount = count(DB::select("
//                    SELECT *
//                    from `bytes` as b RIGHT JOIN `places` as p
//                    on b.`place_id`  = p.`id`
//                    where b.`user_id` = $user_id and p.`country_code` = '$country_code'")
//        );

        //$byteCount = array_sum($byteProvinceCount);

        $country = Country::where('id', $country_code)->first();
        //$provinceCount = Province::where('country_code', $country_code)->count();
        //$provinceVisitedCount = count($my_provinces);

        return view('map.province', compact('clusterPoints', 'province', 'provinces', 'country', 'country_code', 'byteCount', 'my_provinces'));

    }
}
