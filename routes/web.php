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

// PHP info route for debugging in early stages
Route::get('/info', function () {
    return phpinfo();
});

Route::get('/develop', function () {
    return view('develop', ['lat' => 43.438338, 'lng' => -79.686901]);
});

// Authentication Routes...
Auth::routes();

// Guest routes
Route::get('/', function () {
    if(Auth::check()){return Redirect::to('feed');}
    return view('welcome', ['hidenav' => true]);
});

// Authentication routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('/feed', 'PagesController@feed');
    Route::get('/map', 'MapController@index');
    Route::get('/map/{country}', 'MapController@country');
    Route::get('bytes/images', 'ByteController@images');
    Route::resource('/bytes', 'ByteController');
    Route::resource('/lines', 'LineController');
    Route::resource('/people', 'PersonController');
    Route::resource('/places', 'PlaceController');
    //Route::resource('/profiles', 'ProfileController');
    Route::delete('/comments/{comment}', 'CommentController@destroy');
    Route::post('/bytes/{byte}/favorites', 'FavoriteController@store');
    Route::post('/bytes/{byte}/comment', 'CommentController@store');
    Route::get('/{user}', 'ProfileController@userProfile');
    Route::patch('/{user}', 'ProfileController@update');
    Route::get('/{user}/edit', 'ProfileController@edit');
    Route::post('/photo/async', 'PhotoController@async');
    Route::post('/photo/fetch', 'PhotoController@fetch');
});