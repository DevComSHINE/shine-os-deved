<?php

/*Routes for system & warehouse controllers that do not need a logged in session*/
Route::group(['namespace' => '\ShineOS\Controllers'], function () {

    Route::any('default/', 'DefaultController@index');
    Route::any('default/track', 'DefaultController@track');
    Route::any('install/', 'InstallController@index');

    Route::any('default/updateM2', 'DefaultController@updateM2');
    Route::any('warehouse/updateM2', 'WarehouseController@updateM2');

    Route::any('warehouse/updateM1', 'WarehouseController@getM1_FP');
});

Route::group(['prefix' => 'plugin', 'namespace' => 'ShineOS\Controllers', 'middleware' => 'auth.access:users'], function()
{
    Route::any('/{plugin_name}/{all}', 'PluginController@index');
    Route::any('/call/{parent}/{plugin_name}/{all}/{ID}', 'PluginController@call');
    Route::any('/saveBlob/{parent}/{plugin_name}/{ID}', 'PluginController@saveBlob');
});
