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
        //$lists = Lifelist::where('user_id', auth()->id())->with('goals')->orderBy('name')->get();

        $lists = Lifelist::where('user_id', auth()->id())->orderBy('name')->get();

        //dd($lists);

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
    public function show(Lifelist $list, Request $request)
    {

        if ($request->filter == "completed") {
            $goals = Auth::user()->myCompletedGoalsByLine($list->id)->paginate(10);
        } elseif ($request->filter == "uncompleted") {
            $goals = Auth::user()->myUnCompletedGoalsByLine($list->id)->paginate(10);
        } else {
            $goals = Auth::user()->myGoalsByLine($list->id)->paginate(10);
        }


        //$goals = $list->goals()->orderBy('name')->paginate(10);

        $places = Place::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();
        $people = Person::where('user_id', '=', auth()->id())->orderBy('name')->pluck('name', 'id')->toArray();

        $goalCount = Auth::user()->myGoalsByLine($list->id)->count();
        $goalsCompletedCount = Auth::user()->myCompletedGoalsByLine($list->id)->count();
//        $goalsCompletedCount = \DB::table('lifelists')
//            ->join('goal_lifelist','lifelists.id','=','goal_lifelist.lifelist_id')
//            ->join('goals','goal_lifelist.goal_id','=','goals.id')
//            ->join('byte_goal','goals.id','=','byte_goal.goal_id')
//            ->join('bytes','byte_goal.byte_id','=','bytes.id')
//            ->select('bytes.*')->where('lifelists.id','=',$list->id)->count();

        return view('list.show', compact('goals', 'list', 'places', 'people', 'goalCount', 'goalsCompletedCount'));
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
