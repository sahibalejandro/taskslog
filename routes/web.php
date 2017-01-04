<?php

/* API */
Route::group(['prefix' => 'api'], function () {
    /* Entries */
    Route::get('/entries/date/{date}', 'EntriesController@date');
    Route::delete('/entries/{id}', 'EntriesController@destroy');
    Route::post('/entries', 'EntriesController@store');

    /* Accounts */
    Route::get('/accounts', 'AccountsController@index');
    Route::post('/accounts', 'AccountsController@store');
    Route::get('/accounts/{id}/tasks', 'AccountTasksController@index');

    /* Tasks */
    Route::post('/tasks', 'TasksController@store');

    /* Reports */
    Route::get('/reports/{start_date}/{end_date}/{account_id?}', 'ReportsController@index');
});

/* Catch-all to use vue-router history mode */
Route::get('{any}', function () {
    return view('main');
})->where('any', '.*');
