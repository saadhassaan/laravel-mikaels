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
Route::group ( ['middleware' => 'auth.jwt'], function () {

    Route::apiResources([
        'comments' => 'CommentController',
        'likes' => 'LikeController',
        'posts' => 'PostController'
    ]);
});


Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

