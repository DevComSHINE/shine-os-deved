<?php

Route::group(['prefix' => 'facilities', 'namespace' => 'ShineOS\Core\Facilities\Http\Controllers', 'middleware' => 'auth.access:facilities'], function()
{
    Route::get('/', 'FacilitiesController@facilities');

    Route::get('/changelogo/{id}', 'FacilitiesController@changelogo');
    Route::post('/changelogo_update/{id}', 'FacilitiesController@changelogo_update');

    Route::post('/updatefacilityinfo/{id}', 'FacilitiesController@updatefacilityinfo');
    Route::post('/updatefacilitycontact/{id}', 'FacilitiesController@updatefacilitycontact');
    Route::post('/updatespecialization/{id}', 'FacilitiesController@updatespecialization');

    //Route::get('/{id}/facilities', 'UsersController@facilities'); // PLEASE TRANSFER TO FACILITY MODULE
    //Route::get('/{id}/logs', 'UsersController@auditTrail'); // PLEASE TRANSFER TO FACILITY MODULE
    //Route::get('/{id}/permissions', 'UsersController@permissions'); // PLEASE TRANSFER TO FACILITY MODULE
});
