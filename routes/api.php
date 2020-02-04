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
    
    Route::get('/charge','ChargeController@get');
    Route::put('/chargeList/{charge_id}/{charge}','ChargeController@chargeListUpdate');
    
});

