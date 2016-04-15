<?php

Route::group(['prefix' => 'calendar', 'namespace' => 'Modules\Calendar\Http\Controllers', 'middleware' => 'auth.access:calendar'], function()
{
    Route::get('/', 'CalendarController@index');

    Route::get('/events', 'CalendarController@getEventData');
    Route::post('/events/insert', 'CalendarController@insertNewEvent');
    Route::post('/events/update', 'CalendarController@update');
    Route::post('/events/moved', 'CalendarController@moved');
    Route::post('/events/delete', 'CalendarController@delete');
});
