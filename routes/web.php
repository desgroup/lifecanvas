<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Guest routes
Auth::routes();

Route::get('/', function () {
    if(Auth::check()){return Redirect::to('feed');}
    return view('welcome', ['hidenav' => true]);
});

// Authentication routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('/feed', 'PagesController@feed');
    Route::resource('/bytes', 'ByteController');
    Route::resource('/lines', 'LineController');
    Route::resource('/profiles', 'ProfileController');
    Route::get('{user}', 'ProfileController@userProfile');
    Route::post('/bytes/{byte}/favorites', 'FavoriteController@store');
    Route::post('/bytes/{byte}/comment', 'CommentController@store');
});