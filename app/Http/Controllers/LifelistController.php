<?php

namespace App\Http\Controllers;

use App\Lifelist;
use App\Person;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LifelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $lists = Auth::user()->myLists()->orderBy('name')->with(['bytes' => function ($query) {
//            $query->orderBy('created_at', 'ASC')->first();
//        }])->get();

        $lists = Auth::user()->myLists()->orderBy('name')->get();

        return view('list.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('list.create');
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
            'name' => 'required|unique_with:lifelists, user_id',
        ]);

        $list = Lifelist::create([
            'user_id' => auth()->id(),
            'privacy' => request('privacy'),
            'name' => request('name')
        ]);

        return redirect('/lists')
            ->with('flash', 'Your lifelist has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lifelist  $lifelist
     * @return \Illuminate\Http\Response
     */
    public function show(Lifelist $list)
    {
        $goals = $list->goals()->orderBy('name')->paginate();
        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();


        return view('list.show', compact('goals', 'list', 'places', 'people'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lifelist  $lifelist
     * @return \Illuminate\Http\Response
     */
    public function edit(Lifelist $lifelist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lifelist  $lifelist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lifelist $lifelist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lifelist  $lifelist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lifelist $lifelist)
    {
        //
    }
}
