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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/threads/{channel:slug}/{thread}/replies', 'ReplyController@store')->name('replies.store');
// Route::resource('threads', 'ThreadController');
Route::get('threads', 'ThreadController@index')->name('threads.index');
Route::get('threads/create', 'ThreadController@create')->name('threads.create');
Route::get('threads/{channel:slug}/{thread}', 'ThreadController@show')->name('threads.show');
Route::post('threads', 'ThreadController@store')->name('threads.store');

Route::get('threads/{thread}/edit', 'ThreadController@edit')->name('threads.edit');
Route::put('threads/{thread}/update', 'ThreadController@update')->name('threads.update');
Route::delete('threads/{thread}/delete', 'ThreadController@destroy')->name('threads.destroy');

Route::get('threads/{channel:slug}', 'ChannelController@index')->name('channels.index');
