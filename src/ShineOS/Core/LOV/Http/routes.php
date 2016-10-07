<?php

Route::group(['prefix' => 'lov', 'namespace' => 'ShineOS\Core\LOV\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'lov.index', 'uses' => 'LOVController@index']);

	/**
	 * Address
	 */
	Route::get('/api/region', ['as' => 'lov.region', 'uses' => 'LOVController@regionApi']);
    Route::get('/api/province', ['as' => 'lov.province', 'uses' => 'LOVController@provinceByRegionApi']);
    Route::get('/api/city', ['as' => 'lov.city', 'uses' => 'LOVController@cityByProvinceApi']);
    Route::get('/api/brgy', ['as' => 'lov.brgy', 'uses' => 'LOVController@brgyByCityApi']);

    /**
     * ICD10
     */
    Route::get('api/diagnosis/category', ['as' => 'imp.cat', 'uses' => 'LOVController@icd10CategoryByCode']);
    Route::get('api/diagnosis/subCat', ['as' => 'imp.cat', 'uses' => 'LOVController@icd10SubCategoryByCategory']);
    Route::get('api/diagnosis/subsubCat', ['as' => 'imp.cat', 'uses' => 'LOVController@icd10SubSubCategoryBySubCategory']);
});



