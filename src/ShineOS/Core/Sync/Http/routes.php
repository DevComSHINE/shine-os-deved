<?php

Route::group(['prefix' => 'sync', 'middleware' => 'auth', 'namespace' => 'ShineOS\Core\Sync\Http\Controllers',], function()
{
	Route::get('/', 'SyncController@index');
	Route::get('/toCloud', 'SyncController@sendtoCloud');
	Route::get('/fromCloud', 'SyncController@downloadFromCloud');

});