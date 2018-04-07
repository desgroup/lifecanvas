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

Route::get('/develop2', function () {
    return view('develop2', ['lat' => 43.438338, 'lng' => -79.686901]);
});

Route::get('/find', 'SearchController@find');

// Authentication Routes...
Auth::routes();

// Guest routes
Route::get('/', function () {
    if(Auth::check()){return Redirect::to('feed');}
    return view('welcome', ['hidenav' => true]);
});

// Authentication routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('/changePassword','ChangePasswordController@showChangePasswordForm');
    Route::post('/changePassword','ChangePasswordController@changePassword')->name('changePassword');
    Route::get('/friends', 'FriendController@index');
    Route::post('/friend/{recipient}', 'FriendController@friend');
    Route::post('/unfriend/{recipient}', 'FriendController@unfriend');
    Route::post('/photo/async', 'PhotoController@async');
    Route::post('/photo/fetch', 'PhotoController@fetch');
    Route::get('/users', 'PagesController@users');
    Route::get('/feed', 'PagesController@feed');
    Route::get('/map', 'MapController@index');
    Route::get('/map/{country}', 'MapController@country');
    Route::post('/bytes/grab/{byte}', 'ByteController@grab');
    Route::get('/bytes/images', 'ByteController@images');
    Route::get('/bytes/images/country/{code}', 'ByteController@imagesCountry');
    Route::get('/bytes/country/{code}', 'ByteController@country');
    Route::post('/bytes/{byte}/favorites', 'FavoriteController@store');
    Route::post('/bytes/{byte}/comment', 'CommentController@store');
    Route::resource('/bytes', 'ByteController');
    Route::resource('/lines', 'LineController');
    Route::resource('/lists', 'LifelistController');
    Route::get('/goals/complete/{goal}', 'GoalController@complete');
    Route::post('/goals/completed/{goal}', 'GoalController@completed');
    Route::post('/goals/removeByte/{goal}', 'GoalController@detachByte');
    Route::post('/goals/completed/{goal}', 'GoalController@completed');
    Route::resource('/goals', 'GoalController');
    Route::resource('/people', 'PersonController');
    Route::resource('/places', 'PlaceController');
    Route::delete('/comments/{comment}', 'CommentController@destroy');
    Route::get('/{user}', 'ProfileController@userProfile');
    Route::patch('/{user}', 'ProfileController@update');
    Route::get('/{user}/edit', 'ProfileController@edit');
});