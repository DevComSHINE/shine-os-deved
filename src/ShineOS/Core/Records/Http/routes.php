<?php

Route::group(['prefix' => 'records', 'namespace' => 'ShineOS\Core\Records\Http\Controllers', 'middleware' => 'auth.access:records'], function()
{
    Route::get('/', 'RecordsController@index');
    Route::post('/getpatients', 'RecordsController@loadpatients');
    Route::post('/gethealthcare', 'RecordsController@loadconsultations');

    Route::get('/search', 'RecordsController@search');
    Route::post('/search/getResults', 'RecordsController@getResults');

    Route::get('/{action}/{value}', 'RecordsController@getList');

});
