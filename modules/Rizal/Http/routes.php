<?php

Route::group(['prefix' => 'rizal', 'namespace' => 'Modules\Rizal\Http\Controllers', 'middleware' => 'auth.access:rizal'], function()
{
    Route::get('/', 'RizalController@index');

});
