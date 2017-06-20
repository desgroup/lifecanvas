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

//Route::get('/', function () {
//    return view('welcome');
//});



//Route::get('/home', 'HomeController@index')->name('home');


// Official Lifecanvas routes
// Guest routes
Auth::routes();

Route::get('/', function () {
    if(Auth::check()){return Redirect::to('feed');}
    return view('welcome', ['hidenav' => true]);
});

// Must be signed in routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('feed', 'PagesController@feed');
    Route::resource('bytes', 'ByteController');
    Route::post('/bytes/{byte}/comment', 'CommentController@store');
});