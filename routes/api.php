<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){
    Route::post('/login', 'ApiAuthController@login');
    Route::resource('byte', 'ApiByteController');
//    Route::get('byte/{$id}/lines', 'ApiLineController@index');
//    Route::resource('byte', 'ApiByteController');
//    Route::resource('line', 'ApiLineController', ['only' => ['index', 'show']]);
    //Route::get('lessons/{id}/tags', 'TagsController@lessonTags');
    //Route::resource('tags', 'TagsController');
});
