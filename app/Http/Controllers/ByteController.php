<?php

namespace App\Http\Controllers;

use App\Byte;
use App\User;
use Illuminate\Http\Request;

class ByteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bytes = \Auth::user()->myBytes()->latest()->get();

        return view('byte.index',compact('bytes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('byte.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $byte =Byte::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'story' => request('story')
        ]);

        return redirect($byte->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function show(Byte $byte)
    {
        return view('byte.show',compact('byte'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function edit(Byte $byte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Byte $byte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Byte  $byte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Byte $byte)
    {
        //
    }
}
