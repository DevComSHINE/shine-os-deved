<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function()
{
    if ( shineos_is_installed() ){
        return Redirect::to('dashboard/');
    } else {
        return Redirect::to('default/');
    }
});

Route::get('/selectfacility', function () {
    return view('users::pages.selectfacility');
});
