<?php

namespace App\Http\Controllers;

use App\Person;
use App\Place;
use App\Byte;
use App\Timezone;
use App\Lifecanvas\Utilities\FuzzyDate;
use App\Lifecanvas\Utilities\ImageUtilities;
use App\Lifecanvas\Utilities\DateTimeUtilities;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ByteController extends Controller
{
    /**
     * List all the user's bytes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Timezone::where('id', '=', 1)->first());
        $bytes = Auth::user()->myBytes()->latest('byte_date')->paginate();

        return view('byte.index',compact('bytes'));
    }

    /**
     * Show the form for creating a byte.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $timezones = Timezone::orderBy('timezone_name')->pluck('timezone_name', 'id')->toArray();

        return view('byte.create', compact('places', 'people', 'timezones'));
    }


    /**
     * Store a newly created byte in the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data to make sure we have a title
        $this->validate($request, [
            'title' => 'required',
        ]);

        // look at image data and take what you can if an image exists
        $image_data = [];

        if ($request->hasFile('image')) {
            $imageUtilities = new ImageUtilities();
            $image_data = $imageUtilities->processImage($request->file('image')); // TODO-KGW Need to check if it is really and image
        }

        // Find a related place
        $lat = $image_data->lat ?? NULL;
        $lng = $image_data->lng ?? NULL;

        if ($request->place_id <> "00") {
            $placeId = $request->place_id;
        } else {
            if (!is_null($lat) && !is_null($lng)) {
                $distance = 2;
                $place = DB::table('places')
                    ->selectRaw("places.*, ACOS(COS(RADIANS(lat)) * COS(RADIANS(lng)) * COS(RADIANS($lat)) * COS(RADIANS($lng)) + COS(RADIANS(lat)) * SIN(RADIANS(lng)) * COS(RADIANS($lat)) * SIN(RADIANS($lng)) + SIN(RADIANS(lat)) * SIN(RADIANS($lat))) * 3963.1 AS Distance")
                    ->whereRaw('1')
                    ->where('user_id', '=', auth()->id())
                    ->havingRaw("Distance <= $distance")
                    ->orderBy('Distance')
                    ->first(); // use toSql() to see the sql output

                $placeId = $place->id ?? NULL;
            }
        }


        // set timezone
        // set to NULL by default
        $timeZone_id = NULL;

        if (isset($image_data['timezone_id']) && !is_null($image_data['timezone_id'])) {
            $timeZone_id = $image_data['timezone_id'];
        } elseif (!is_null($request->place_id) && $request->place_id <> '00') {
            //dd($request->place_id);
            $timeZone = Place::where('id', '=', $request->place_id)->first()->timezone;
            //dd(Place::where('id', '=', $request->place_id)->first()->timezone);
            if(!is_null($timeZone)) {
                //dd($timeZone->id);
                $timeZone_id = $timeZone->id;
            }
        } else {
            if (!is_null($request->usertimezone)) {
                $timeZone_id = Timezone::where('timezone_name', '=', $request->usertimezone)->first(['id'])->id;
            }
        }

        // set date and accuracy
        if (isset($image_data['asset_date_local']) && !is_null($image_data['asset_date_local'])) {
            $byte_date = array("datetime" => $image_data['asset_date_local'], "accuracy" => '111111');
        } else {
            $byte_date = FuzzyDate::createTimestamp($request);
        }

        // Set date time
        if(is_null($timeZone_id)) {
            $datetime = NULL;
            $byte_date['accuracy'] = '000000';
        } else {
            $datetime = DateTimeUtilities::toUtcTime($byte_date['datetime'], Timezone::where('id', '=', $timeZone_id)->first()->timezone_name);
        }

        // Create new byte
        $byte = Byte::create([
            'title' => request('title'),
            'story' => request('story'),
            'rating' => request('rating'),
            'repeat' => request('repeat'),
            'privacy' => request('privacy'),
            'timezone_id' => $timeZone,
            'byte_date' => $datetime,
            'accuracy' => $byte_date['accuracy'],
            'lat' => $lat ?? NULL,
            'lng' => $lng ?? NULL,
            'asset_id' => $image_data['id'] ?? NULL,
            'place_id' => $placeId ?? NULL,
            'user_id' => auth()->id()
        ]);

        $byte->lines()->attach($request->lines);
        $byte->people()->attach($request->people);

        return redirect($byte->path())
            ->with('flash', 'Your byte has been added');
    }

    /**
     * Display a specific byte.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function show(Byte $byte)
    {
        //dd($byte->place);
        //dd($byte->timezone->timezone_name);
        $lines = $byte->lines()->get();
        if (!is_null($byte->byte_date) && !is_null($byte->timezone))
        $displayDate = DateTimeUtilities::formatFullDate(Carbon::createFromFormat('Y-m-d H:i:s',$byte->byte_date)->setTimeZone($byte->timezone->timezone_name), $byte->accuracy);
        //dd($byte->place_id);
        $place = Place::where('id', '=', $byte->place_id)->first();
        //dd($place);
        return view('byte.show',compact('byte', 'displayDate', 'lines', 'place'));
    }

    /**
     * Show the form for editing a byte.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function edit(Byte $byte)
    {
        // Gather that the menu items
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $timezones = Timezone::orderBy('timezone_name')->pluck('timezone_name', 'id')->toArray();

        // Get the date information
        $fuzzy_date = new FuzzyDate();

        if($byte->accuracy == "0000000") {

            $formDate = $fuzzy_date->makeFormValues(null, "0000000");

        } else {

            $timeZone = Timezone::where('id', '=', $byte->timezone_id)->first();

            $timestamp = Carbon::createFromFormat('Y-m-d H:i:s',
                $byte->byte_date, 'UTC');

            $formDate = $fuzzy_date->makeFormValues($timestamp->setTimezone($timeZone->timezone_name), $byte->accuracy);
        }

        $peopleData = $byte->people()->select('id', 'name')->get();

        $peopleDataArray = [];

        foreach ($peopleData as $person)
        {
            $peopleDataArray[$person->id] = $person->name;
        }

        $linesData = $byte->lines()->select('id', 'name')->get();

        $linesDataArray = [];

        foreach ($linesData as $line)
        {
            $linesDataArray[$line->id] = $line->name;
        }

        return view('byte.edit', compact('byte', 'places', 'people', 'timezones', 'formDate', 'peopleDataArray', 'linesDataArray'));
    }

    /**
     * Update the specified byte in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Byte  $byte
     * @return Byte
     */
    public function update(Request $request, Byte $byte)
    {
        //dd($request);

        $this->authorize('update', $byte); // Using BytePolicy registered in AuthServiceProvider

        $this->validate($request, [
            'title' => 'required',
            'privacy' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $imageUtilities = new ImageUtilities();
            $image_data = $imageUtilities->processImage($request->file('image')); // TODO-KGW Need to check if it is really and image

            if ($request->use_image_time == "on") { // TODO-KGW Need to address wrong timezone images here and in store above save UTC
                if (!is_null($image_data->asset_date_local) && !is_null($image_data->timezone_id)) {
                    $datetime = DateTimeUtilities::toUtcTime($image_data->asset_date_local, $image_data->timezone->timezone_name);
                    $byte_date = array("datetime" => $datetime, "accuracy" => '111111');
                }
            }
        }

        // Where are we to set the place and timezone
        if ($request->place_id == '00') {
            if ($request->use_image_time == "on") {
                // Find a related place
                $lat = $image_data->lat;
                $lng = $image_data->lng;
                $distance = 2;

                if (!is_null($image_data->lat) && !is_null($image_data->lng)) {
                    $place = DB::table('places')
                        ->selectRaw("places.*, ACOS(COS(RADIANS(lat)) * COS(RADIANS(lng)) * COS(RADIANS($lat)) * COS(RADIANS($lng)) + COS(RADIANS(lat)) * SIN(RADIANS(lng)) * COS(RADIANS($lat)) * SIN(RADIANS($lng)) + SIN(RADIANS(lat)) * SIN(RADIANS($lat))) * 3963.1 AS Distance")
                        ->whereRaw('1')
                        ->where('user_id', '=', auth()->id())
                        ->havingRaw("Distance <= $distance")
                        ->orderBy('Distance')
                        ->first(); // use toSql() to see the sql output

                    $place_id = $place->id ?? NULL;
                    //dd($place_id);
                    if (!is_null($place_id)) {
                        $timeZone = Place::where('id', '=', $place_id)->first()->timezone;
                    }
                    //dd('From image: ' . $timeZone);
                }
            }
        } elseif (!is_null($request->place_id) && $request->place_id <> $byte->place_id) {
            $place_id = $request->place_id;
            $timeZone = Place::where('id', '=', $place_id)->first()->timezone;
            //dd('From place: ' . $timeZone);
        } elseif (!is_null($request->timezone_id) && $request->timezone_id <> "00") {
            $timeZone = Timezone::where('id', '=', $request->timezone_id)->first();
            //dd('From timzone: ' . $timeZone);
        }

        if (!isset($timeZone)) {
            $timeZone = Timezone::where('id', '=', 90)->first();
            //dd('From default: ' . $timeZone);
        }

        // Set time based on inputs if not using image time
        if (!isset($byte_date)) {
            $byte_date = FuzzyDate::createTimestamp($request);
            $datetime = DateTimeUtilities::toUtcTime($byte_date['datetime'], $timeZone->timezone_name);
        }

        //dd('Hello World');

       /* if (!isset($timeZone)) {
            if (!is_null($request->timezone_id) && $request->timezone_id <> "00") {
                $timeZone = Timezone::where('id', '=', $request->timezone_id)->first();
            } elseif (!is_null($request->usertimezone)) {
                $timeZone = Timezone::where('timezone_name', '=', $request->usertimezone)->first();
            } else {
                $timeZone = Timezone::where('id', '=', 90)->first();
            }
        }*/

        $byte->update([
            'title' => request('title'),
            'story' => request('story'),
            'rating' => request('rating'),
            'repeat' => request('repeat'),
            'privacy' => request('privacy'),
            'timezone_id' => $timeZone->id ?? NULL,
            'byte_date' => $datetime,
            'accuracy' => $byte_date['accuracy'],
            'lat' => $lat ?? $byte->lat ?? NULL,
            'lng' => $lng ?? $byte->lng ?? NULL,
            'asset_id' => $image_data->id ?? $byte->asset_id ?? NULL,
            'place_id' => $place_id ?? NULL,
            'user_id' => auth()->id()
        ]);

        $byte->lines()->sync($request->lines);
        $byte->people()->sync($request->people);
        
        return redirect($byte->path())
            ->with('flash', 'Your byte has been updated');
    }

    /**
     * Remove the specified byte from storage.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Byte $byte)
    {
        if ($byte->user_id != auth()->id()) {
            // TODO-KGW I don't like this approach, I would prefer redirect back with a message
            abort(403, 'You do not have permission to delete this thread.');
            if (request()->wantsJson()) {
                // TODO-KGW This is here just for testing, not sure about this.
                return response(['status' => 'Permission Denied'], 403);
            }
            return redirect('/signin');
        }

        //$byte->comments()->delete();
        $byte->delete();

        if(request()->wantsJson())
        {
            return response([], 204);
        }

        return redirect('/bytes');
    }

}
