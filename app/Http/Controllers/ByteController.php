<?php

namespace App\Http\Controllers;

use App\Person;
use Auth;
use App\Place;
use App\Byte;
use Carbon\Carbon;
use App\Timezone;
use Illuminate\Http\Request;
use App\Lifecanvas\Utilities\FuzzyDate;

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
        $bytes = Auth::user()->myBytes()->latest()->paginate();

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
        //dd($request);

        $this->validate($request, [
            'title' => 'required',
        ]);

        //dd($request);

        $byte_date = FuzzyDate::createTimestamp($request);

        $byte =Byte::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'story' => request('story'),
            'rating' => request('rating'),
            'privacy' => request('privacy'),
            'place_id' => request('place_id') == "00" ? null : request('place_id'),
            'timezone_id' => request('timezone_id') == "00" ? null : request('timezone_id'),
            'byte_date' => $byte_date['datetime']->setTimezone('UTC'),
            'accuracy' => $byte_date['accuracy']
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
        $lines = $byte->lines()->get();
        return view('byte.show',compact('byte', 'lines'));
    }

    /**
     * Show the form for editing a byte.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function edit(Byte $byte)
    {
        //
    }

    /**
     * Update the specified byte in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Byte $byte)
    {
        dd($request);
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
