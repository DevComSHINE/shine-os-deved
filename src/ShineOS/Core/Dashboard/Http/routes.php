<?php

Route::group(['prefix' => 'dashboard', 'namespace' => 'ShineOS\Core\Dashboard\Http\Controllers'], function()
{
    $r_alias = 'dashboard';

    Route::get('/', ['as' => "home", 'uses' => 'DashboardController@index']);
});
