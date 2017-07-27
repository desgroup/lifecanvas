<?php

namespace App\Http\Controllers;

use App\Byte;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use App\Lifecanvas\Transformers\ByteTransformer;

class ApiByteController extends ApiController
{
    /**
     * @var byteTransformer
     */
    protected $byteTransformer;

    /**
     * ApiByteController constructor.
     * @param ByteTransformer $byteTransformer
     * @internal param ByteTransformer $byteTransformer
     */
    function __construct(ByteTransformer $byteTransformer)
    {
        $this->byteTransformer = $byteTransformer;

        //$this->middleware('auth.basic', ['only' => 'store']);
    }

    /**
     * Returns json containing a list of bytes found.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?: 25;
        $limit = $limit > 100 ? 100 : $limit;
        $bytes = Byte::with('user', 'place', 'timezone', 'lines', 'people')->latest()->paginate($limit);

        //dd($bytes);

//        if (! $bytes) {
//            return $this->responseNotFound('No bytes found.');
//        }

        return $this->respondWithPagination($bytes,
            array('data' => $this->byteTransformer->transformCollection($bytes->items())), $limit);

//        return $this->respond([
//            'data' => $this->byteTransformer->transformCollection($bytes->items()),
//            'pagination' => [
//                'count' => $bytes->count(),
//                'total_pages' => $bytes->total(),
//                'per_page' => $bytes->perPage(),
//                'last_page' => $bytes->lastPage(),
//                'current_page' => $bytes->currentPage(),
//                'has_more_pages' => $bytes->hasMorePages(),
//                'next_page' => $bytes->nextPageUrl() . '&limit=' . $limit,
//                'previous_page' => $bytes->previousPageUrl() . '&limit=' . $limit,
//            ]
//        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Lesson input verification section.
        if( ! $request->input('name') and ! $request->input('user_id'))
        {
            return $this->responseValidationError('Parameters failed validation.');
        }

        Byte::create($request->all());
        return $this->responseAddSuccess('Byte added successfully.');

    }

    /**
     * Return json containing the found byte.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Byte $byte)
    {
        //return $byte;

        //$lesson = Lesson::find($id);

        if (! $byte)
        {
            return $this->responseNotFound('Byte does not exist.');
        }
        return $this->respond(['data' => $this->byteTransformer->transform($byte)]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $byte =Byte::create([
//            'user_id' => 1,
//            'title' => request('title'),
//            'story' => request('story'),
//            'privacy' => request('privacy')
//        ]);
//
//        $byte->lines()->attach($request->lines);
//
//        $response = -2;
//
//        return $response;
//    }
}
