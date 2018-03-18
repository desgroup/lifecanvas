<?php

namespace App\Http\Controllers;

use App\Byte;
use App\Goal;
use App\Person;
use App\Place;
use Illuminate\Http\Request;
use App\Lifecanvas\Utilities\ImageUtilities;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = Goal::select()->orderBy('name')->paginate();

        return view('goal.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();

        return view('goal.create', compact('places', 'people'));
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
            'name' => 'required|unique_with:goals, user_id',
        ]);

        $image_data = [];

        if ($request->hasFile('image')) {
            $imageUtilities = new ImageUtilities();
            $image_data = $imageUtilities->processImage($request->file('image')); // TODO-KGW Need to check if it is really and image
        }

        $goal = Goal::create([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'privacy' => request('privacy'),
            'place_id' => request('place_id'),
            'person_id' => request('person_id'),
            'asset_id' => $image_data['id'] ?? NULL
        ]);

        $goal->lists()->attach($request->lifelist_id);

        return redirect('/lists/' . $request->lifelist_id)
            ->with('flash', 'Your goal has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        //
    }

    public function completed (Goal $goal, Byte $byte)
    {
        $goal->byte()->attach($byte->id);

        return redirect()
            ->back()
            ->with('flash', 'Your goal has been completed');
    }
}
