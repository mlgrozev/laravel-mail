<?php

Route::resource('email', 'EmailController', ['only' => ['index', 'show', 'destroy']]);
//Route::get('email/{email}', 'EmailController@show');
Route::get('/', 'EmailController@index');
