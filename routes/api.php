<?php

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user', function () {
    return Auth::user();
})->name('user');

Route::group(["middleware" => "auth.api"],function(){
    Route::get('/task','TaskController@get');
    Route::post('/task','TaskController@post');
    Route::delete('/task/{id}','TaskController@delete');
    Route::put('/task/{id}/task/{task}','TaskController@taskUpdate');
    Route::put('/task/{id}/howlong/{howlong}','TaskController@howlongUpdate');
    Route::put('/task/{id}/howtimes/{howtimes}','TaskController@howtimesUpdate');
    Route::put('/task/{id}/charge/{charge}','TaskController@chargeUpdate');
    Route::put('/task/{id}/charge2/{charge2}','TaskController@chargeUpdate2');
    
    Route::get('/charge','ChargeController@get');
    Route::put('/charge/{charge_id}/{charge}','ChargeController@chargeListUpdate');
    
    Route::get('/getgraph','ChargeController@getGraph');
    Route::get('/getgraph2','ChargeController@getGraph2');
    
    Route::post('/setRating','TaskController@setRating');
    Route::post('/setRating2','TaskController@setRating2');
    Route::get('/getRating','TaskController@getRating');
    Route::get('/getRating2','TaskController@getRating2');
    Route::post('/setPart','TaskController@setPart');
    Route::post('/setPartFalse','TaskController@setPartFalse');
    Route::get('/getPart','TaskController@getPart');
    
    Route::get('/getText','TaskController@getText');
    Route::get('/getText2','TaskController@getText2');
    
    Route::post('/postTwitter', 'ShareController@store');  // Ajax
    
});

