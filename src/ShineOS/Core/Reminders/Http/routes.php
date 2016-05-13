<?php
/**
 * Route for Reminders
 */
Route::group(['prefix' => 'reminders', 'namespace' => 'ShineOS\Core\Reminders\Http\Controllers', 'middleware' => 'auth.access:reminders'], function()
{
    /**
     * Get:: Reminders listings
     */
    Route::get('/', ['as' => 'reminders', 'uses' => 'RemindersController@index']);
    /**
     * Get:: Set a reminder to a patient
     * @param  string $patiend_id
     */
    Route::get('/add/{patiend_id}', ['as' => 'reminders.add', 'uses' => 'RemindersController@createreminder']);
    /**
     * Post:: Insert a reminder to a patient
     * @param  string $patiend_id
     */
    Route::post('/add', ['as' => 'reminders.insert', 'uses' => 'RemindersController@insertReminder']);
    /**
     * Post:: Delete a reminder
     * @param  string $reminder_id
     */
    Route::get('/delete/{reminder_id}', ['as' => 'reminders.delete', 'uses' => 'RemindersController@deleteReminderBroadcast']);

    Route::get('/cronReminders', ['uses' => 'RemindersController@cronReminders']);
    Route::get('/testemail', ['uses' => 'RemindersController@testemail']);

});
/**
 * Route for Broadcasts
 */
Route::group(['prefix' => 'broadcast', 'namespace' => 'ShineOS\Core\Reminders\Http\Controllers', 'middleware' => 'auth.access:reminders'], function()
{
    /**
     * Broadcasts listings
     */
    Route::get('/', ['as' => 'broadcast', 'uses' => 'RemindersController@broadcastlist']);
    /**
     * Get:: Set a broadcast to either patient or user
     */
    Route::get('/add', ['as' => 'broadcast.add', 'uses' => 'RemindersController@createbroadcast']);
    /**
     * Post:: Insert a broadcast to either patient or user
     */
    Route::post('/add', ['as' => 'broadcast.insert', 'uses' => 'RemindersController@insertBroadcast']);
    /**
     * Post:: Delete a broadcast
     * @param  string $reminder_id
     */
    Route::get('/delete/{reminder_id}', ['as' => 'broadcast.delete', 'uses' => 'RemindersController@deleteReminderBroadcast']);
});

