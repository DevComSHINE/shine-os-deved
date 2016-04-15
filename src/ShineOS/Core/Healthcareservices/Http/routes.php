<?php

Route::group(['prefix' => 'healthcareservices', 'namespace' => 'ShineOS\Core\Healthcareservices\Http\Controllers','middleware' => 'auth.access:healthcareservices'], function()
{

    Route::get('/', ['as' => 'healthcare.index', 'uses' => 'HealthcareservicesController@index']);
    Route::get('/{action}/{patiend_id}', ['as' => 'healthcare.add', 'uses' => 'HealthcareservicesController@index']);
    /** Follow up  */
    Route::get('/{action}/{patiend_id}/{hservice_id}', ['as' => 'healthcare.add', 'uses' => 'HealthcareservicesController@index']);
    Route::get('/{action}/{patiend_id}/{hservice_id}', ['as' => 'healthcare.edit', 'uses' => 'HealthcareservicesController@index']);

    Route::post('/insert', ['as' => 'healthcare.insert', 'uses' => 'HealthcareservicesController@insert']);
    Route::get('/view', ['as' => 'healthcare.view', 'uses' => 'HealthcareservicesController@view']);

    Route::post('/vitals/add', ['as' => 'vitals.insert', 'uses' => 'VitalsController@add']);
    Route::post('/vitals/edit', ['as' => 'vitals.edit', 'uses' => 'VitalsController@edit']);
    Route::post('/complaints/add', ['as' => 'complaints.insert', 'uses' => 'ComplaintsController@add']);
    Route::post('/complaints/edit', ['as' => 'complaints.edit', 'uses' => 'ComplaintsController@edit']);

    Route::post('/medorder/add', ['as' => 'medorder.insert', 'uses' => 'MedicalOrderController@UpdateCreate']);
    Route::get('/medorder/print/prescription/{id}', ['as' => 'medorder.printpresc', 'uses' => 'MedicalOrderController@printPrescription']);
    Route::get('/medorder/print/laboratory/{id}', ['as' => 'medorder.printlab', 'uses' => 'MedicalOrderController@printLaboratory']);

    Route::post('/disposition/add', ['as' => 'disposition.insert', 'uses' => 'DispositionController@add']);
    Route::post('/disposition/edit', ['as' => 'disposition.edit', 'uses' => 'DispositionController@edit']);

    Route::post('/impression-and-diagnosis/add', ['as' => 'imp.insert', 'uses' => 'ImpressionandDiagnosisController@UpdateCreate']);
    Route::post('/impression-and-diagnosis/edit', ['as' => 'imp.edit', 'uses' => 'ImpressionandDiagnosisController@UpdateCreate']);

    Route::post('/exam/add', ['as' => 'exam.insert', 'uses' => 'ExaminationsController@add']);
    Route::post('/exam/edit', ['as' => 'exam.edit', 'uses' => 'ExaminationsController@edit']);

    Route::post('/addendum/add', ['as' => 'addendum.add', 'uses' => 'AddendumController@add']);


});
