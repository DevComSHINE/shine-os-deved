<?php
Route::group(['namespace' => '\ShineOS\Controllers'], function () {

    Route::any('default/', 'DefaultController@index');
    Route::any('default/track', 'DefaultController@track');
    Route::any('install/', 'InstallController@index');

    Route::any('plugin/{plugin_name}/{all}', 'PluginController@index');
    Route::any('plugin/call/{parent}/{plugin_name}/{all}/{ID}', 'PluginController@call');
    Route::any('plugin/saveBlob/{parent}/{plugin_name}/{ID}', 'PluginController@saveBlob');

    Route::any('default/updateM2', 'DefaultController@updateM2');
    Route::any('warehouse/updateM2', 'WarehouseController@updateM2');

    Route::any('warehouse/updateM1', 'WarehouseController@getM1_FP');
});
