<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/entries/date/{date}', 'EntriesController@date');
Route::delete('/entries/{id}', 'EntriesController@destroy');
Route::post('/entries', 'EntriesController@store');
Route::get('/accounts', 'AccountsController@index');
Route::post('/accounts', 'AccountsController@store');
Route::get('/accounts/{id}/tasks', 'AccountTasksController@index');
Route::post('/tasks', 'TasksController@store');
