<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'UsersController@getDashboard');
Route::controller('users', 'UsersController');
//Settings: create a new setting
Route::get( '/users', array(
    'as' => 'users.dashboard',
    'uses' => 'UsersController@getDashboard'
) );

Route::post( '/users/myoffers', array(
    'as' => 'users.myoffers',
    'uses' => 'UsersController@myoffers'
) );