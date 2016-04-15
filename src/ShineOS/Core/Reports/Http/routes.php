<?php

Route::group(['prefix' => 'reports', 'namespace' => 'ShineOS\Core\Reports\Http\Controllers', 'middleware' => 'auth.access:reports'], function()
{
    Route::get('/', 'ReportsController@index');
    Route::post('/getpatientinfo', 'ReportsController@getReportDataJSON');
    Route::post('/graph', 'ReportsController@getFilteredResults');
    Route::get('/m1', ['as' => 'fhsis.m1', 'uses' => 'ReportsController@m1'])->where('type', '[a-zA-Z0-9]+');
    
    Route::get('/m2', ['as' => 'fhsis.m2', 'uses' => 'ReportsController@m2'])->where('type', '[a-zA-Z0-9]+');
    Route::post('/m2', ['as' => 'fhsis.m2', 'uses' => 'ReportsController@m2'])->where('type', '[a-zA-Z0-9]+');

    Route::get('/q1', ['as' => 'fhsis.q1', 'uses' => 'ReportsController@q1'])->where('type', '[a-zA-Z0-9]+');
    Route::get('/q2', ['as' => 'fhsis.q2', 'uses' => 'ReportsController@q2'])->where('type', '[a-zA-Z0-9]+');
    Route::get('/abrgy', ['as' => 'fhsis.abrgy', 'uses' => 'ReportsController@abrgy'])->where('type', '[a-zA-Z0-9]+');
    Route::get('/a1', ['as' => 'fhsis.a1', 'uses' => 'ReportsController@a1'])->where('type', '[a-zA-Z0-9]+');

    Route::get('/a2', ['as' => 'fhsis.a2', 'uses' => 'ReportsController@a2'])->where('type', '[a-zA-Z0-9]+');
    Route::post('/a2', ['as' => 'fhsis.a2', 'uses' => 'ReportsController@a2'])->where('type', '[a-zA-Z0-9]+');

    Route::get('/a3', ['as' => 'fhsis.a3', 'uses' => 'ReportsController@a3'])->where('type', '[a-zA-Z0-9]+');
    Route::post('/a3', ['as' => 'fhsis.a3', 'uses' => 'ReportsController@a3'])->where('type', '[a-zA-Z0-9]+');
});
