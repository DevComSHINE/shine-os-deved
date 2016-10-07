<?php

Route::group(['prefix' => 'roles', 'namespace' => 'Modules\Roles\Http\Controllers', 'middleware' => 'auth.access:roles'], function()
{
	$r_alias = 'roles';

	Route::get('/', ['as' => "{$r_alias}", 'uses' => 'RolesController@index']);
	Route::get('/add', 'RolesController@add');
	Route::get('/add/feature', 'FeaturesController@add');
	Route::post('/add', 'RolesController@store');
	Route::get('/{id}', 'RolesController@view');
	Route::put('/{id}', 'RolesController@update');
	Route::patch('/{id}', ['as' => "{$r_alias}.update", 'uses' => 'RolesController@update'] );
	Route::delete('/{id}', 'RolesController@destroy');
	Route::get('/delete/{id}', 'RolesController@delete');
	Route::get('/{id}/edit', ['as' => "{$r_alias}.edit", 'uses' => 'RolesController@edit']);

	/**
	 * Routes for Features
	 */
	Route::post('/add_feature', 'FeaturesController@store');
	Route::get('/edit/feature', ['as' => "{$r_alias}.edit.feature", 'uses' => 'FeaturesController@add']);
	Route::get('/feature/delete', 'FeaturesController@store');
});