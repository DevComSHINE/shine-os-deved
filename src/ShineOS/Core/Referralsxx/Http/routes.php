<?php
/** Route for Referrals */
Route::group(['prefix' => 'referrals', 'namespace' => 'ShineOS\Core\Referrals\Http\Controllers'], function()
{
	/**
	 * Get:: Listing of Inbound referral
	 */
	Route::get('/', ['as' => 'referrals.inbound', 'uses' => 'ReferralsController@index']);
	Route::get('/inbound', ['as' => 'referrals.inbound', 'uses' => 'ReferralsController@index']);

	/**
	 * Get:: Listing of Outbound referral
	 */
	Route::get('/outbound', ['as' => 'referrals.outbound', 'uses' => 'ReferralsController@outboundDraft']);
	/**
	 * Post:: Follow up referral from outbound
	 * @param  string $tableId Referral Id to follow up
	 */
	Route::post('/outbound/{tableId}', ['as' => 'referrals.followup', 'uses' => 'ReferralsController@addfollowup']);
	
	/**
	 * Get:: Listing of Drafts referral
	 */
	Route::get('/drafts', ['as' => 'referrals.drafts', 'uses' => 'ReferralsController@outboundDraft']);

	/**
	 * Get:: Listing of referral messages
	 */
	Route::get('/messages', ['as' => 'referrals.messages', 'uses' => 'ReferralsController@messages']); 

	/**
	 * Get:: View selected referral message 
	 * @param string $id referral id join referral message
	 */
	Route::get('/messages/{id}', ['as' => 'referrals.viewmessage', 'uses' => 'ReferralsController@viewmessage']);

	/**
	 * Post:: Reply to follow up
	 * @param  string $tableId Referral Id to follow up
	 */
	Route::post('/reply/{tableId}', ['as' => 'referrals.reply', 'uses' => 'ReferralsController@replyToFollowUp']);

	/**
	 * Create Referral
	 */
	Route::get('/add/{patientid}', ['as' => 'referrals.add', 'uses' => 'ReferralsController@createreferral']);
	Route::post('/add', ['as' => 'referrals.insert', 'uses' => 'ReferralsController@add']);

	/**
	 * Post:: Send and discard drafts messages
	 * @param  string $tableId Referral Id to send
	 */
	Route::post('/drafts/{tableId}', ['as' => 'referrals.senddiscard', 'uses' => 'ReferralsController@senddiscard']); 

	/**
	 * Post:: Accept and decline inbound messages
	 * @param  string $tableId Referral Id to send
	 */
	Route::post('/inbound/{tableId}', ['as' => 'referrals.acceptdecline', 'uses' => 'ReferralsController@acceptdecline']);
	
	/**
	 * Get:: View selected referral
	 * @param  string $type Referral types: inbound, outbound and drafts
	 * @param  string $tableId Referral Id to view
	 */
	Route::get('/{type}/{tableId}', ['as' => 'referrals.viewreferral', 'uses' => 'ReferralsController@viewreferral']);
});