<?php

Route::group(['prefix' => 'updates', 'namespace' => 'ShineOS\Core\Updates\Http\Controllers', 'middleware' => 'auth.access:updates'], function()
{
    Route::get('/', 'UpdatesController@index');
    Route::post('/check', 'UpdatesController@check');
    Route::get('/coreupdate/{date}/{version}', 'UpdatesController@coreupdate');

});
