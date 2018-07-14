<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Admin Related Routes

Route::get('/admin', 'ImageController@fetchImage')
	->middleware('is_admin')
	->name('admin');

Route::get('/upload', 'ImageController@uploadForm');
 
Route::post('/upload', 'ImageController@uploadSubmit');

Route::post('/solved', 'ImageController@markSolved');

// User Related Routes

Route::get('/', 'ImageController@displayImageMain');

Route::post('/guess', 'ImageController@guessFlick');

Route::get('/results', 'ResultsController@getResults')
	->name('results');

// Testing Page

Route::get('/test', 'ResultsController@getResults')
	->name('test');	