<?php

namespace App\Http\Controllers;

use App\Country;
use App\Place;
use App\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Auth::user()->myPlaces()->orderBy('name')->get();
        //return $places;
        return view('place.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('country_name_en')->pluck('country_name_en', 'id')->toArray();
        $timezones = Timezone::orderBy('timezone_name')->pluck('timezone_name', 'id')->toArray();

        $home_country = Country::where('id', Auth::user()->home_country_code)->pluck('country_name_en', 'id')->toArray();

        //dd(value($home_country));

        return view('place.create', compact('countries', 'timezones', 'home_country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = auth()->id();

        $this->validate($request, [
            'name' => 'required|unique_with:places, user_id',
        ]);

        $input = array_add($request->all(), 'user_id', Auth::id());

        // TODO-KGW Check if you need this one, I may be handling null values below.
        foreach ($input as $key => $value) {
            $input[$key] = $input[$key] == "" ? null : $input[$key];
        }
        //dd($input);

        $place = Place::create([
            'user_id' => auth()->id(),
            'name' => $input['name'],
            'address' => $input['address'],
            'city' => $input['city'],
            'province' => $input['province'],
            'country_code' => $input['country_code'] == "00" ? null : $input['country_code'],
            'url_place' => $input['url_place'],
            'url_wikipedia' => $input['url_wikipedia'],
            'lat' => $input['lat'],
            'lng' => $input['lng'],
            'map_zoom' => $input['map_zoom'],
            'image_id' => $input['image_id'],
            'timezone_id' => $input['timezone_id'] == "00" ? null : $input['timezone_id'],
            'extant' => (integer) $input['extant'],
            'privacy' => (integer) $input['privacy'],
            'user_id' => $input['user_id']
        ]);

        return redirect('/places')
            ->with('flash', "$place->name has been added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        $bytes = $place->bytes()->latest('byte_date')->paginate();
        return view('place.show', compact('bytes', 'place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
