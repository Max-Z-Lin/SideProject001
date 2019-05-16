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

Route::post('register', 'UserController@register')->name('user.register');
Route::post('login', 'UserController@login');

Route::get('mail', 'UserController@sendMail');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('getUser', 'UserController@getAuthUser');
    Route::post('updateUser', 'UserController@updateAuthUser');
    Route::delete('deleteUser', 'UserController@softDelete');

    Route::group(['prefix' => 'image'], function () {
        Route::post('upload', 'ImageController@uploadImage');
        Route::get('read', 'ImageController@readImage');
    });


});