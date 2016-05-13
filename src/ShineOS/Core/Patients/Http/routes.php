<?php

Route::group(['prefix' => 'patients', 'namespace' => 'ShineOS\Core\Patients\Http\Controllers', 'middleware' => 'auth.access:patients'], function()
{
    $r_alias = 'patients';
    Route::get('/', ['uses'=>'PatientsController@index', 'middleware' => 'auth.access:patients']);
    Route::post('/check', 'PatientsController@check');
    Route::get('/add', 'PatientsController@add');
    Route::post('/save', 'PatientsController@save');
    Route::get('/view/{id}', ['uses'=>'PatientsController@view', 'middleware' => 'auth.access:patients']);
    Route::get('/{id}', 'PatientsController@dashboard');
    Route::post('/{id}', 'PatientsController@save');
    Route::delete('/{id}', 'PatientsController@delete');
    Route::patch('/{id}/edit', 'PatientsController@update');
    Route::post('/{id}/update', 'PatientsController@update');
    Route::get('/{id}/delete', ['as' => "{$r_alias}.delete", 'uses' => 'PatientsController@delete']);
    Route::get('/delete/{id}', 'PatientsController@delete');
    Route::get('/undelete/{id}', 'PatientsController@undelete');

    Route::get('/consultations', 'PatientsController@consultations');
    Route::get('{id}/deathinfo', 'PatientsController@viewDeathInfo');
    Route::get('/{id}/checkPatientMorbidity', 'PatientsController@checkPatientMorbidity');
    Route::patch('/saveDeathInfo', 'PatientsController@saveDeathInfo');
    Route::post('/deathinfo', 'PatientsController@saveDeathInfo');

});
