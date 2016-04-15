<?php

Route::group(['prefix' => 'extensions', 'namespace' => 'ShineOS\Core\Extensions\Http\Controllers', 'middleware' => 'auth.access:settings'], function()
{
    Route::get('/', 'ExtensionsController@index');
    Route::get('/modules', 'ExtensionsController@modules');
    Route::get('/plugins', 'ExtensionsController@plugins');
    Route::get('/widgets', 'ExtensionsController@widgets');
    Route::post('/add/{type}', 'ExtensionsController@add');
    Route::post('/install/{type}', 'ExtensionsController@install');

    Route::post('/update', 'ExtensionsController@update');

    Route::get('/add', 'ExtensionsController@add');

});
