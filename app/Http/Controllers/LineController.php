<?php

namespace App\Http\Controllers;

use Auth;
use App\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lines = Auth::user()->myLines()->orderBy('name')->with(['bytes' => function ($query) {
            $query->orderBy('created_at', 'ASC')->first();
        }])->get();
        //$lines = Auth::user()->myLines()->orderBy('name')->with('bytes')->get();
        //$count = $lines->count();
        //dd($count);
        //$lines = Auth::user()->myLines()->orderBy('name')->get();
        return view('line.index', compact('lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('line.create');
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
            'name' => 'required|unique_with:lines, user_id',
        ]);

        $line = Line::create([
            'user_id' => auth()->id(),
            'name' => request('name')
        ]);

        return redirect('/lines')
            ->with('flash', 'Your lifeline has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        $bytes = $line->bytes()->latest('byte_date')->paginate(10);
        $byteCount = $line->bytes()->count();

        return view('line.show', compact('bytes', 'line', 'byteCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Line $line)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line)
    {
        //
    }
}
