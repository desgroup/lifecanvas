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

//Route::get('signin', 'Auth\SigninController@showSigninForm')->name('signin');
//Route::post('signin', 'Auth\SigninController@login');
//Route::post('signout', 'Auth\SigninController@logout')->name('signout');
//
//// Registration Routes...
//Route::get('signup', 'Auth\SignupController@showSignupForm')->name('signup');
//Route::post('signup', 'Auth\SignupController@signup');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

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
    Route::resource('/bytes', 'ByteController');
    Route::resource('/lines', 'LineController');
    Route::resource('/people', 'PersonController');
    Route::resource('/places', 'PlaceController');
    Route::resource('/profiles', 'ProfileController');
    Route::delete('/comments/{comment}', 'CommentController@destroy');
    Route::get('{user}', 'ProfileController@userProfile');
    Route::post('/bytes/{byte}/favorites', 'FavoriteController@store');
    Route::post('/bytes/{byte}/comment', 'CommentController@store');
});