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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Admin Related Routes

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@admin')    
    ->middleware('is_admin')    
    ->name('admin');

Route::get('/admin-image', 'ImageController@fetchImage');

Route::get('/upload', 'ImageController@uploadForm');
 
Route::post('/upload', 'ImageController@uploadSubmit');

Route::post('/solved', 'ImageController@markSolved');

// User Related Routes

Route::get('/', 'ImageController@displayImageMain');

Route::post('/guess', 'ImageController@guessFlick');