<?php

Route::group(['prefix' => 'analytics', 'namespace' => 'ShineOS\Core\Http\Controllers', 'middleware' => 'auth.access:analytics'], function()
{
    Route::get('/', 'AnalyticsController@index');
    Route::get('/{type}/{date1}/{date2}', 'AnalyticsController@getData');
    Route::post('/display', 'AnalyticsController@display');
});
