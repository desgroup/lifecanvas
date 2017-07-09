<?php

namespace App\Http\Controllers;

use Auth;
use App\Byte;
use App\User;
use Illuminate\Http\Request;

class ByteController extends Controller
{
    /**
     * List all the user's bytes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('byte.create');
    }

    /**
     * Store a newly created byte in the storage.
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
            'story' => request('story'),
            'privacy' => request('privacy')
        ]);

        $byte->lines()->attach($request->lines);

        return redirect($byte->path());
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

        $byte->comments()->delete();
        $byte->delete();

        if(request()->wantsJson())
        {
            return response([], 204);
        }

        return redirect('/bytes');
    }
}
