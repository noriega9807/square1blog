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
Route::get('/home', ['as' => 'home', 'uses' => 'EntriesController@index']);

//authentication
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('entries/post/{slug}', ['as' => 'entries.show', 'uses' => 'EntriesController@show'])->where('slug', '[A-Za-z0-9-_]+');

// check for logged in user
Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'entries'], function () {
        // show new entry form
        Route::get('create', ['as' => 'entries.create', 'uses' => 'EntriesController@create']);
        // save new entry
        Route::post('store', ['as' => 'entries.store', 'uses' => 'EntriesController@store']);
        // import entries
        Route::post('import', ['as' => 'entries.import', 'uses' => 'EntriesController@import']);
    });

    Route::group(['prefix' => 'user'], function () {
        // display user's all posts
        Route::get('myEntries',  ['as' => 'users.myEntries', 'uses' => 'UserController@myEntries']);
    });
    
});