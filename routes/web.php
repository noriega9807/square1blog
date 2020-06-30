<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', ['as' => 'home', 'uses' => 'EntriesController@index']);

//authentication
Route::get('/logout', 'UserController@logout');
Route::group(['prefix' => 'auth'], function () {
  Auth::routes();
});

Route::get('entries/{slug}', ['as' => 'entries.show', 'uses' => 'EntriesController@show'])->where('slug', '[A-Za-z0-9-_]+');

// check for logged in user
Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'entries'], function () {
        // show new post form
        Route::get('create', ['as' => 'entries.create', 'uses' => 'EntriesController@create']);
        // save new post
        Route::post('store', ['as' => 'entries.store', 'uses' => 'EntriesController@create']);
        // delete post
        Route::get('delete/{id}', ['as' => 'entries.delete', 'uses' => 'EntriesController@delete']);
    });

    Route::group(['prefix' => 'user'], function () {
        // display user's all posts
        Route::get('myEntries',  ['as' => 'users.myEntries', 'uses' => 'UserController@myEntries']);
    });
    
});