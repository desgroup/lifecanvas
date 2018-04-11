<?php

namespace App\Http\Controllers;

use App\Byte;
use App\Goal;
use App\Lifelist;
use App\Person;
use App\Place;
use Illuminate\Http\Request;
use App\Lifecanvas\Utilities\ImageUtilities;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\List_;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = Auth::user()->myGoals()->orderBy('name')->paginate(10);
        $goalCount = Auth::user()->myGoals()->count();

        return view('goal.index', compact('goals', 'goalCount'));
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
        $lists = Lifelist::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();

        return view('goal.create', compact('places', 'people', 'lists'));
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
            'privacy' => request('privacy') ?? NULL,
            'place_id' => request('place_id') ?? NULL,
            'person_id' => request('person_id') ?? NULL,
            'asset_id' => $image_data['id'] ?? NULL
        ]);

        if(strpos($request->path(), 'goals') == false)
        {
            $goal->lists()->attach($request->lifelist_id);
            $page = '/lists/' . $request->lifelist_id;
        } else {
            $goal->lists()->attach($request->lifelist_id);
            $page = '/goals';
        }

        return redirect($page)
            ->with('flash', 'Your goal has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show (Goal $goal)
    {
        $bytes = $goal->bytes()->get();

        return view('goal.show', compact('goal', 'bytes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $lists = Lifelist::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        //dd($lists);

        $listData = $goal->lists()->select('id', 'name')->get();
        //dd($listData);

        $listDataArray = [];

        foreach ($listData as $list)
        {
            $listDataArray[$list->id] = $list->name;
        }

        return view('goal.edit', compact('goal', 'places', 'people', 'lists', 'listDataArray'));
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
        $request['user_id'] = auth()->id();

        $this->validate($request, [
            'name' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageUtilities = new ImageUtilities();
            $image_data = $imageUtilities->processImage($request->file('image')); // TODO-KGW Need to check if it is really and image
        }

        $goal->update([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'privacy' => request('privacy') ?? NULL,
            'place_id' => request('place_id') ?? NULL,
            'person_id' => request('person_id') ?? NULL,
            'asset_id' => $image_data->id ?? $goal->asset_id ?? NULL
        ]);

        $goal->lists()->sync($request->lists);

        return redirect('/goals/' . $goal->id)
            ->with('flash', 'Your goal has been updated');
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

    public function complete (Goal $goal)
    {
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $bytes = Byte::where('user_id', '=', auth()->id())->orderBy('title')->pluck('title', 'id')->toArray();

        return view('goal.complete', compact('goal', 'places', 'people', 'bytes'));
    }

    public function completed (Goal $goal, Request $request)
    {
        //dd($request);
        $goal->bytes()->attach($request->byte_id);

        return redirect('/goals/' . $goal->id)
            ->with('flash', 'Your goal has been completed');
    }

    public function detachByte (Goal $goal, Request $request)
    {
        $goal->bytes()->detach($request->byte_id);

        return redirect('/goals/' . $goal->id)
            ->with('flash', 'A byte has been unlinked from your goal');
    }
}
